<?php

namespace App\Http\Controllers;

use App\Models\DetailAddress;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(){
        return view('login');
    }

    public function register(){
        $provinces = Province::all();
        return view('register', compact('provinces'));
    }

     public function postlogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            if(Auth::user()->level == 'admin'){
                $request->session()->regenerate();
                return redirect('/admin/dashboard');
            }
            elseif(Auth::user()->level == 'vendor'){
                $request->session()->regenerate();
                return redirect('/vendor/dashboard');
            }
            elseif(Auth::user()->level == 'user'){
                $request->session()->regenerate();
                return redirect('/')->with('success', 'Selamat datang, ' . Auth::user()->name . '!');
            }else{
                return back()->withErrors([
                    'email' => 'Email Atau Password Salah'
                ])->onlyInput('email');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
        
    }

    public function postregister(Request $request)
    {
        // dd($request);
        // Validate request
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6|confirmed',
            'alamat'      => 'required',
            'no_telp'     => 'required',
            'province_id' => 'required',
            'city_id'     => 'required',
            'district_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'alamat'   => $request->alamat,
            'no_telp'  => $request->no_telp,
            'level'    => 'user',
        ]);

        // Create detail address
        DetailAddress::create([
            'user_id'     => $user->id,
            'address'     => $request->alamat,
            'post_code'     => $request->post_code,
            'province_id' => $request->province_id,
            'city_id'     => $request->city_id,
            'district_id' => $request->district_id,
            'village_id'  => $request->village_id,
        ]);


        if ($user->level === 'user') {
            Auth::login($user);
            return redirect('/'); // or wherever you want to go
        }

        // If level is not 'user', redirect to login
        return redirect('/login')->with('success', 'Registration successful. Please login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function getCities($provinceId)
    {
        $cities = City::where('province_code', $provinceId)->get(); 
        return response()->json($cities);
    }

    public function getDistricts($cityId)
    {
        $districts = District::where('city_code', $cityId)->get();
        return response()->json($districts);
    }

    public function getVillages($districtId)
    {
        $villages = Village::where('district_code', $districtId)->get();
        return response()->json($villages);
    }
}


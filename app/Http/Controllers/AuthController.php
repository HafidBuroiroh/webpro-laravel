<?php

namespace App\Http\Controllers;

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
        return view('register');
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
                return redirect('/');
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
        // Validate request
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'alamat'   => 'required|string|max:255',
            'no_telp'  => 'required|string|max:20',
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
}


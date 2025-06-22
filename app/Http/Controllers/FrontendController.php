<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\PKH;
use App\Models\Artikel;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Laravolt\Indonesia\Models\Province;

class FrontendController extends Controller
{
    public function index(){
        $pet = Pet::inRandomOrder()->limit(4)->with(['penjualan', 'adopsi'])->get();
        return view('frontend.beranda', compact('pet'));
    }

    public function adopt(){
        $pet = Pet::where('status', 'adopsi')->whereHas('adopsi', function($q){
            $q->where('status', 'tersedia');
        })->get();

        return view('frontend.adopt', compact('pet'));
    }

    public function petshop(){
        $petjual = Pet::where('status', 'dijual')->whereHas('penjualan', function($q){
            $q->where('status', 'tersedia');
        })->get();

        $pkh = PKH::all();
        return view('frontend.petshop', compact('petjual', 'pkh'));
    }

    public function other(){
        $article = Artikel::all();
        return view('frontend.other', compact('article'));
    }

    public function cart(){
        $cart = Cart::where('id_user', Auth::id())->get();
        $user = User::where('id', Auth::id())->first();
        return view('frontend.cart', compact('cart', 'user'));
    }

    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'id_pkh' => 'required|exists:penjualan_kebutuhan_hewan,id',
            ]);

            $userId = Auth::id();
            $productId = $request->id_pkh;

            // Cek apakah produk sudah ada di cart
            $existingCart = Cart::where('id_user', $userId)
                                ->where('id_pkh', $productId)
                                ->first();

            if ($existingCart) {
                // Kalau produk sudah ada, tambahkan qty
                $existingCart->qty += 1;
                $existingCart->save();
            } else {
                // Kalau produk belum ada, buat baru
                Cart::create([
                    'id_user' => $userId,
                    'id_pkh' => $productId,
                    'qty' => 1
                ]);
            }

            return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id) {
        $cart = Cart::findOrFail($id);
        $cart->qty = $request->quantity;
        $cart->save();

        return response()->json(['message' => 'Quantity updated successfully']);
    }

    public function destroy($id) {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }

    public function petDetail($id)
    {
        $pet = Pet::with(['adopsi', 'penjualan'])->findOrFail($id);
        return view('frontend.detail', compact('pet'));
    }

    public function productDetail($id)
    {
        $product = PKH::findOrFail($id);
        return view('frontend.detailpkh', compact('product'));
    }

    public function artikeldetail($slug)
    {
        $article = Artikel::where('slug', $slug)->get()->first();
        return view('frontend.detailartikel', compact('article'));
    }

    public function updateqty(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->qty = $request->quantity;
        $cart->save();

        return response()->json(['message' => 'Quantity updated successfully.']);
    }

    public function deletecart($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->json(['message' => 'Item removed from cart successfully.']);
    }

    public function getShippingCost(Request $request, $districtId)
    {
        // Example of a static origin city ID
        $origin = '327606'; 
        $destination = $districtId; 
        $selectedItems = $request->input('selected_items', []);

        $totalWeight = 0;

        foreach ($selectedItems as $cartId) {
            $cart = Cart::with('pkh')->find($cartId);
            if ($cart && $cart->pkh) {
                $totalWeight += $cart->pkh->weight * $cart->qty;
            }
        }

        if ($totalWeight == 0) {
            return response()->json([
                'shipping_cost' => 0,
                'grand_total' => 0,
                'total_weight' => 0
            ]);
        }

        $courier = 'jne';

        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $totalWeight,
            'courier' => $courier
        ]);

        $shippingCost = 0;
        if ($response->successful()) {
            $cost = $response->json();
            if (isset($cost['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'])) {
                $shippingCost = $cost['rajaongkir']['results'][0]['costs'][0]['cost'][0]['value'];
            }
        }

        $selectedTotal = 0;
        foreach ($selectedItems as $cartId) {
            $cart = Cart::with('pkh')->find($cartId);
            if ($cart && $cart->pkh) {
                $selectedTotal += $cart->pkh->harga * $cart->qty;
            }
        }

        return response()->json([
            'shipping_cost' => $shippingCost,
            'grand_total' => $selectedTotal + $shippingCost,
            'total_weight' => $totalWeight
        ]);
    }

    public function getShippingService(Request $request)
    {
        $origin = '327606'; // Depok code
        $destination = $request->district_code;
        $courier = $request->courier;
        $weight = $request->weight;

        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        ]);

        $services = [];

        if ($response->successful()) {
            $costs = $response->json()['rajaongkir']['results'][0]['costs'];

            foreach ($costs as $cost) {
                $services[] = [
                    'service' => $cost['service'],
                    'cost' => $cost['cost'][0]['value']
                ];
            }
        }

        return response()->json(['services' => $services]);
    }

    public function checkoutView(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected_cart_ids'));

        $carts = Cart::with('pkh')->whereIn('id', $selectedIds)->get();

        $totalWeight = 0;
        $totalPrice = 0;

        foreach ($carts as $cart) {
            $totalPrice += $cart->pkh->harga * $cart->qty;
            $totalWeight += $cart->pkh->weight * $cart->qty;
        }

        return view('frontend.checkout', compact('carts', 'totalPrice', 'totalWeight'));
    }

    public function process(Request $request)
    {
        $selectedItems = $request->input('selected_items');
        $shippingCost = $request->input('shipping_cost');
        $grandTotal = $request->input('grand_total');

        // You can create an order here and reduce stock

        \App\Models\Cart::whereIn('id', $selectedItems)->delete();

        return redirect()->route('cart')->with('success', 'Order placed successfully!');
    }

    public function setting(){
        $user = Auth::user();
        $provinces = Province::all();
        return view('frontend.user-dashboard', compact('user', 'provinces'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => '',
            'new_password' => 'min:6',
            'confirm_password' => 'same:new_password',
        ]);

        $user = User::where('id', Auth::id())->first();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password successfully updated.');
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'alamat' => '',
            'province_code' => '',
            'city_code' => '',
            'district_code' => '',
        ]);

        $user = User::where('id', Auth::id())->first();
        $user->update([
            'alamat' => $request->alamat,
        ]);

        $detailAddress = $user->detailaddress()->first();

        if ($detailAddress) {
            // Update dengan fallback ke data lama jika request tidak diisi
            $detailAddress->update([
                'address' => $request->alamat ?? $detailAddress->address,
                'province_id' => $request->province_code ?? $detailAddress->province_id,
                'city_id' => $request->city_code ?? $detailAddress->city_id,
                'district_id' => $request->district_code ?? $detailAddress->district_id,
                'village_id' => $request->village_code ?? $detailAddress->village_id,
                'post_code' => $request->post_code ?? $detailAddress->post_code,
            ]);
        }


        return redirect()->back()->with('success', 'Address successfully updated.');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|max:255',
            'no_telp' => 'number',
        ]);

        $user = User::where('id', Auth::id())->first();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->back()->with('success', 'Profile successfully updated.');
    }

    public function search(Request $request){
        $query = $request->input('query');
        $pet = Pet::where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('nama_pet', 'LIKE', "%$query%")
                    ->orWhere('jenis', 'LIKE', "%$query%")
                    ->orWhere('deskripsi', 'LIKE', "%$query%");
            })
            ->where(function ($q) {
                $q->whereHas('adopsi', function ($adopsi) {
                    $adopsi->where('status', 'tersedia');
                })
                ->orWhereHas('penjualan', function ($penjualan) {
                    $penjualan->where('status', 'tersedia');
                });
            })
            ->get();
        $pkh = PKH::where('nama', 'LIKE', "%$query%")->get();

        return view('frontend.search', compact('pet', 'query', 'pkh'));
    }

}

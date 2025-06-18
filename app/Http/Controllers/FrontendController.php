<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\PKH;
use App\Models\Artikel;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FrontendController extends Controller
{
    public function index(){
        $pet = Pet::inRandomOrder()->limit(4)->with(['penjualan', 'adopsi'])->get();
        return view('frontend.beranda', compact('pet'));
    }

    public function adopt(){
        $pet = Pet::where('status', 'adopsi')->with(['adopsi'])->get();
        return view('frontend.adopt', compact('pet'));
    }

    public function petshop(){
        $petjual = Pet::with(['penjualan' => function($q) {
            $q->where('status', 'tersedia');
        }])->where('status', 'dijual')->get();

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
        $request->validate([
            'id_pkh' => 'required|exists:penjualan_kebutuhan_hewan,id',
        ]);

        Cart::create([
            'id_user' => Auth::id(),
            'id_pkh' => $request->id_pkh,
            'qty' => 1,
        ]);

        return response()->json([
            'message' => 'Item added to cart successfully!',
        ]);
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

}

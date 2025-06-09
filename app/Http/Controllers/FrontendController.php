<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\PKH;
use App\Models\Artikel;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

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
        return view('frontend.cart', compact('cart'));
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

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Pengiriman;
use App\Models\PKH;
use App\Models\ProductTransaction;
use App\Models\TransaksiPKH;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function checkoutView(Request $request)
    {
        if (!$request->has('selected_cart_ids')) {
            return redirect()->route('cart')->with('error', 'Please select items to checkout.');
        }

        $selectedCartIds = explode(',', $request->input('selected_cart_ids'));
        $carts = \App\Models\Cart::with('pkh')->whereIn('id', $selectedCartIds)->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        $defaultAddress = DB::table('detail_address as da')
            ->join('indonesia_provinces as p', 'da.province_id', '=', 'p.code')
            ->join('indonesia_cities as c', 'da.city_id', '=', 'c.code')
            ->join('indonesia_districts as d', 'da.district_id', '=', 'd.code')
            ->where('da.user_id', Auth::id())
            ->select('da.id', 'da.address', 'da.post_code', 'c.rajaongkir_city_id', 'p.name as province_name', 'c.name as city_name', 'd.name as district_name')
            ->first();

        if ($defaultAddress) {
            $defaultAddress->full_address = "{$defaultAddress->address}, {$defaultAddress->district_name}, {$defaultAddress->city_name}, {$defaultAddress->province_name}, {$defaultAddress->post_code}";
        }
        // dd($defaultAddress);

        $totalWeight = 0;
        $productTotal = 0;
        foreach ($carts as $cart) {
            $productTotal += $cart->pkh->harga * $cart->qty;
            $totalWeight += ($cart->pkh->weight ?? 0) * $cart->qty;
        }

        return view('frontend.checkout', [
            'carts' => $carts,
            'defaultAddress' => $defaultAddress,
            'totalWeight' => $totalWeight,
            'productTotal' => $productTotal,
            'selectedCartIds' => $selectedCartIds
        ]);
    }

    public function getShippingCost(Request $request)
    {
        // Validasi input
        $request->validate([
            'destination_id' => 'required',
            'weight' => 'required|integer',
            'courier' => 'required|string',
        ]);

        try {
            // Origin Kota Depok (Jawa Barat) city_id RajaOngkir
            $origin = '114';
            $destination = $request->destination_id;
            $weight = $request->weight;
            $courier = $request->courier;

            // Call API RajaOngkir
            $response = Http::withHeaders([
                'key' => '794a5d197b9cb469ae958ed043ccf921', // Ganti dengan API Key kamu
            ])->post('https://api.rajaongkir.com/starter/cost', [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier,
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json(['error' => 'Failed to get shipping cost.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function processCheckout(Request $request)
    {
            try {
            $request->validate([
                'id_pkh' => 'required|array',
                'id_pkh.*' => 'exists:penjualan_kebutuhan_hewan,id',
                'qty' => 'required|array',
                'qty.*' => 'required|integer|min:1',
                'courier' => 'required',
                'shipping_cost' => 'required|numeric',
            ]);

            $user = Auth::user();

            // Hitung total transaksi
            $totalProductPrice = 0;

            foreach ($request->id_pkh as $index => $pkhId) {
                $product = PKH::findOrFail($pkhId);
                $totalProductPrice += $product->harga * $request->qty[$index];
            }

            $grandTotal = $totalProductPrice + $request->shipping_cost;

            // Buat transaksi tunggal
            $newId = TransaksiPKH::max('id') + 1;
            $name = 'TO/' . now()->format('Y') . '/' . str_pad($newId, 4, '0', STR_PAD_LEFT);

            $transaction = TransaksiPKH::create([
                'name' => $name,
                'tgl_transaksi' => now(),
                'total_transaksi' => $grandTotal,
                'status' => 'delay',
                'user_id' => $user->id,
            ]);

            // Simpan detail produk di ProductTransaction
            foreach ($request->id_pkh as $index => $pkhId) {
                $product = PKH::findOrFail($pkhId);
                $productTotal = $product->harga * $request->qty[$index];

                ProductTransaction::create([
                    'transaksi_pkh_id' => $transaction->id,
                    'id_pkh' => $product->id,
                    'qty' => $request->qty[$index],
                    'subtotal' => $productTotal,
                ]);
            }

            // Buat data pengiriman
            Pengiriman::create([
                'id_transaksi_pkh' => $transaction->id,
                'kurir' => $request->courier,
                'biaya_ongkir' => $request->shipping_cost,
                'pembayaran' => 'transfer',
                'total_biaya' => $grandTotal,
                'status' => 'diperjalanan',
                'id_user' => $user->id,
            ]);

            // Hapus cart setelah checkout
            Cart::where('id_user', Auth::id())
                ->whereIn('id_pkh', $request->id_pkh)
                ->delete();

            return redirect()->route('checkout.payment', $transaction->id)->with('success', 'Transaksi berhasil dibuat.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat proses checkout: ' . $e->getMessage());
        }
    }

    public function paymentPage($id)
    {
         $transaction = TransaksiPKH::findOrFail($id);
        //  dd($transaction->user);

        // ✅ Setup Midtrans Config
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key'); // sebenarnya tidak wajib kalau di backend
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // ✅ Setup Transaction
        $params = [
            'transaction_details' => [
                'order_id' => $transaction->name,
                'gross_amount' => (int)$transaction->total_transaksi,
            ],
            'customer_details' => [
                'name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ],
        ];

        // ✅ Get Snap Token
        $snapToken = Snap::getSnapToken($params);

        return view('frontend.payment', compact('transaction', 'snapToken'));
    }

    public function simulateSuccess($id)
    {
        $transaction = TransaksiPKH::findOrFail($id);
        $transaction->status = 'dikemas'; 
        $transaction->save();

        return redirect('/checkout-success')->with('success', 'Pembayaran berhasil disimulasikan.');
    }

    public function history()
    {
        $transactions = TransaksiPKH::with(['productTransactions.product'])
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        return view('frontend.transaction', compact('transactions'));
    }


    public function detailTransaction($id)
    {
        $transaction = TransaksiPKH::with(['productTransactions.product', 'user'])->findOrFail($id);

        return view('frontend.transaction-detail', compact('transaction'));
    }

    public function confirmTransaction($id)
    {
        $transaction = TransaksiPKH::findOrFail($id);

        if ($transaction->status != 'dikirim') {
            return redirect()->back()->withErrors(['checkout_error' => 'Transaction cannot be confirmed.']);
        }

        $transaction->update(['status' => 'berhasil']);

        return redirect()->back()->with('success', 'Transaction has been marked as received.');
    }

    public function cancelTransaction($id)
    {
        $transaction = TransaksiPKH::findOrFail($id);

        if ($transaction->status != 'dikemas') {
            return redirect()->back()->withErrors(['checkout_error' => 'Transaction cannot be cancelled.']);
        }

        $transaction->update(['status' => 'dibatalkan']);

        return redirect()->back()->with('success', 'Transaction has been cancelled.');
    }


}

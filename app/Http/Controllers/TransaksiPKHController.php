<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPKH;
use Illuminate\Http\Request;

class TransaksiPKHController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = TransaksiPKH::with(['user', 'productTransactions.product'])->orderBy('id', 'desc')->get();
        return view('backend.transaksipkh.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = TransaksiPKH::with('productTransactions.product', 'user', 'pengiriman')->findOrFail($id);
        return view('backend.transaksipkh.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:dikemas,dikirim,berhasil,dibatalkan',
        ]);

        $transaksi = TransaksiPKH::findOrFail($id);
        $transaksi->status = $request->status;
        $transaksi->save();

        return redirect()->back()->with('success', 'Status pengiriman berhasil diupdate.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiPKH $transaksiPKH)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransaksiPKH $transaksiPKH)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiPKH $transaksiPKH)
    {
        //
    }
}

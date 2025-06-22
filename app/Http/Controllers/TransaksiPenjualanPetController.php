<?php

namespace App\Http\Controllers;

use App\Models\PenjualanPet;
use App\Models\TransaksiPenjualanPet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiPenjualanPetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksi = TransaksiPenjualanPet::all();
        return view('backend.transaksi-jubel.index', compact('transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penjualans = PenjualanPet::where('status', 'tersedia')->get();
        return view('backend.transaksi-jubel.create', compact('penjualans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_penjualan' => 'required',
            'tgl_transaksi' => 'required|date',
            'keterangan' => 'required',
        ]);

        $pp = PenjualanPet::where('id', $request->id_penjualan)->first();
        
        TransaksiPenjualanPet::create([
            'id_penjualan' => $request->id_penjualan,
            'tgl_transaksi' => $request->tgl_transaksi,
            'total_transaksi' => $pp->harga,
            'user_id' => Auth::id(),
            'keterangan' => $request->keterangan,
        ]);

        
        $pp->status = 'terjual';
        $pp->save();

        return redirect('admin/transaksi-penjualan')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = TransaksiPenjualanPet::findorfail($id);
        return view('backend.transaksi-jubel.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaksi = TransaksiPenjualanPet::findorfail($id);
        return view('backend.transaksi-jubel.edit', compact('transaksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {        
        $transaksi = TransaksiPenjualanPet::findorfail($id);
        $transaksi->update([
            'id_penjualan' => $request->id_penjualan,
            'tgl_transaksi' => $request->tgl_transaksi,
            'user_id' => Auth::id(),
            'keterangan' => $request->keterangan,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaksi = TransaksiPenjualanPet::findorfail($id);
        $transaksi->delete();

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }
}

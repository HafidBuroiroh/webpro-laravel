<?php

namespace App\Http\Controllers;

use App\Models\TransaksiAdopsi;
use App\Models\Adopsi;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiAdopsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksi = TransaksiAdopsi::all();
        return view('backend.transaksi-adopt.index', compact('transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $adopsis = Adopsi::where('status', 'tersedia')->get();
        $users = User::all();
        $vendors = Vendor::all();
        return view('backend.transaksi-adopt.create', compact('adopsis', 'users', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'id_adopt' => 'required',
            'tgl_transaksi' => 'required|date',
            'status' => 'required|in:menunggu,berhasil,dibatalkan',
        ]);

        $adopsi = Adopsi::where('id', $request->id_adopt)->first();

        TransaksiAdopsi::create([
            'id_adopt' => $request->id_adopt,
            'tgl_transaksi' => $request->tgl_transaksi,
            'total_transaksi' => $adopsi->harga_adopsi,
            'status' => $request->status,
            'user_id' => Auth::id(),
            'vendor_id' => $adopsi->id_vendor,
            'keterangan' => $request->keterangan,
        ]);

        $adopsi->status = 'diadopsi';
        $adopsi->save();


        return redirect('admin/transaksi-adopsi')->with('success', 'Transaksi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = TransaksiAdopsi::with(['adopsi', 'user', 'vendor'])->findOrFail($id);
        return view('backend.transaksi-adopt.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaksi = TransaksiAdopsi::findOrFail($id);
        $adopsis = Adopsi::all();
        $users = User::all();
        $vendors = Vendor::all();
        return view('backend.transaksi-adopt.edit', compact('adopsis', 'users', 'vendors', 'transaksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_adopt' => 'required|exists:adopsis,id',
            'tgl_transaksi' => 'required|date',
            'total_transaksi' => 'required|numeric',
            'status' => 'required|in:menunggu,berhasil,dibatalkan',
            'user_id' => 'required|exists:users,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'keterangan' => 'nullable|string',
        ]);

        $transaksi = TransaksiAdopsi::findOrFail($id);
        $transaksi->update($request->all());

        return redirect('admin/transaksi-adopsi')->with('success', 'Transaksi berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaksi = TransaksiAdopsi::findOrFail($id);
        $transaksi->delete();
        
        return redirect('admin/transaksi-adopsi')->with('success', 'Transaksi berhasil dihapus.');
    }
}

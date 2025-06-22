<?php

namespace App\Http\Controllers;

use App\Models\TransaksiAdopsi;
use App\Models\Adopsi;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiVendorController extends Controller
{
    public function index(){
        $transaksi = TransaksiAdopsi::where('vendor_id', Auth::id())->get();
        return view('vendor.transaksi.index', compact('transaksi'));
    }

    public function create(){
        $adopsis = Adopsi::where('status', 'tersedia')->where('id_vendor', Auth::id())->get();
        return view('vendor.transaksi.create', compact('adopsis'));
    }

    public function store(Request $request){
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
            'vendor_id' => Auth::id(),
            'keterangan' => $request->keterangan,
        ]);

        $adopsi->status = 'diadopsi';
        $adopsi->save();

        return redirect('vendor/transaksi-adopsi')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function show($id){
        $transaksi = TransaksiAdopsi::findOrFail($id);
        return view('vendor.transaksi.show', compact('transaksi'));
    }

    public function edit($id){
        $adopsis = Adopsi::where('id_vendor', Auth::id())->get();
        $transaksi = TransaksiAdopsi::findOrFail($id);
        return view('vendor.transaksi.edit', compact('transaksi', 'adopsis'));
    }

    public function update(Request $request, $id){
        $transaksi = TransaksiAdopsi::findOrFail($id);
        $transaksi->update($request->all());

        return redirect('vendor/transaksi-adopsi')->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id){
        $transaksi = TransaksiAdopsi::findOrFail($id);
        $transaksi->delete();

        return redirect()->back()->with('success', 'Data Berhasil Dihapus');
    }
}

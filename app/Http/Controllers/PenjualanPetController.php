<?php

namespace App\Http\Controllers;

use App\Models\PenjualanPet;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PenjualanPetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penjualan = PenjualanPet::all();
        return view('backend.jubel.index', compact('penjualan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.jubel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pet' => 'required|string',
            'jenis' => 'required|string',
            'ras' => 'required|string',
            'umur' => 'required|integer',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        // Upload Foto
        $imageName = time().'.'.$request->foto->extension();
        $request->foto->move(public_path('pets_img'), $imageName);

        // Simpan Pet
        $pet = new Pet();
        $pet->nama_pet = $request->nama_pet;
        $pet->jenis = $request->jenis;
        $pet->ras = $request->ras;
        $pet->umur = $request->umur;
        $pet->foto = $imageName;
        $pet->deskripsi = $request->deskripsi;
        $pet->slug = Str::slug($request->nama_pet);
        $pet->status = 'dijual';
        $pet->save();

        // Simpan ke tabel Penjualan
        $penjualan = new PenjualanPet();
        $penjualan->id_pet = $pet->id;
        $penjualan->harga = $request->harga;
        $penjualan->status = 'tersedia';
        $penjualan->save();

        return redirect('admin/penjualan-hewan')->with('success', 'Data penjualan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jual = PenjualanPet::with('jualpet')->findOrFail($id);
        return view('backend.jubel.show', compact('jual'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jual = PenjualanPet::with('jualpet')->findOrFail($id);
        return view('backend.jubel.edit', compact('jual'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pet' => 'required|string',
            'jenis' => 'required|string',
            'ras' => 'required|string',
            'umur' => 'required|integer',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        $jual = PenjualanPet::findOrFail($id);
        $pet = $jual->jualpet;

        if ($request->hasFile('foto')) {
            $imageName = time().'.'.$request->foto->extension();
            $request->foto->move(public_path('pets_img'), $imageName);
            $pet->foto = $imageName;
        }

        $pet->nama_pet = $request->nama_pet;
        $pet->jenis = $request->jenis;
        $pet->ras = $request->ras;
        $pet->umur = $request->umur;
        $pet->deskripsi = $request->deskripsi;
        $pet->save();

        $jual->harga = $request->harga;
        $jual->save();

        return redirect('admin/penjualan-hewan')->with('success', 'Data penjualan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jual = PenjualanPet::findOrFail($id);
        $jual->delete();

        return back()->with('success', 'Data penjualan berhasil dihapus.');
    }
}

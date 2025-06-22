<?php

namespace App\Http\Controllers;

use App\Models\Adopsi;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdopsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adopts = Adopsi::where('status', 'tersedia')->get();
        return view('backend.adopt.index', compact('adopts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.adopt.create');
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
            'harga_adopsi' => 'required|numeric',
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
        $pet->status = 'adopsi';
        $pet->save();

        // Simpan ke tabel Adopsi
        $adopsi = new Adopsi();
        $adopsi->id_pet = $pet->id;
        $adopsi->vendor = $request->vendor ?? false;
        $adopsi->id_vendor = $request->id_vendor;
        $adopsi->harga_adopsi = $request->harga_adopsi;
        $adopsi->status = 'tersedia';
        $adopsi->save();

        return redirect('admin/adopt')->with('success', 'Data adopsi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $adopt = Adopsi::with('adoptpet')->findOrFail($id);
        return view('backend.adopt.show', compact('adopt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $adopt = Adopsi::with('adoptpet')->findOrFail($id);
        return view('backend.adopt.edit', compact('adopt'));
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
            'harga_adopsi' => 'required|numeric',
        ]);

        $adopt = Adopsi::findOrFail($id);
        $pet = $adopt->adoptpet;

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

        $adopt->harga_adopsi = $request->harga_adopsi;
        $adopt->save();

        return redirect('admin/adopt')->with('success', 'Data adopsi berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $adopt = Adopsi::findOrFail($id);
        $adopt->delete();

        return redirect('admin/adopt')->with('success', 'Data adopsi berhasil dihapus.');
    }
}

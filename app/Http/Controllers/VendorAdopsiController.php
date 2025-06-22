<?php

namespace App\Http\Controllers;

use App\Models\Adopsi;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VendorAdopsiController extends Controller
{
    public function index(){
        $adopts = Adopsi::where('id_vendor', Auth::id())->where('status', 'tersedia')->get();
        return view('vendor.adopsi.index', compact('adopts'));
    }

    public function create(){
        return view('vendor.adopsi.create');
    }

    public function store(Request $request){
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
        $adopsi->vendor = true;
        $adopsi->id_vendor = Auth::id();
        $adopsi->harga_adopsi = $request->harga_adopsi;
        $adopsi->status = 'tersedia';
        $adopsi->save();

        return redirect('vendor/adopt')->with('success', 'Data adopsi berhasil ditambahkan.');
    }

    public function show($id){
        $adopt = Adopsi::with('adoptpet')->findOrFail($id);
        $pets = Pet::where('id', $adopt->id_pet)->first();
        return view('vendor.adopsi.show', compact('adopt', 'pets'));
    }

    public function edit($id)
    {
        $adopt = Adopsi::with('adoptpet')->findOrFail($id);
        $pets = Pet::where('id', $adopt->id_pet)->first();
        return view('vendor.adopsi.edit', compact('adopt', 'pets'));
    }

    public function update(Request $request, $id){
        $adopsi = Adopsi::findorfail($id);
        $pet = Pet::where('id', $adopsi->id_pet)->first();

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

        
        $adopsi->harga_adopsi = $request->harga_adopsi;
        $adopsi->save();

        return redirect('vendor/adopt')->with('success', 'Data Berhasil Diupdate');
    }

    public function destroy($id){
        $adopt = Adopsi::findOrFail($id);
        $adopt->delete();

        return redirect()->back()->with('success', 'Data adopsi berhasil dihapus.');
    }
}

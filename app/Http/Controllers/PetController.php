<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PetController extends Controller
{
    // Tampilkan semua pet
    public function index()
    {
        $pets = Pet::all();
        return view('backend.pet.index', compact('pets'));
    }

    // Tampilkan form create
    public function create()
    {
        return view('backend.pet.create');
    }

    // Simpan data pet baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pet' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'ras' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required',
            'status' => 'required|in:adopsi,dijual'
        ]);

        // Upload foto
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('pets_img'), $filename);

        // Simpan data
        Pet::create([
            'nama_pet' => $request->nama_pet,
            'jenis' => $request->jenis,
            'ras' => $request->ras,
            'umur' => $request->umur,
            'foto' => $filename,
            'deskripsi' => $request->deskripsi,
            'slug' => Str::slug($request->nama_pet),
            'status' => $request->status
        ]);

        return redirect('admin/pets')->with('success', 'Pet berhasil ditambahkan.');
    }

    // Tampilkan detail pet
    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        return view('backend.pet.show', compact('pet'));
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $pet = Pet::findOrFail($id);
        return view('backend.pet.edit', compact('pet'));
    }

    // Update data pet
    public function update(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);

        $request->validate([
            'nama_pet' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'ras' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required',
            'status' => 'required|in:adopsi,dijual'
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if (file_exists(public_path('pets_img/' . $pet->foto))) {
                unlink(public_path('pets_img/' . $pet->foto));
            }

            // Upload foto baru
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('pets_img'), $filename);
            $pet->foto = $filename;
        }

        $pet->nama_pet = $request->nama_pet;
        $pet->jenis = $request->jenis;
        $pet->ras = $request->ras;
        $pet->umur = $request->umur;
        $pet->deskripsi = $request->deskripsi;
        $pet->slug = Str::slug($request->nama_pet);
        $pet->status = $request->status;
        $pet->save();

        return redirect('admin/pets')->with('success', 'Pet berhasil diupdate.');
    }

    // Hapus pet
    public function destroy($id)
    {
        $pet = Pet::findOrFail($id);

        // Hapus foto
        if (file_exists(public_path('pets_img/' . $pet->foto))) {
            unlink(public_path('pets_img/' . $pet->foto));
        }

        $pet->delete();
        return redirect('admin/pets')->with('success', 'Pet berhasil dihapus.');
    }
}

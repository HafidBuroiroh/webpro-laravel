<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('user')->get();
        return view('backend.vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('backend.vendor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Data user
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',

            // Data vendor
            'nama_toko' => 'required|string|max:255',
            'deskripsi_toko' => 'required|string',
            'alamat_toko' => 'required|string|max:255',
            'status_toko' => 'required|in:aktif,nonaktif',
        ]);

        // 1. Buat user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'level' => 'vendor',
        ]);

        // 2. Buat vendor
        Vendor::create([
            'id_user' => $user->id,
            'nama_toko' => $request->nama_toko,
            'deskripsi_toko' => $request->deskripsi_toko,
            'alamat_toko' => $request->alamat_toko,
            'status_toko' => $request->status_toko,
        ]);

        return redirect('vendor')->with('success', 'Vendor berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $vendor = Vendor::with('user')->findOrFail($id);
        return view('backend.vendor.edit', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $user = $vendor->user;

        $request->validate([
            // Data user
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'alamat' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',

            // Data vendor
            'nama_toko' => 'required|string|max:255',
            'deskripsi_toko' => 'required|string',
            'alamat_toko' => 'required|string|max:255',
            'status_toko' => 'required|in:aktif,nonaktif',
        ]);

        // 1. Update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        // 2. Update vendor
        $vendor->update([
            'nama_toko' => $request->nama_toko,
            'deskripsi_toko' => $request->deskripsi_toko,
            'alamat_toko' => $request->alamat_toko,
            'status_toko' => $request->status_toko,
        ]);

        return redirect('vendor')->with('success', 'Vendor berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->user()->delete(); // Hapus user juga
        $vendor->delete();

        return redirect('vendor')->with('success', 'Vendor berhasil dihapus.');
    }
}

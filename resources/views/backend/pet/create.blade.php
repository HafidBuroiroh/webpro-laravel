@extends('backend.layout')
@section('title', 'Tambah Pet')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header pb-0">
            <h6>Tambah Pet</h6>
        </div>
        <div class="card-body px-4 pt-4 pb-2">
            <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="nama_pet" class="form-label">Nama Pet</label>
                    <input type="text" name="nama_pet" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select name="jenis" class="form-control" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Anjing">Anjing</option>
                        <option value="Kucing">Kucing</option>
                        <option value="Hewan Lain">Hewan Lainnya</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ras" class="form-label">Ras</label>
                    <input type="text" name="ras" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="umur" class="form-label">Umur (tahun)</label>
                    <input type="number" name="umur" class="form-control" min="0" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="adopsi">Adopsi</option>
                        <option value="dijual">Dijual</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('pets.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

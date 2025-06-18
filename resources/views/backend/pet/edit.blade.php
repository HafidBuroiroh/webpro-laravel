@extends('backend.layout')
@section('title', 'Edit Pet')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header pb-0">
            <h6>Edit Pet</h6>
        </div>
        <div class="card-body px-4 pt-4 pb-2">
            <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama_pet" class="form-label">Nama Pet</label>
                    <input type="text" name="nama_pet" class="form-control" value="{{ $pet->nama_pet }}" required>
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <input type="text" name="jenis" class="form-control" value="{{ $pet->jenis }}" required>
                </div>
                <div class="mb-3">
                    <label for="ras" class="form-label">Ras</label>
                    <input type="text" name="ras" class="form-control" value="{{ $pet->ras }}" required>
                </div>
                <div class="mb-3">
                    <label for="umur" class="form-label">Umur (tahun)</label>
                    <input type="number" name="umur" class="form-control" value="{{ $pet->umur }}" min="0" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto (kosongkan jika tidak diganti)</label><br>
                    <img src="{{ asset('pets_img/' . $pet->foto) }}" width="150" class="mb-2">
                    <input type="file" name="foto" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ $pet->deskripsi }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="adopsi" {{ $pet->status == 'adopsi' ? 'selected' : '' }}>Adopsi</option>
                        <option value="dijual" {{ $pet->status == 'dijual' ? 'selected' : '' }}>Dijual</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="{{ route('pets.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

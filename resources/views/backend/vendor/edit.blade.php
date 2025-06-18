@extends('backend.layout')
@section('title', 'Edit Vendor')

@section('content')
<div class="col-12">
  <div class="card">
    <div class="card-header pb-0">
      <h6>Edit Vendor</h6>
    </div>
    <div class="card-body">
      <form action="{{ url('admin/vendor/'.$vendor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h6>Data User</h6>
        <div class="mb-3">
          <label>Nama User</label>
          <input type="text" name="name" class="form-control" value="{{ $vendor->user->name }}" required>
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" value="{{ $vendor->user->email }}" required>
        </div>
        <div class="mb-3">
          <label>Alamat</label>
          <input type="text" name="alamat" class="form-control" value="{{ $vendor->user->alamat }}" required>
        </div>
        <div class="mb-3">
          <label>No. Telepon</label>
          <input type="text" name="no_telp" class="form-control" value="{{ $vendor->user->no_telp }}" required>
        </div>

        <hr>
        <h6>Data Toko</h6>
        <div class="mb-3">
          <label>Nama Toko</label>
          <input type="text" name="nama_toko" class="form-control" value="{{ $vendor->nama_toko }}" required>
        </div>
        <div class="mb-3">
          <label>Deskripsi Toko</label>
          <textarea name="deskripsi_toko" class="form-control" required>{{ $vendor->deskripsi_toko }}</textarea>
        </div>
        <div class="mb-3">
          <label>Alamat Toko</label>
          <input type="text" name="alamat_toko" class="form-control" value="{{ $vendor->alamat_toko }}" required>
        </div>
        <div class="mb-3">
          <label>Status Toko</label>
          <select name="status_toko" class="form-control" required>
            <option value="aktif" {{ $vendor->status_toko == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ $vendor->status_toko == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
          </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ url('admin/vendor') }}" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
@endsection

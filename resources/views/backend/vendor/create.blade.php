@extends('backend.layout')
@section('title', 'Tambah Vendor')

@section('content')
<div class="col-12">
  <div class="card">
    <div class="card-header pb-0">
      <h6>Tambah Vendor</h6>
    </div>
    <div class="card-body">
      <form action="{{ url('admin/vendor') }}" method="POST">
        @csrf
        <h6>Data User</h6>
        <div class="mb-3">
          <label>Nama User</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Konfirmasi Password</label>
          <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Alamat</label>
          <input type="text" name="alamat" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>No. Telepon</label>
          <input type="text" name="no_telp" class="form-control" required>
        </div>

        <hr>
        <h6>Data Toko</h6>
        <div class="mb-3">
          <label>Nama Toko</label>
          <input type="text" name="nama_toko" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Deskripsi Toko</label>
          <textarea name="deskripsi_toko" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
          <label>Alamat Toko</label>
          <input type="text" name="alamat_toko" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>Status Toko</label>
          <select name="status_toko" class="form-control" required>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
          </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ url('admin/vendor') }}" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
@endsection

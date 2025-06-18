@extends('backend.layout')
@section('title', 'Tambah Penjualan Pet')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ url('admin/penjualan-hewan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('backend.pet.form') {{-- Form Pet --}}
                <div class="mb-3">
                    <label for="harga" class="form-label">Harga Jual</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('backend.layout')
@section('title', 'Tambah Adopsi')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <form action="{{ url('admin/adopt') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('backend.pet.form') {{-- Form Pet --}}
                <div class="mb-3">
                    <label for="harga_adopsi" class="form-label">Harga Adopsi</label>
                    <input type="number" name="harga_adopsi" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

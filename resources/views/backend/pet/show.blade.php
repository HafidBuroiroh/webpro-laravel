@extends('backend.layout')
@section('title', 'Detail Pet')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header pb-0">
            <h6>Detail Pet</h6>
        </div>
        <div class="card-body px-4 pt-4 pb-2">
            <div class="mb-3">
                <img src="{{ asset('pets_img/' . $pet->foto) }}" width="200" class="mb-3">
            </div>
            <div class="mb-3">
                <strong>Nama:</strong> {{ $pet->nama_pet }}
            </div>
            <div class="mb-3">
                <strong>Jenis:</strong> {{ $pet->jenis }}
            </div>
            <div class="mb-3">
                <strong>Ras:</strong> {{ $pet->ras }}
            </div>
            <div class="mb-3">
                <strong>Umur:</strong> {{ $pet->umur }} tahun
            </div>
            <div class="mb-3">
                <strong>Status:</strong> {{ ucfirst($pet->status) }}
            </div>
            <div class="mb-3">
                <strong>Deskripsi:</strong> <br> {!! nl2br(e($pet->deskripsi)) !!}
            </div>
            <a href="{{ route('pets.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection

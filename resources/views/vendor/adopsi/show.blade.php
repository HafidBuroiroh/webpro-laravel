@extends('backend.layout')
@section('title', 'Detail Adopsi')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4>{{ $adopt->adoptpet->nama_pet }}</h4>
            <img src="{{ asset('pets_img/' . $adopt->adoptpet->foto) }}" width="200" alt="">
            <p>Jenis: {{ $adopt->adoptpet->jenis }}</p>
            <p>Ras: {{ $adopt->adoptpet->ras }}</p>
            <p>Umur: {{ $adopt->adoptpet->umur }} tahun</p>
            <p>Deskripsi: {{ $adopt->adoptpet->deskripsi }}</p>
            <p>Harga Adopsi: Rp. {{ number_format($adopt->harga_adopsi, 0, ',', '.') }}</p>
            <a href="/vendor/adopt" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection

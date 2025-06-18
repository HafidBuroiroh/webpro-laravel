@extends('backend.layout')
@section('title', 'Detail Penjualan Pet')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h4>{{ $jual->jualpet->nama_pet }}</h4>
            <img src="{{ asset('pets_img/' . $jual->jualpet->foto) }}" width="200" alt="">
            <p>Jenis: {{ $jual->jualpet->jenis }}</p>
            <p>Ras: {{ $jual->jualpet->ras }}</p>
            <p>Umur: {{ $jual->jualpet->umur }} tahun</p>
            <p>Deskripsi: {{ $jual->jualpet->deskripsi }}</p>
            <p>Harga: Rp. {{ number_format($jual->harga, 0, ',', '.') }}</p>
        </div>
    </div>
</div>
@endsection

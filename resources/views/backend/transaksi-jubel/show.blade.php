@extends('backend.layout')
@section('title', 'Detail Transaksi Penjualan Pet')
@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h6>Detail Transaksi Penjualan Pet</h6>
            <a href="{{ url('admin/transaksi-penjualan') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <img src="{{asset('pets_img/'.$transaksi->penjualanPet->jualpet->foto)}}" width="300" alt="">
            </div>
            <div class="mb-3">
                <strong>Nama Pet:</strong> {{ $transaksi->penjualanPet->jualpet->nama_pet ?? '-' }}
            </div>
            <div class="mb-3">
                <strong>Tanggal Transaksi:</strong> {{ \Carbon\Carbon::parse($transaksi->tgl_transaksi)->format('d M Y') }}
            </div>
            <div class="mb-3">
                <strong>Total Transaksi:</strong> Rp {{ number_format($transaksi->total_transaksi, 0, ',', '.') }}
            </div>
            <div class="mb-3">
                <strong>User:</strong> {{ $transaksi->user->name }}
            </div>
            <div class="mb-3">
                <strong>Keterangan:</strong> {{ $transaksi->keterangan ?? '-' }}
            </div>
        </div>
    </div>
</div>

@endsection

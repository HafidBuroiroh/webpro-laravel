@extends('backend.layout')
@section('title', 'Tambah Transaksi Penjualan Pet')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header pb-0">
            <h6>Tambah Transaksi Penjualan Pet</h6>
        </div>
        <div class="card-body">
            <form action="{{ url('admin/transaksi-penjualan') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="id_penjualan" class="form-label">Penjualan Pet</label>
                    <select name="id_penjualan" class="form-control" required>
                        <option value="">-- Pilih Pet --</option>
                        @foreach($penjualans as $penjualan)
                            <option value="{{ $penjualan->id }}">{{ $penjualan->jualpet->nama_pet }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                    <input type="date" name="tgl_transaksi" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection

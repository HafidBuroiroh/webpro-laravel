@extends('backend.layout')
@section('title', 'Edit Transaksi Penjualan Pet')

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header pb-0">
            <h6>Edit Transaksi Penjualan Pet</h6>
        </div>
        <div class="card-body">
            <form action="{{ url('admin/transaksi-penjualan-pet/' . $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_penjualan" class="form-label">Penjualan Pet</label>
                    <select name="id_penjualan" class="form-control" required>
                        <option value="">-- Pilih Pet --</option>
                        @foreach($penjualans as $penjualan)
                            <option value="{{ $penjualan->id }}" {{ $penjualan->id == $transaksi->id_penjualan ? 'selected' : '' }}>
                                {{ $penjualan->nama_pet }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                    <input type="date" name="tgl_transaksi" class="form-control" value="{{ $transaksi->tgl_transaksi }}" required>
                </div>

                <div class="mb-3">
                    <label for="total_transaksi" class="form-label">Total Transaksi</label>
                    <input type="number" name="total_transaksi" class="form-control" value="{{ $transaksi->total_transaksi }}" required>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control">{{ $transaksi->keterangan }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection

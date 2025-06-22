@extends('backend.layout')
@section('title', 'Edit Transaksi Adopsi')
@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-header pb-0">
            <h6>Edit Transaksi Adopsi</h6>
        </div>
        <div class="card-body">
            <form action="{{ url('admin/transaksi-adopsi/'. $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="id_adopt" class="form-label">Adopsi</label>
                    <select name="id_adopt" id="id_adopt" class="form-control" required>
                        <option value="">-- Pilih Adopsi --</option>
                        @foreach($adopsis as $adopt)
                            <option value="{{ $adopt->id }}" {{ $transaksi->id_adopt == $adopt->id ? 'selected' : '' }}>
                                {{ $adopt->adoptpet->nama_pet ?? 'Tanpa Nama' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                    <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-control" value="{{ $transaksi->tgl_transaksi }}" required>
                </div>

                <div class="mb-3">
                    <label for="total_transaksi" class="form-label">Total Transaksi</label>
                    <input type="number" name="total_transaksi" id="total_transaksi" class="form-control" value="{{ $transaksi->total_transaksi }}" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="menunggu" {{ $transaksi->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="berhasil" {{ $transaksi->status == 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                        <option value="dibatalkan" {{ $transaksi->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="user_id" class="form-label">User</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">-- Pilih User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $transaksi->user_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="vendor_id" class="form-label">Vendor (Opsional)</label>
                    <select name="vendor_id" id="vendor_id" class="form-control">
                        <option value="">-- Pilih Vendor --</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}" {{ $transaksi->vendor_id == $vendor->id ? 'selected' : '' }}>
                                {{ $vendor->nama_vendor }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ $transaksi->keterangan }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ url('admin/transaksi-adopsi') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

@endsection

@extends('backend.layout')
@section('title', 'Tambah Transaksi Adopsi')
@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-header pb-0">
            <h6>Tambah Transaksi Adopsi</h6>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card-body">
            <form action="{{ url('vendor/transaksi-adopsi') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="id_adopt" class="form-label">Adopsi</label>
                    <select name="id_adopt" id="id_adopt" class="form-control" required>
                        <option value="">-- Pilih Adopsi --</option>
                        @foreach($adopsis as $adopt)
                            <option value="{{ $adopt->id }}" {{ old('id_adopt') == $adopt->id ? 'selected' : '' }}>
                                {{ $adopt->adoptpet->nama_pet ?? 'Tanpa Nama' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                    <input type="date" name="tgl_transaksi" id="tgl_transaksi" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="menunggu">Menunggu</option>
                        <option value="berhasil">Berhasil</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ url('vendor/transaksi-adopsi') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

@endsection

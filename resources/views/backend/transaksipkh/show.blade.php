@extends('backend.layout')

@section('title', 'Detail Transaksi PKH')

@section('content')
<div class="col-12">
  <div class="card">
    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
      <h6>Detail Transaksi PKH</h6>
      <a href="{{ url('admin/transaksi-pkh') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
    <div class="card-body">

      {{-- Informasi Umum Transaksi --}}
      <div class="mb-3">
        <label class="form-label">Nama Transaksi</label>
        <input type="text" class="form-control" value="{{ $transaksi->name }}" readonly>
      </div>
      <div class="mb-3">
        <label class="form-label">Nama Pembeli</label>
        <input type="text" class="form-control" value="{{ $transaksi->user->name }}" readonly>
      </div>
      <div class="mb-3">
        <label class="form-label">Tanggal Transaksi</label>
        <input type="text" class="form-control" value="{{ $transaksi->tgl_transaksi }}" readonly>
      </div>
      <div class="mb-3">
        <label class="form-label">Status Pengiriman Saat Ini</label>
        <input type="text" class="form-control" value="{{ ucfirst($transaksi->status) }}" readonly>
      </div>

      {{-- Produk --}}
      <h6 class="mt-4 mb-3">Detail Produk</h6>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Nama Produk</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @php
              $totalProductPrice = 0;
          @endphp
          @foreach($transaksi->productTransactions as $productTransaction)
            @php
                $subtotal = $productTransaction->qty * $productTransaction->product->harga;
                $totalProductPrice += $subtotal;
            @endphp
            <tr>
              <td>{{ $productTransaction->product->nama }}</td>
              <td>{{ $productTransaction->qty }}</td>
              <td>Rp {{ number_format($productTransaction->product->harga, 0, ',', '.') }}</td>
              <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

      {{-- Biaya dan Total --}}
      <div class="mb-3">
        <label class="form-label">Total Harga Produk</label>
        <input type="text" class="form-control" value="Rp. {{ number_format($totalProductPrice, 0, ',', '.') }}" readonly>
      </div>
      <div class="mb-3">
        <label class="form-label">Biaya Pengiriman</label>
        <input type="text" class="form-control" value="Rp. {{ number_format($transaksi->pengiriman->first()->biaya_ongkir ?? 0, 0, ',', '.') }}" readonly>
      </div>
      <div class="mb-3">
        <label class="form-label">Total Transaksi</label>
        <input type="text" class="form-control" value="Rp. {{ number_format($transaksi->total_transaksi, 0, ',', '.') }}" readonly>
      </div>

      {{-- Ubah Status --}}
      <form action="{{ route('admin.transaksi.updateStatus', $transaksi->id) }}" method="POST" id="formUpdateStatus">
        @csrf
        <div class="mb-3">
          <label for="status" class="form-label">Ubah Status Pengiriman</label>
          <select name="status" id="status" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <option value="dikemas" {{ $transaksi->status == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
            <option value="dikirim" {{ $transaksi->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
            <option value="berhasil" {{ $transaksi->status == 'berhasil' ? 'selected' : '' }}>Berhasil</option>
            <option value="dibatalkan" {{ $transaksi->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
          </select>
        </div>
        <button type="submit" class="btn btn-success">Update Status</button>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.getElementById('formUpdateStatus').addEventListener('submit', function (e) {
    e.preventDefault();
    Swal.fire({
      title: 'Yakin mengubah status?',
      text: "Status akan diperbarui.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Ubah Status!'
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });
</script>
@endpush

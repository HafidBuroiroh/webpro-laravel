@extends('backend.layout')
@section('title', 'Transaksi PKH')
@section('content')
<div class="col-12">
  <div class="card">
    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
      <h6>List Transaksi PKH</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-3">
        <table class="table align-items-center mb-0" id="transaksi-pkh-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Transaksi</th>
              <th>Nama Pembeli</th>
              <th>Tanggal Transaksi</th>
              <th>Total Transaksi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transaksis as $index => $transaksi)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaksi->name }}</td>
                <td>{{ $transaksi->user->name }}</td>
                <td>{{ $transaksi->tgl_transaksi }}</td>
                <td>Rp. {{ number_format($transaksi->total_transaksi, 0, ',', '.') }}</td>
                <td>
                  @if ($transaksi->status == 'dikemas')
                    <span class="badge bg-warning text-dark">Dikemas</span>
                  @elseif ($transaksi->status == 'dikirim')
                    <span class="badge bg-primary">Dikirim</span>
                  @elseif ($transaksi->status == 'berhasil')
                    <span class="badge bg-success">Berhasil</span>
                  @else
                    <span class="badge bg-danger">Dibatalkan</span>
                  @endif
                </td>
                <td>
                  <a href="{{ url('admin/transaksi-pkh/'. $transaksi->id) }}" class="btn btn-sm btn-info">Show</a>
                  <form action="{{ route('admin.transaksi.updateStatus', $transaksi->id) }}" method="POST" class="d-inline form-status-update">
                    @csrf
                    <select name="status" class="form-select form-select-md w-50 mx-1 d-inline status-dropdown" data-id="{{ $transaksi->id }}">
                      <option value="dikemas" {{ $transaksi->status == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                      <option value="dikirim" {{ $transaksi->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                      <option value="berhasil" {{ $transaksi->status == 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                      <option value="dibatalkan" {{ $transaksi->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                  </form>

                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function () {
    $('#transaksi-pkh-table').DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
      }
    });

    // SweetAlert2 untuk konfirmasi perubahan status
    $('.status-dropdown').on('change', function () {
      let form = $(this).closest('form');

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
          form.submit();
        } else {
          window.location.reload(); // Reset dropdown jika dibatalkan
        }
      });
    });
  });
</script>
@endpush


@extends('backend.layout')
@section('title', 'Transaksi Adopsi')
@section('content')
<div class="col-12">
  <div class="card">
    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
          <h6>List Transaksi Adopsi</h6>
          <a href="{{ url('admin/transaksi-adopsi/create') }}" class="btn btn-primary btn-sm">+ Tambah Transaksi</a>
      </div>
    <div class="card-header pb-0">
      <h6>List Transaksi Adopsi</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-3">
        <table class="table align-items-center mb-0" id="pet-table">
          <thead>
            <tr>
                <th>No</th>
                <th>Nama Pet</th>
                <th>Total Transaksi</th>
                <th>Tanggal Transaksi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transaksi as $index => $adopt)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $adopt->adopsi->adoptpet->nama_pet }}</td>
                <td>Rp {{ number_format($adopt->total_transaksi, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($adopt->tgl_transaksi)->format('d M Y') }}</td>
                <td>
                    @if($adopt->status == 'menunggu')
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    @elseif($adopt->status == 'berhasil')
                        <span class="badge bg-success">Berhasil</span>
                    @elseif($adopt->status == 'dibatalkan')
                        <span class="badge bg-danger">Dibatalkan</span>
                    @endif
                </td>
                <td>
                    <a href="{{ url('admin/transaksi-adopsi/'.$adopt->id.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ url('admin/transaksi-adopsi/'.$adopt->id) }}" class="btn btn-sm btn-info">Show</a>
                    <form action="{{ url('admin/transaksi-adopsi/'.$adopt->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</button>
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
<!-- jQuery dan DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function () {
    $('#pet-table').DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
      }
    });
  });
</script>
@endpush
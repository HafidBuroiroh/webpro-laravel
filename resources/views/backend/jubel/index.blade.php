@extends('backend.layout')
@section('title', 'Penjualan Pet')
@section('content')
<div class="col-12">
  <div class="card">
    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
      <h6>List Penjualan Pet</h6>
      <a href="{{ url('admin/penjualan-hewan/create') }}" class="btn btn-primary btn-sm">Tambah Penjualan Pet</a>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-3">
        <table class="table align-items-center mb-0" id="pet-table">
          <thead>
            <tr>
                <th>No</th>
                <th>Nama Pet</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($penjualan as $index => $pp)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $pp->jualpet->nama_pet }}</td>
                <td>Rp. {{ number_format($pp->harga, 0, ',', '.') }}</td>
                <td>
                  <a href="{{ url('admin/penjualan-hewan/' . $pp->id) }}" class="btn btn-sm btn-info">Show</a>
                  <a href="{{ url('admin/penjualan-hewan/' . $pp->id . '/edit') }}" class="btn btn-sm btn-warning">Edit</a>
                  <form action="{{ url('admin/penjualan-hewan/' . $pp->id) }}" method="POST" class="d-inline">
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

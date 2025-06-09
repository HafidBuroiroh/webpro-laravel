@extends('backend.layout')
@section('title', 'Vendor')
@section('content')
<div class="col-12">
  <div class="card">
    <div class="card-header pb-0">
      <h6>List Vendor</h6>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-3">
        <table class="table align-items-center mb-0" id="pet-table">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th style="text-align: center;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($vendors as $index => $vendor)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $vendor->nama_toko }}</td>
                <td>{{ $vendor->alamat_toko }}</td>
                <td style="text-align: center;">
                  <a href="{{ route('vendor.edit', $vendor->id) }}" class="btn btn-sm btn-warning">Edit</a>
                  <form action="{{ route('vendor.destroy', $vendor->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus vendor ini?')">Hapus</button>
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
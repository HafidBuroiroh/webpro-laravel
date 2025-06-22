@extends('frontend.layout')

@section('title', 'Transaction History')

@section('content')
<div class="container py-5">
    <h1 class="text-white mb-4 text-center" style="font-family: 'Sniglet', system-ui; font-weight: 800; font-size: 3.5rem;">
        Transaction History
    </h1>

    @if($transactions->isEmpty())
        <div class="alert alert-info text-center">You have no transactions yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-dark table-striped text-center" id="transactionTable">
                <thead>
                    <tr>
                        <th>Transaction Name</th>
                        <th>Total Qty</th>
                        <th>Total Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Detail</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->name }}</td>
                            <td>
                                {{ $transaction->productTransactions->sum('qty') }}
                            </td>
                            <td>Rp {{ number_format($transaction->total_transaksi, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badgeClass = match($transaction->status) {
                                        'berhasil' => 'bg-success',
                                        'dikirim' => 'bg-warning',
                                        'dikemas' => 'bg-secondary',
                                        'delay' => 'bg-info',
                                        'dibatalkan' => 'bg-danger',
                                        default => 'bg-light',
                                    };
                                @endphp

                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td>{{ date('d M Y', strtotime($transaction->tgl_transaksi)) }}</td>
                            <td><a href="{{ route('transaction.detail', $transaction->id) }}" class="btn btn-info btn-sm">View</a></td>
                            <td>
                                @if($transaction->status == 'dikemas')
                                    <form action="{{ route('transaction.cancel', $transaction->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Cancel Order</button>
                                    </form>
                                @endif

                                @if($transaction->status == 'dikirim')
                                    <form action="{{ route('transaction.confirm', $transaction->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Order Received</button>
                                    </form>
                                @endif

                                @if($transaction->status == 'delay')
                                    <a href="{{ route('checkout.payment', $transaction->id) }}" class="btn btn-warning">Payment</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@section('scripts')
<!-- jQuery first, then DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function () {
    $('#transactionTable').DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
      }
    });
  });
</script>
@endsection
@endsection

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
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Transaction Name</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->name }}</td>
                            <td>{{ $transaction->pkh->nama }}</td>
                            <td>{{ $transaction->qty }}</td>
                            <td>Rp {{ number_format($transaction->total_transaksi, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badgeClass = match($transaction->status) {
                                        'berhasil' => 'bg-success',
                                        'dikirim' => 'bg-warning',
                                        'dikemas' => 'bg-secondary',
                                        'dibatalkan' => 'bg-danger',
                                        default => 'bg-secondary',
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

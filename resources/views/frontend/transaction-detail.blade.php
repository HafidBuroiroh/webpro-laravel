@extends('frontend.layout')

@section('title', 'Transaction Detail')

@section('content')
<div class="container py-5">
    <h1 class="text-center text-white mb-4">Transaction Detail</h1>

    <div class="card shadow p-4 mb-4" style="background-color: #393E46; color: white;">
        <h5 class="mb-3">Transaction Info</h5>
        <ul class="list-group list-group-flush mb-3">
            <li class="list-group-item bg-transparent text-white"><strong>Transaction Code:</strong> {{ $transaction->name }}</li>
            <li class="list-group-item bg-transparent text-white"><strong>Date:</strong> {{ date('d M Y', strtotime($transaction->tgl_transaksi)) }}</li>
            <li class="list-group-item bg-transparent text-white d-flex align-items-center">
                <strong>Status:</strong> 
                @php
                    $badgeClass = match($transaction->status) {
                        'berhasil' => 'bg-success',
                        'dikirim' => 'bg-warning',
                        'dikemas' => 'bg-secondary',
                        'dibatalkan' => 'bg-danger',
                        default => 'bg-secondary',
                    };
                @endphp
                <span class="badge {{ $badgeClass }} ms-2">{{ ucfirst($transaction->status) }}</span>
            </li>
            <li class="list-group-item bg-transparent text-white"><strong>Courier:</strong> {{ strtoupper($transaction->pengiriman->first()->kurir) }}</li>
        </ul>

        <h5 class="mb-3">Product Info</h5>
        @php
            $totalProductPrice = 0;
        @endphp

        <ul class="list-group list-group-flush mb-3">
            @foreach($transaction->productTransactions as $productTransaction)
                @php
                    $subtotal = $productTransaction->product->harga * $productTransaction->qty;
                    $totalProductPrice += $subtotal;
                @endphp
                <li class="list-group-item bg-transparent text-white">
                    <strong>Image Product:</strong> 
                    <img src="{{ asset('pkh_img/' . $productTransaction->product->foto) }}" 
                        class="card-img-top my-2" 
                        alt="{{ $productTransaction->product->nama }}" 
                        style="width: 300px; object-fit: cover;">
                </li>
                <li class="list-group-item bg-transparent text-white">
                    <strong>Product:</strong> {{ $productTransaction->product->nama }}
                </li>
                <li class="list-group-item bg-transparent text-white">
                    <strong>Quantity:</strong> {{ $productTransaction->qty }}
                </li>
                <li class="list-group-item bg-transparent text-white">
                    <strong>Subtotal:</strong> Rp {{ number_format($subtotal, 0, ',', '.') }}
                </li>
                <hr class="text-white">
            @endforeach

            {{-- Total Product Price --}}
            <li class="list-group-item bg-transparent text-white">
                <strong>Total Product Price:</strong> Rp {{ number_format($totalProductPrice, 0, ',', '.') }}
            </li>

            {{-- Shipping Cost --}}
            <li class="list-group-item bg-transparent text-white">
                <strong>Shipping Cost:</strong> Rp {{ number_format($transaction->pengiriman->first()->biaya_ongkir, 0, ',', '.') }}
            </li>

            {{-- Total Payment --}}
            <li class="list-group-item bg-transparent text-white">
                <strong>Total Payment:</strong> Rp {{ number_format($transaction->total_transaksi, 0, ',', '.') }}
            </li>
        </ul>


        <h5 class="mb-3">Customer Info</h5>
        <ul class="list-group list-group-flush">
            <li class="list-group-item bg-transparent text-white"><strong>Name:</strong> {{ $transaction->user->name }}</li>
            <li class="list-group-item bg-transparent text-white"><strong>Email:</strong> {{ $transaction->user->email }}</li>
        </ul>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-4">
        @if($transaction->status == 'dikemas')
            <form action="{{ route('transaction.cancel', $transaction->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger me-2">Cancel Order</button>
            </form>
        @endif

        @if($transaction->status == 'dikirim')
            <form action="{{ route('transaction.confirm', $transaction->id) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success me-2">Mark as Received</button>
            </form>
        @endif

        <a href="{{ route('transaction.history') }}" class="btn btn-secondary">Back to History</a>
    </div>
</div>
@endsection

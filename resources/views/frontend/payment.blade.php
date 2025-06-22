@extends('frontend.layout')

@section('title', 'Payment')

@section('content')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-h1m0TRh7MTPe7yn8"></script>

<div class="container py-5 text-center">
    <h1 class="text-white mb-4">Payment for {{ $transaction->name }}</h1>

    <p class="text-white mb-4 fs-4">Total Payment: <strong>Rp {{ number_format($transaction->total_transaksi, 0, ',', '.') }}</strong></p>

    <button id="pay-button" class="btn btn-success px-4 py-2 rounded-pill fs-5">Proceed Payment</button>
    <form action="{{ route('payment.simulate-success', $transaction->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fs-5">Done Payment</button>
    </form>
</div>

<script>
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                window.location.href = "/checkout-success";
            },
            onPending: function(result){
                window.location.href = "/checkout-success";
            },
            onError: function(result){
                alert("Payment Failed!");
            },
            onClose: function(){
                alert('You closed the payment popup without finishing the payment.');
            }
        });
    });
</script>
@endsection

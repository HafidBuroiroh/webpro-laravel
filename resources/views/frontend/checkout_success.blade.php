@extends('frontend.layout')

@section('title', 'Checkout Success')

@section('content')
<div class="container py-5 text-center">
    <h1 class="text-success mb-4" style="font-family: 'Sniglet', system-ui; font-weight: 800; font-size: 3.5rem;">
        Payment Successful!
    </h1>

    <p class="fs-4 mb-4">Thank you for your purchase. Your order is being processed.</p>

    <a href="{{ url('/') }}" class="btn btn-primary px-4 py-2 rounded-pill fs-5">Back to Home</a>
</div>
@endsection

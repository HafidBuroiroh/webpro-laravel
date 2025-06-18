@extends('frontend.layout')

@section('title', $product->nama . ' Details')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-start g-5">
        {{-- Left: Product Image --}}
        <div class="col-md-5">
            <img src="{{ asset('pkh_img/' . $product->foto) }}" alt="{{ $product->nama }}" 
                class="img-fluid rounded-4 shadow" 
                style="height: 100%; object-fit: cover;">
        </div>

        {{-- Right: Product Details --}}
        <div class="col-md-7 text-white">
            <h2 class="mb-3 sniglet-extrabold">{{ $product->nama }}</h2>

            <ul class="list-unstyled fs-5 mb-4">
                <li><strong>Category:</strong> {{ ucfirst($product->jenis) }}</li>
                <li><strong>Stock:</strong> {{ $product->stock }}</li>
                <li><strong>Status:</strong> {{ ucfirst($product->status) }}</li>
            </ul>

            <p class="fs-4 mb-4">Price: <strong>Rp {{ number_format($product->harga, 0, ',', '.') }}</strong></p>
            @auth
                @if(Auth::user()->level === 'user')
                    <form action="{{ url('/cart/add') }}" method="POST" class="d-flex align-items-center gap-3">
                        @csrf
                        <input type="hidden" name="id_pkh" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-success rounded-pill px-4 py-2">
                            <i class="bi bi-cart-plus me-1"></i> Add to Cart
                        </button>
                    </form>
                @else
                    <a href="/login" class="btn rounded-pill px-4 text-light-color secondark-color poppins-regular">
                        Sign In
                    </a>
                @endif
            @else
                <a href="/login" class="btn rounded-pill px-4 text-light-color secondark-color poppins-regular">
                    Sign In for Transaction
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection

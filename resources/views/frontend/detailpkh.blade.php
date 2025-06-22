@extends('frontend.layout')

@section('title', $product->nama . ' Details')

@section('content')
{{-- CSRF Meta Token untuk Ajax --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

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
                    <button type="button" class="btn btn-success rounded-pill px-4 py-2 add-to-cart-btn" data-id="{{ $product->id }}">
                        <i class="bi bi-cart-plus me-1"></i> Add to Cart
                    </button>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();

        const button = $(this);
        button.prop('disabled', true).text('Processing...'); // Disable button & ubah text

        const itemId = button.data('id');

        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                id_pkh: itemId,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Added to Cart!',
                    text: response.message,
                    toast: true,
                    timer: 2000,
                    position: 'top-end',
                    showConfirmButton: false
                });
                button.prop('disabled', false).html('<i class="bi bi-cart-plus"></i> Add to Cart'); // Enable lagi
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: xhr.responseJSON.message || 'Something went wrong.',
                });
                button.prop('disabled', false).html('<i class="bi bi-cart-plus"></i> Add to Cart'); // Enable lagi
            }
        });
    });
</script>
@endsection

@extends('frontend.layout')

@section('title', 'Shopping Cart')

@section('content')
<div class="banner-container position-relative overflow-hidden" style="height: 150px; background-color: #222831;">
    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="z-index: 2;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="text-white mb-3 text-center" style="font-family: 'Sniglet', system-ui; font-weight: 800; font-size: 3.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                        My Cart
                    </h1>
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="container">

    @if(Auth::check())
        @php
            // Get cart items with product relation
            $carts = \App\Models\Cart::where('id_user', Auth::id())->with('pkh')->get();
            $total = 0;
        @endphp

        @if($carts->isEmpty())
            <div class="alert alert-info">Your cart is empty.</div>
        @else
            <div class="row g-4">
                @foreach($carts as $cart)
                    @php
                        $product = $cart->pkh;
                        $imagePath = $product && $product->foto
                            ? asset('pkh_img/' . $product->foto)
                            : 'https://via.placeholder.com/300x200?text=No+Image';

                        $price = $product->harga ?? 0;
                        $subtotal = $price * $cart->qty;
                        $total += $subtotal;
                    @endphp

                    <div class="col-md-3 mb-4">
                        <div class="card border-0 rounded-4 overflow-hidden shadow-sm h-100">
                            <img src="{{ $product && $product->foto ? asset('pkh_img/' . $product->foto) : 'https://via.placeholder.com/300x300?text=No+Image' }}"
                                class="card-img-top" alt="{{ $product->nama }}" style="height: 300px; object-fit: cover;">
                            <div class="card-body p-4 semi-color rounded-bottom text-white d-flex flex-column">
                                <div class="mb-3">
                                    <h3 class="card-title sniglet-extrabold text-dark-color mb-2">{{ $product->nama }}</h3>
                                    <div class="mb-3">
                                        <p class="fw-bold fs-5 mb-1">Rp. {{ number_format($product->harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <input type="number" name="quantity" min="1" value="{{ $cart->qty }}" class="form-control me-2 quantity-input" data-cart-id="{{ $cart->id }}" style="width: 70px;">
                                    <button class="btn btn-primary btn-sm btn-update-quantity" data-cart-id="{{ $cart->id }}">Update</button>
                                </div>

                                <p class="card-text mb-3">Subtotal: <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></p>

                                <button class="btn btn-danger btn-sm btn-remove-cart mt-auto" data-cart-id="{{ $cart->id }}">
                                    Remove from Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-between align-items-center">
                <h4>Total: Rp {{ number_format($total, 0, ',', '.') }}</h4>
                {{-- <a href="{{ route('cart.checkout') }}" class="btn btn-success btn-lg px-4">
                    Checkout
                </a> --}}
            </div>
        @endif

    @else
        <div class="alert alert-warning">
            Please <a href="{{ route('login') }}">login</a> to view your cart.
        </div>
    @endif
</div>
<script>
$(document).ready(function() {
    // Setup CSRF token for all AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Update quantity handler
    $('.btn-update-quantity').click(function(e) {
        e.preventDefault();

        const cartId = $(this).data('cart-id');
        const quantityInput = $(`input.quantity-input[data-cart-id="${cartId}"]`);
        const quantity = quantityInput.val();

        $.ajax({
            url: '/cart/' + cartId,
            type: 'PUT',
            data: { quantity: quantity },
            success: function(response) {
                alert(response.message || 'Quantity updated!');
                location.reload(); // reload to update subtotal and total; you can also update parts dynamically
            },
            error: function(xhr) {
                alert('Failed to update quantity.');
            }
        });
    });

    // Remove cart item handler
    $('.btn-remove-cart').click(function(e) {
        e.preventDefault();

        if (!confirm('Are you sure you want to remove this item from your cart?')) {
            return;
        }

        const cartId = $(this).data('cart-id');

        $.ajax({
            url: '/cart/' + cartId,
            type: 'DELETE',
            success: function(response) {
                alert(response.message || 'Item removed from cart!');
                location.reload(); // reload to update cart view
            },
            error: function(xhr) {
                alert('Failed to remove item.');
            }
        });
    });
});
</script>

@endsection

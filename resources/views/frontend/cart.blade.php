// resources/views/frontend/cart.blade.php

@extends('frontend.layout')

@section('title', 'Shopping Cart')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

<div class="container py-5">
    @if(Auth::check())
        @php
            $carts = \App\Models\Cart::where('id_user', Auth::id())->with('pkh')->get();
        @endphp

        @if($carts->isEmpty())
            <div class="alert alert-info">Your cart is empty.</div>
        @else
            <form id="checkout-form" method="POST" action="">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        @foreach($carts as $cart)
                            @php
                                $product = $cart->pkh;
                                $imagePath = $product && $product->foto
                                    ? asset('pkh_img/' . $product->foto)
                                    : 'https://via.placeholder.com/300x200?text=No+Image';

                                $price = $product->harga ?? 0;
                                $subtotal = $price * $cart->qty;
                            @endphp

                            <div class="card mb-4 border-0 shadow" style="background-color: #393E46; color: white;">
                                <div class="row g-0 align-items-center">
                                    <div class="col-md-1 text-center">
                                        <input type="checkbox" class="form-check-input select-item" name="selected_items[]" value="{{ $cart->id }}" data-subtotal="{{ $subtotal }}" style="margin-top: 50px;">
                                    </div>
                                    <div class="col-md-2">
                                        <img src="{{ $imagePath }}" class="img-fluid rounded-start" alt="{{ $product->nama }}">
                                    </div>
                                    <div class="col-md-5">
                                        <div class="card-body">
                                            <h5 class="card-title" style="color: #EEEEEE;">{{ $product->nama }}</h5>
                                            <p class="card-text mb-1">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                            <p class="card-text mb-1">Weight: {{ ($product->weight ?? 0) / 1000 }} kg</p>
                                            <div class="d-flex align-items-center mt-3">
                                                <input type="number" name="quantity" min="1" value="{{ $cart->qty }}" class="form-control me-2 quantity-input" data-cart-id="{{ $cart->id }}" style="width: 80px;">
                                                <button class="btn btn-primary btn-sm btn-update-quantity" data-cart-id="{{ $cart->id }}">Update</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <p class="mt-3">Subtotal:</p>
                                        <p class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <button class="btn btn-danger btn-sm mt-4 btn-remove-cart" data-cart-id="{{ $cart->id }}">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow p-4" style="background-color: #393E46; color: white;">
                            <h5 class="mb-4">Order Summary</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total</span>
                                <strong id="total-price">Rp 0</strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Weight</span>
                                <strong id="total-weight">0 KG</strong>
                            </div>

                            <hr style="border-color: #EEEEEE;">
                            <div class="d-flex justify-content-between mb-4">
                                <span>Grand Total</span>
                                <strong id="grand-total">Rp 0</strong>
                            </div>

                            <button type="button" id="btn-checkout" class="btn btn-success w-100">Checkout</button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    @else
        <div class="alert alert-warning">
            Please <a href="{{ route('login') }}">login</a> to view your cart.
        </div>
    @endif
</div>

<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    function updateTotal() {
        let total = 0;
        let totalWeight = 0;

        $('.select-item:checked').each(function() {
            total += parseInt($(this).data('subtotal'));
            let row = $(this).closest('.row.g-0');
            let quantity = parseInt(row.find('.quantity-input').val());
            let weightText = row.find('.card-text.mb-1:eq(1)').text();
            let weightValue = parseFloat(weightText.replace('Weight: ', '').replace(' kg', ''));

            totalWeight += (weightValue * quantity);
        });

        $('#total-price').text('Rp ' + total.toLocaleString('id-ID'));
        $('#total-weight').text(totalWeight.toLocaleString('id-ID') + ' kg');
        $('#grand-total').text('Rp ' + total.toLocaleString('id-ID'));
    }

    $('.select-item').on('change', function() {
        updateTotal();
    });

    $('.btn-update-quantity').click(function(e) {
        e.preventDefault();
        const cartId = $(this).data('cart-id');
        const quantityInput = $(`input.quantity-input[data-cart-id="${cartId}"]`);
        let quantity = parseInt(quantityInput.val());

        if (quantity < 1) {
            Swal.fire('Warning!', 'Minimum quantity is 1.', 'warning');
            quantityInput.val(1);
            return;
        }

        $.ajax({
            url: '/cart/' + cartId,
            type: 'PUT',
            data: { quantity: quantity },
            success: function(response) {
                Swal.fire('Updated!', response.message || 'Quantity updated!', 'success').then(() => { location.reload(); });
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Failed to update quantity.', 'error');
            }
        });
    });

    $('.btn-remove-cart').click(function(e) {
        e.preventDefault();
        const cartId = $(this).data('cart-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/cart/' + cartId,
                    type: 'DELETE',
                    success: function(response) {
                        Swal.fire('Removed!', response.message || 'Item removed from cart!', 'success').then(() => { location.reload(); });
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', 'Failed to remove item.', 'error');
                    }
                });
            }
        });
    });

    $('#btn-checkout').click(function() {
        let selectedItems = [];
        $('.select-item:checked').each(function() {
            selectedItems.push($(this).val());
        });

        if (selectedItems.length === 0) {
            Swal.fire('Warning!', 'Please select at least one item to checkout.', 'warning');
            return;
        }

        let selectedIds = selectedItems.join(',');
        window.location.href = '/checkout?selected_cart_ids=' + selectedIds;
    });
});
</script>
@endsection

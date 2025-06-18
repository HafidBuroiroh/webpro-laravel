@extends('frontend.layout')

@section('title', 'Checkout')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="banner-container position-relative overflow-hidden" style="height: 150px; background-color: #222831;">
    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="z-index: 2;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h1 class="text-white mb-3 text-center" style="font-family: 'Sniglet', system-ui; font-weight: 800; font-size: 3.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                        Checkout
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    @if(Auth::check())
        @if($carts->isEmpty())
            <div class="alert alert-info">No items selected for checkout.</div>
        @else
        @if($errors->has('checkout_error'))
            <div class="alert alert-danger">
                {{ $errors->first('checkout_error') }}
            </div>
        @endif
            <form id="checkout-form" method="POST" action="{{ route('process.checkout') }}">
                @csrf
                <input type="hidden" name="selected_cart_ids" value="{{ implode(',', $selectedCartIds) }}">
                <input type="hidden" id="total_weight_hidden" value="{{ $totalWeight }}">
                <input type="hidden" id="product_total_hidden" value="{{ $productTotal }}">
                @foreach($carts as $cart)
                    <input type="hidden" name="id_pkh[]" value="{{ $cart->pkh->id }}">
                    <input type="hidden" name="qty[]" value="{{ $cart->qty }}">
                @endforeach

                <div class="row">
                    <!-- Left Side: Delivery Address and Product List -->
                    <div class="col-lg-8">
                        <!-- Delivery Address Card -->
                        @if($defaultAddress)
                            <input type="hidden" name="address_id" value="{{ $defaultAddress->id }}">
                            <input type="hidden" id="destination_id" value="{{ $defaultAddress->rajaongkir_city_id }}">

                            <div class="card mb-4 border-0 shadow" style="background-color: #393E46; color: white;">
                                <div class="card-body">
                                    <h5 class="card-title" style="color: #EEEEEE;">Delivery Address</h5>
                                    <p class="card-text mb-0">{{ $defaultAddress->full_address }}</p>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">You don't have any saved address.</div>
                        @endif

                        <!-- Product List -->
                        @foreach($carts as $cart)
                            @php
                                $product = $cart->pkh;
                                $imagePath = $product && $product->foto
                                    ? asset('pkh_img/' . $product->foto)
                                    : 'https://via.placeholder.com/300x200?text=No+Image';

                                $subtotal = $product->harga * $cart->qty;
                            @endphp

                            <div class="card mb-4 border-0 shadow" style="background-color: #393E46; color: white;">
                                <div class="row g-0 align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ $imagePath }}" class="img-fluid rounded-start" alt="{{ $product->nama }}">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <h5 class="card-title" style="color: #EEEEEE;">{{ $product->nama }}</h5>
                                            <p class="card-text mb-1">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                            <p class="card-text mb-1">Qty: {{ $cart->qty }}</p>
                                            <p class="card-text mb-1">Weight: {{ ($product->weight ?? 0) / 1000 }} kg</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-end px-4">
                                        <p class="mt-3">Subtotal: <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Right Side: Order Summary -->
                    <div class="col-lg-4">
                        <div class="card shadow p-4" style="background-color: #393E46; color: white;">
                            <h5 class="mb-4">Order Summary</h5>

                            <div class="mb-3">
                                <label for="courier" class="form-label">Select Courier</label>
                                <select class="form-select" id="courier" name="courier">
                                    <option value="">-- Select Courier --</option>
                                    <option value="jne">JNE</option>
                                    <option value="tiki">TIKI</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="service" class="form-label">Select Service</label>
                                <select class="form-select" id="service" name="shipping_cost">
                                    <option value="">-- Select Service --</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Price</span>
                                <strong>Rp {{ number_format($productTotal, 0, ',', '.') }}</strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Weight</span>
                                <strong>{{ $totalWeight / 1000 }} kg</strong>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping Cost</span>
                                <strong id="shipping-cost-display">Rp 0</strong>
                            </div>

                            <hr style="border-color: #EEEEEE;">
                            <div class="d-flex justify-content-between mb-4">
                                <span>Grand Total</span>
                                <strong id="grand-total-display">Rp {{ number_format($productTotal, 0, ',', '.') }}</strong>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Proceed to Payment</button>
                        </div>
                    </div>
                </div>
            </form>
        @endif
    @else
        <div class="alert alert-warning">
            Please <a href="{{ route('login') }}">login</a> to proceed to checkout.
        </div>
    @endif
</div>

<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    function calculateGrandTotal(shippingCost) {
        let productTotal = parseInt($('#product_total_hidden').val());
        let grandTotal = productTotal + shippingCost;
        $('#grand-total-display').text('Rp ' + grandTotal.toLocaleString('id-ID'));
    }

    $('#courier').change(function() {
        let courier = $(this).val();
        let destinationId = $('#destination_id').val();
        let totalWeight = parseInt($('#total_weight_hidden').val());

        if (courier && destinationId) {
            $.ajax({
                url: '/get-shipping-cost',
                type: 'POST',
                data: {
                    destination_id: destinationId,
                    weight: totalWeight,
                    courier: courier
                },
                success: function(response) {
                    let shippingOptions = response.rajaongkir.results[0].costs;
                    let shippingSelect = $('#service');
                    shippingSelect.empty();
                    shippingSelect.append('<option value="">-- Select Service --</option>');
                    shippingOptions.forEach(option => {
                        shippingSelect.append(
                            `<option value="${option.cost[0].value}">${option.service} - Rp ${option.cost[0].value.toLocaleString('id-ID')} (ETD: ${option.cost[0].etd} Hari)</option>`
                        );
                    });
                },
                error: function() {
                    Swal.fire('Error!', 'Failed to get shipping cost.', 'error');
                }
            });
        }
    });

    $('#service').change(function() {
        let shippingCost = parseInt($(this).val());
        $('#shipping-cost-display').text('Rp ' + shippingCost.toLocaleString('id-ID'));
        calculateGrandTotal(shippingCost);
    });
});
</script>
@endsection

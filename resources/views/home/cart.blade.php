@extends('layout.home')
@section('title', 'Cart')
@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="breadcrumb-text">
          <p>Fresh and Organic</p>
          <h1>Cart</h1>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end breadcrumb section -->

<!-- cart -->
<div class="cart-section mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-12">
        <div class="cart-table-wrap">
          <table class="cart-table">
            <thead class="cart-table-head">
              <tr class="table-head-row">
                <th class="product-remove"></th>
                <th class="product-image">Product Image</th>
                <th class="product-name">Name</th>
                <th class="product-price">Price</th>
                <th class="product-quantity">Quantity</th>
                <th class="product-total">Total</th>
              </tr>
            </thead>
            <tbody>
              @php
                $checkoutTotal = 0;
              @endphp
              <input type="hidden" name="id_customer" value="{{ Auth::guard('webcustomer')->user()->id }}">
              @foreach ($carts as $cart)
              @php
                $checkoutTotal += $cart->total;
                $discount = $discounts->where('id_barang', $cart->product->id)->where('start_date', '<=', now())->where('end_date', '>=', now())->first();
              @endphp
              <input type="hidden" name="id_produk[]" value="{{ $cart->product->id }}">
              <input type="hidden" name="jumlah[]" value="{{ $cart->jumlah }}">
              <input type="hidden" name="total[]" value="{{ $cart->total }}">
              <tr class="table-body-row">
                <td class="product-remove"><a href="/delete_from_cart/{{ $cart->id }}"><i class="far fa-window-close"></i></a></td>
                <td class="product-image"><img src="/uploads/{{ $cart->product->foto1 }}" alt=""></td>
                <td class="product-name">{{ $cart->product->product_name }}</td>
                @if ($discount)
                <td class="product-price">RP {{ number_format($cart->product->price * (1 - $discount->percentage / 100)) }}</td>
                @else
                <td class="product-price">{{ "Rp ". number_format($cart->product->price) }}</td>
                @endif
                <td class="product-quantity"><input type="number" placeholder="0"></td>
                <td class="product-total">{{ "Rp ". number_format($cart->total) }}</td>
              </tr>
              @endforeach
              <input type="hidden" name="grand_total" value="{{ $checkoutTotal }}">
            </tbody>
          </table>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="total-section">
          <table class="total-table">
            <thead class="total-table-head">
              <tr class="table-total-row">
                <th>Total</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody>
              <tr class="total-data">
                <td><strong>Subtotal: </strong></td>
                <td>$500</td>
              </tr>
              <tr class="total-data">
                <td><strong>Shipping: </strong></td>
                <td>$45</td>
              </tr>
              <tr class="total-data">
                <td><strong>Total: </strong></td>
                <td>$545</td>
              </tr>
            </tbody>
          </table>
          <div class="cart-buttons">
            <a href="cart.html" class="boxed-btn">Update Cart</a>
            <a href="checkout.html" class="boxed-btn black">Check Out</a>
          </div>
        </div>

        <div class="coupon-section">
          <h3>Apply Coupon</h3>
          <div class="coupon-form-wrap">
            <form action="index.html">
              <p><input type="text" placeholder="Coupon"></p>
              <p><input type="submit" value="Apply"></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end cart -->

@endsection

@push('js')
  <script>
    $(function() {
      $('.checkout').click(function(e){
        e.preventDefault()
        $.ajax({
          url: '/checkout_orders',
          method: 'POST',
          data: $('.form-cart').serialize(),
          headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
          },
          success: function(){
            location.href = '/checkout'
          }
        })
      })
    })
  </script>
@endpush
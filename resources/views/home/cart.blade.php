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
    <form class="form-cart">
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
                $total_weight = 0;
              @endphp
              <input type="hidden" name="id_customer" value="{{ Auth::guard('webcustomer')->user()->id }}">
              @foreach ($carts as $cart)
              @php
                $discount = $discounts->where('id_barang', $cart->product->id)->where('start_date', '<=', now())->where('end_date', '>=', now())->first();
                $total_weight += 1 * $cart->jumlah;
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
                <td class="product-quantity">{{ $cart->jumlah }}</td>
                <td class="product-total">{{ "Rp ". number_format($cart->total) }}</td>
              </tr>
              @endforeach
              <input type="hidden" name="total_weight" id="total_weight" value="{{ $total_weight }}">
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
                <td class="cart-total">{{ $cart_total }}</td>
              </tr>
              <tr class="total-data">
                <td><strong>Shipping: </strong></td>
                <td class="shipping-cost">0</td>
              </tr>
              <tr class="total-data">
                <td><strong>Total: </strong></td>
                <input type="hidden" name="grand_total" class="grand_total">
                <td class="amount grand-total">0</td>
              </tr>
            </tbody>
          </table>
          <div class="cart-buttons">
            <a href="#" class="boxed-btn black checkout">Check Out</a>
          </div>
        </div>

        <div class="coupon-section">
          <h3>Calculate Shipping</h3>
          <div class="coupon-form-wrap">
              <p>
                <select name="provinsi" id="provinsi" class="provinsi">
                  <option value="">Select Province</option>
                  @foreach($provinsi->rajaongkir->results as $provinsi)
                  <option value="{{ $provinsi->province_id }}">{{ $provinsi->province }}</option>
                  @endforeach
                </select>
              </p>
              <p>
                <select name="kota" id="kota" class="kota"></select>
              </p>
              <p><a href="#" class="update-total">Update Totals</a></p>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- end cart -->

@endsection

@push('js')
  <script>
    $(function() {
      $('.provinsi').change(function(){
        $.ajax({
          url : '/get_city/' + $(this).val(),
          success : function (data){
            data = JSON.parse(data)
            option = ""
            data.rajaongkir.results.map((kota)=> {
              option += `<option value=${kota.city_id}>${kota.city_name}</option>`
            })
            $('.kota').html(option)
          }
        })
      })
      $('.update-total').click(function(e){
        e.preventDefault()
        var totalWeight = $('#total_weight').val();
        $.ajax({
          url : '/get_ongkir/' + $('.kota').val() + '/' + totalWeight,
          success : function (data){
            data = JSON.parse(data)
            grandTotal = parseInt(data.rajaongkir.results[0].costs[0].cost[0].value) + parseInt($('.cart-total').text())
            $('.shipping-cost').text(data.rajaongkir.results[0].costs[0].cost[0].value)
            $('.grand-total').text(grandTotal)
            $('.grand_total').val(grandTotal)
          }
        })
      })
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
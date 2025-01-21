@extends('layout.home')
@section('title', 'Checkout')
@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="breadcrumb-text">
          <p>Fresh and Organic</p>
          <h1>Check Out Product</h1>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end breadcrumb section -->

<!-- check out section -->
<div class="checkout-section mt-150 mb-150">
  <div class="container">
    <form name="checkout" class="checkout" id="checkout-form" method="POST" action="/payments">
      @csrf
      <input type="hidden" name="id_order" value="{{ $orders->id }}">
      <div class="row">
        <div class="col-lg-8">
          <div class="checkout-accordion-wrap">
            <div class="accordion" id="accordionExample">
              <div class="card single-accordion">
                <div class="card-header" id="headingOne">
                  <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Billing Address
                    </button>
                  </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body">
                    <div class="billing-address-form">
                        <p><input type="text" name="atas_nama" value="{{ Auth::guard('webcustomer')->user()->nama_customer }}" placeholder="Nama"></p>
                        <p><input type="text" name="address_detail" value="{{ Auth::guard('webcustomer')->user()->address }}" placeholder="Address"></p>
                        <p><input type="text" name="no_rekening" placeholder="No Rekening"></p>
                        <input type="hidden" name="jumlah" value="{{ $orders->grand_total }}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="order-details-wrap">
            <table class="order-details">
              <thead>
                <tr>
                  <th>Your order Details</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody class="order-details-body">
                <tr>
                  <td>Product</td>
                  <td>Total</td>
                </tr>
                @php
                  $checkoutTotal = 0;
                @endphp
                @foreach ($carts as $cart)
                @php
                  $checkoutTotal += $cart->total;
                @endphp
                <tr>
                  <td>{{ $cart->product->product_name }} <strong class="mx-2">x</strong> {{ $cart->jumlah }}</td>
                  <td>{{ "Rp ". number_format($cart->total) }}</td>
                </tr>
                @endforeach
              </tbody>
              <tbody class="checkout-details">
                <tr>
                  <td>Subtotal</td>
                  <td>Rp. {{ number_format($checkoutTotal) }}</td>
                </tr>
                <tr>
                  <td>Shipping</td>
                  <td>Rp. {{ number_format($orders->grand_total - $checkoutTotal) }}</td>
                </tr>
                <tr>
                  <td>Total</td>
                  <td>Rp. {{ number_format($orders->grand_total) }}</td>
                </tr>
              </tbody>
            </table>
            <a href="javascript:{}" onclick="document.getElementById('checkout-form').submit();" class="boxed-btn">Place Order</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- end check out section -->

@endsection
@extends('layout.home')
@section('title', 'Checkout')
@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="index.html">Home</a> <span class="mx-2 mb-0">/</span>
        <strong class="text-black">Checkout</strong>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <form name="checkout" class="checkout" method="POST" action="/payments">
      <div class="row">
        <div class="col-md-6 mb-5 mb-md-0">
          <h2 class="h3 mb-3 text-black">Billing Details</h2>
          <div class="p-3 p-lg-5 border">
            @csrf
              <input type="hidden" name="id_order" value="{{ $orders->id }}">
              <div class="form-group row">
                <div class="col-md-12">
                  <label for="atas_nama" class="text-black">Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="atas_nama" name="atas_nama" placeholder="Name">
                </div>
              </div>

              <div class="form-group">
                <label for="address_detail" class="text-black">Address <span class="text-danger">*</span></label>
                <textarea name="address_detail" id="address_detail" cols="30" rows="5" class="form-control"
                  placeholder="Address Detail...">{{ Auth::guard('webcustomer')->user()->address }}</textarea>
              </div>

              <div class="form-group row">
                <div class="col-md-12">
                  <label for="no_rekening" class="text-black">Bank Account Number <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="no_rekening" name="no_rekening" placeholder="Bank Account">
                </div>
              </div>
            </form>

          </div>
        </div>
        <div class="col-md-6">

          <div class="row mb-5">
            <div class="col-md-12">
              <h2 class="h3 mb-3 text-black">Your Order</h2>
              <div class="p-3 p-lg-5 border">
                <table class="table site-block-order-table mb-5">
                  <thead>
                    <th>Product</th>
                    <th>Total</th>
                  </thead>
                  <tbody>
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
                    <input type="hidden" name="jumlah" value="{{ $checkoutTotal }}">
                    <tr>
                      <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                      <td class="text-black font-weight-bold"><strong>{{ "Rp ". number_format($checkoutTotal) }}</strong></td>
                    </tr>
                  </tbody>
                </table>

                <div class="border mb-3">
                  <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsebank" role="button"
                      aria-expanded="false" aria-controls="collapsebank">Direct Bank Transfer</a></h3>

                  <div class="collapse" id="collapsebank">
                    <div class="py-2 px-4">
                      <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the
                        payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                    </div>
                  </div>
                </div>

                <div class="border mb-3">
                  <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsecheque" role="button"
                      aria-expanded="false" aria-controls="collapsecheque">Cheque Payment</a></h3>

                  <div class="collapse" id="collapsecheque">
                    <div class="py-2 px-4">
                      <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the
                        payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                    </div>
                  </div>
                </div>

                <div class="border mb-5">
                  <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsepaypal" role="button"
                      aria-expanded="false" aria-controls="collapsepaypal">Paypal</a></h3>

                  <div class="collapse" id="collapsepaypal">
                    <div class="py-2 px-4">
                      <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the
                        payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <input type="submit" class="btn btn-primary btn-lg btn-block" value="Place Order">
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
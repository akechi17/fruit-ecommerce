@extends('layout.home')
@section('title', 'Cart')
@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> 
        <strong class="text-black">Cart</strong>
      </div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row mb-5">
      <form class="col-md-12 form-cart">
        <div class="site-blocks-table">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="product-thumbnail">Image</th>
                <th class="product-name">Product</th>
                <th class="product-price">Price</th>
                <th class="product-quantity">Quantity</th>
                <th class="product-total">Total</th>
                <th class="product-remove">Remove</th>
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
              @endphp
              
              <input type="hidden" name="id_produk[]" value="{{ $cart->product->id }}">
              <input type="hidden" name="jumlah[]" value="{{ $cart->jumlah }}">
              <input type="hidden" name="total[]" value="{{ $cart->total }}">
              <tr>
                <td class="product-thumbnail">
                  <img src="/uploads/{{ $cart->product->foto1 }}" alt="Image" class="img-fluid">
                </td>
                <td class="product-name">
                  <h2 class="h5 text-black">{{ $cart->product->product_name }}</h2>
                </td>
                <td>{{ "Rp ". number_format($cart->product->price) }}</td>
                <td>{{ $cart->jumlah }}</td>
                <td>{{ "Rp ". number_format($cart->total) }}</td>
                <td><a href="/delete_from_cart/{{ $cart->id }}" class="btn btn-primary height-auto btn-sm">X</a></td>
              </tr>
              @endforeach
              <input type="hidden" name="grand_total" value="{{ $checkoutTotal }}">
            </tbody>
          </table>
        </div>
      </form>
    </div>

    <div class="row">
      <div class="col-md-6">
      </div>
      <div class="col-md-6 pl-5">
        <div class="row justify-content-end">
          <div class="col-md-7">
            <div class="row">
              <div class="col-md-12 text-right border-bottom mb-5">
                <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
              </div>
            </div>
            <div class="row mb-5">
              <div class="col-md-6">
                <span class="text-black">Total</span>
              </div>
              <div class="col-md-6 text-right">
                <strong class="text-black">{{ "Rp ". number_format($checkoutTotal) }}</strong>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <a href="#" class="btn btn-primary btn-lg btn-block checkout">Proceed To
                  Checkout</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection




      <!-- Cart -->
      <section class="section-wrap shopping-wishlist">
        <div class="container relative">
          <form class="form-wishlist">
            <input type="hidden" name="id_customer" value="{{ Auth::guard('webcustomer')->user()->id }}">
            <div class="row">
              <div class="col-md-12">
                <div class="table-wrap mb-30">
                  <table class="shop_table wishlist table">
                    <thead>
                      <tr>
                        <th class="product-name" colspan="2">Product</th>
                        <th class="product-price">Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($wishlists as $wishlist)
                      <input type="hidden" name="id_produk[]" value="{{ $wishlist->product->id }}">
                      <tr class="wishlist_item">
                        <td class="product-thumbnail">
                          <a href="#">
                            <img src="/uploads/{{ $wishlist->product->gambar1 }}" alt="">
                          </a>
                        </td>
                        <td class="product-name">
                          <a href="#">{{ $wishlist->product->nama_barang }}</a>
                        </td>
                        <td class="product-price">
                          <span class="amount">{{ "Rp ". number_format($wishlist->product->harga) }}</span>
                        </td>
                        <td class="product-remove">
                          <a href="/delete_from_wishlist/{{ $wishlist->id }}" class="remove" title="Remove this item">
                            <i class="ui-close"></i>
                          </a>
                        </td>
                      </tr>
                      @endforeach     
                    </tbody>
                  </table>
                </div>
              </div> <!-- end col -->
            </div> <!-- end row -->  
          </form>

          
        </div> <!-- end container -->
      </section> <!-- end wishlist -->
@extends('layout.home')
@section('title', 'Wishlist')
@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="breadcrumb-text">
          <p>Fresh and Organic</p>
          <h1>Wishlist</h1>
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
      <div class="col-lg-12 col-md-12">
        <div class="cart-table-wrap">
          <table class="cart-table">
            <thead class="cart-table-head">
              <tr class="table-head-row">
                <th class="product-remove"></th>
                <th class="product-image">Product Image</th>
                <th class="product-name">Name</th>
                <th class="product-price">Price</th>
              </tr>
            </thead>
            <tbody>
              <input type="hidden" name="id_customer" value="{{ Auth::guard('webcustomer')->user()->id }}">
              @foreach ($wishlists as $wishlist)
              {{-- @php
                $discount = $discounts->where('id_barang', $wishlist->product->id)->where('start_date', '<=', now())->where('end_date', '>=', now())->first();
              @endphp --}}
              <tr class="table-body-row">
                <td class="product-remove"><a href="/delete_from_wishlist/{{ $wishlist->id }}"><i class="far fa-window-close"></i></a></td>
                <td class="product-image"><img src="/uploads/{{ $wishlist->product->foto1 }}" alt=""></td>
                <td class="product-name"><a class="text-dark" href="/store/{{ $wishlist->product->id }}">{{ $wishlist->product->product_name }}</a></td>
                {{-- @if ($discount)
                <td class="product-price">RP {{ number_format($wishlist->product->price * (1 - $discount->percentage / 100)) }}</td>
                @else --}}
                <td class="product-price">{{ "Rp ". number_format($wishlist->product->price) }}</td>
                {{-- @endif --}}
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- end cart -->

@endsection
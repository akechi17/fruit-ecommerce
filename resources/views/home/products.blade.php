@extends('layout.home')
@section('title', 'List Products')
@section('content')

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="breadcrumb-text">
          <p>Fresh and Organic</p>
          <h1>Shop</h1>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end breadcrumb section -->

<!-- products -->
<div class="product-section mt-150 mb-150">
  <div class="container">

    <div class="row">
              <div class="col-md-12">
                  <div class="product-filters">
                      <ul>
                          <li class="active" data-filter="*">All</li>
                          <li data-filter=".strawberry">Strawberry</li>
                          <li data-filter=".berry">Berry</li>
                          <li data-filter=".lemon">Lemon</li>
                      </ul>
                  </div>
              </div>
          </div>

    <div class="row product-lists">
      @foreach ($products as $product)
      @php
      $discount = $discounts->where('id_barang', $product->id)->where('start_date', '<=', now())->where('end_date', '>=', now())->first();
      @endphp
      <div class="col-lg-4 col-md-6 text-center strawberry">
        <div class="single-product-item">
          <div class="product-image">
            <a href="/store/{{ $product->id }}"><img src="/uploads/{{ $product->foto1 }}" alt=""></a>
          </div>
          <h3>{{ $product->product_name }}</h3>
          @if ($discount)
            <p class="product-price"><span>Per Kg</span> <del>RP {{ number_format($product->price) }}</del> RP {{ number_format($product->price * (1 - $discount->percentage / 100)) }} </p>
          @else
            <p class="product-price"><span>Per Kg</span> RP {{ number_format($product->price) }} </p>
          @endif
          <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
        </div>
      </div>
      @endforeach
    </div>

    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="pagination-wrap">
          <ul>
            <li><a href="#">Prev</a></li>
            <li><a href="#">1</a></li>
            <li><a class="active" href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">Next</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end products -->
@endsection
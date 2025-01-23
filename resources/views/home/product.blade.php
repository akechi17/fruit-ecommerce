@extends('layout.home')
@section('title', 'Product')

@section('content')

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="breadcrumb-text">
          <p>See more Details</p>
          <h1>{{ $product->product_name }}</h1>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end breadcrumb section -->

<!-- single product -->
<div class="single-product mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <div class="single-product-img">
          <img src="../uploads/{{ $product->foto1 }}" alt="">
        </div>
      </div>
      <div class="col-md-7">
        <div class="single-product-content">
          <h3>{{ $product->product_name }}</h3>
          @if ($discount)
            <p class="single-product-pricing"><span>Per Kg</span> <del>RP {{ number_format($product->price) }}</del> RP {{ number_format($product->price * (1 - $discount->percentage / 100)) }}</p>
          @else
            <p class="single-product-pricing"><span>Per Kg</span> Rp. {{ number_format($product->price) }}</p>
          @endif
          <p>{{ $product->deskripsi }}</p>
          <div class="single-product-form">
            <form>
              <input type="number" class="jumlah" title="Qty" step="1" min="1" placeholder="Jumlah (Kg)">
            </form>
            <a href="#" class="cart-btn add-to-cart"><i class="fas fa-shopping-cart"></i> Add to Cart</a>
            <a href="#" class="cart-btn add-to-wishlist"><i class="fa fa-heart"></i> Add to Wishlist</a>
            <p><strong>Stok: </strong>{{ $product->stok }}</p>
          </div>
          <h4>Share:</h4>
          <ul class="product-share">
            <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
            <li><a href=""><i class="fab fa-twitter"></i></a></li>
            <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
            <li><a href=""><i class="fab fa-linkedin"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end single product -->

<!-- more products -->
<div class="more-products mb-150">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="section-title">	
          <h3><span class="orange-text">Related</span> Products</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
        </div>
      </div>
    </div>
    <div class="row">
      @foreach ($latest_products as $product)
      <div class="col-lg-4 col-md-6 text-center">
        <div class="single-product-item">
          <div class="product-image">
            <a href="/store/{{ $product->id }}"><img src="../uploads/{{ $product->foto1 }}" alt=""></a>
          </div>
          <h3>{{ $product->product_name }}</h3>
          @if ($discount)
            <p class="product-price"><span>Per Kg</span> <del>RP {{ number_format($product->price) }}</del> RP {{ number_format($product->price * (1 - $discount->percentage / 100)) }} </p>
          @else
            <p class="product-price"><span>Per Kg</span> RP {{ number_format($product->price) }} </p>
          @endif
          <a href="/store/{{ $product->id }}" class="cart-btn">View Product</a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
<!-- end more products -->

@endsection

@push('js')
  <script>
    $(function(){
      $('.add-to-cart').click(function(e){
        id_customer = {{Auth::guard('webcustomer')->user()->id}}
        id_barang = {{ $product->id }}
        jumlah = $('.jumlah').val()
        @if ($discount)
          total = {{ $product->price * (1 - $discount->percentage / 100) }} * jumlah;
        @else
          total = {{ $product->price }} * jumlah;
        @endif
        is_checkout = 0

        $.ajax({
          url : "/add_to_cart",
          method : "POST",
          headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
          },
          data : {
            id_customer,
            id_barang,
            jumlah,
            total,
            is_checkout,
          },
          success : function (data) {
            window.location.href = '/cart';
          }
        });
      })
      $('.add-to-wishlist').click(function(e){
        e.preventDefault();
        id_customer = {{Auth::guard('webcustomer')->user()->id}}
        id_barang = {{ $product->id }}
        is_checkout = 0

        $.ajax({
          url : "/add_to_wishlist",
          method : "POST",
          headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
          },
          data : {
            id_customer,
            id_barang,
            is_checkout,
          },
          success : function (data) {
            window.location.href = '/wishlist';
          }
        });
      })
    })
  </script>
@endpush 
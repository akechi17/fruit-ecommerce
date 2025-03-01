@extends('layout.home')
@section('content')
<!-- hero area -->
	<div class="hero-area hero-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1 text-center">
					<div class="hero-text">
						<div class="hero-text-tablecell">
							<p class="subtitle">Fresh & Organic</p>
							<h1>Delicious Seasonal Fruits</h1>
							<div class="hero-btns">
								<a href="/stores/buah" class="boxed-btn">Fruit Collection</a>
								<a href="/stores/sayur" class="bordered-btn">Vegetable Collection</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end hero area -->

<!-- features list section -->
<div class="list-section pt-80 pb-80">
  <div class="container">

    <div class="row">
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <div class="list-box d-flex align-items-center">
          <div class="list-icon">
            <i class="fas fa-shipping-fast"></i>
          </div>
          <div class="content">
            <h3>Free Shipping</h3>
            <p>When order over $75</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
        <div class="list-box d-flex align-items-center">
          <div class="list-icon">
            <i class="fas fa-phone-volume"></i>
          </div>
          <div class="content">
            <h3>24/7 Support</h3>
            <p>Get support all day</p>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="list-box d-flex justify-content-start align-items-center">
          <div class="list-icon">
            <i class="fas fa-sync"></i>
          </div>
          <div class="content">
            <h3>Refund</h3>
            <p>Get refund within 3 days!</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- end features list section -->

<!-- product section -->
<div class="product-section mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="section-title">	
          <h3><span class="orange-text">Our</span> Products</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
        </div>
      </div>
    </div>

    <div class="row">
      @foreach ($products as $product)
      @php
      $discount = $discounts->where('id_barang', $product->id)->where('start_date', '<=', now())->where('end_date', '>=', now())->first();
      $discountcategory = $discountcategories->where('category', $product->category)->where('start_date', '<=', now())->where('end_date', '>=', now())->first();
      @endphp
      <div class="col-lg-4 col-md-6 text-center">
        <div class="single-product-item">
          <div class="product-image">
            <a href="/store/{{ $product->id }}"><img src="/uploads/{{ $product->foto1 }}" alt=""></a>
          </div>
          <h3>{{ $product->product_name }}</h3>
          @if ($discount && $discountcategory)
          <p class="product-price"><span>Per Kg</span> <del>RP {{ number_format($product->price) }}</del> RP {{ number_format($product->price * (1 - ($discount->percentage + $discountcategory->percentage) / 100)) }} </p>
          @elseif ($discount)
          <p class="product-price"><span>Per Kg</span> <del>RP {{ number_format($product->price) }}</del> RP {{ number_format($product->price * (1 - $discount->percentage / 100)) }} </p>
          @elseif ($discountcategory)
          <p class="product-price"><span>Per Kg</span> <del>RP {{ number_format($product->price) }}</del> RP {{ number_format($product->price * (1 - $discountcategory->percentage / 100)) }} </p>
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
<!-- end product section -->

<!-- cart banner section -->
<section class="cart-banner pt-100 pb-100">
  <div class="container">
      <div class="row clearfix">
          <!--Image Column-->
          <div class="image-column col-lg-6">
              <div class="image">
                  <div class="price-box">
                      <div class="inner-price">
                            <span class="price">
                                <strong>30%</strong> <br> off per kg
                            </span>
                        </div>
                    </div>
                  <img src="../frontend/assets/img/a.jpg" alt="">
                </div>
            </div>
            <!--Content Column-->
            <div class="content-column col-lg-6">
      <h3><span class="orange-text">Deal</span> of the month</h3>
                <h4>Hikan Strwaberry</h4>
                <div class="text">Quisquam minus maiores repudiandae nobis, minima saepe id, fugit ullam similique! Beatae, minima quisquam molestias facere ea. Perspiciatis unde omnis iste natus error sit voluptatem accusant</div>
                <!--Countdown Timer-->
                <div class="time-counter"><div class="time-countdown clearfix" data-countdown="2020/2/01"><div class="counter-column"><div class="inner"><span class="count">00</span>Days</div></div> <div class="counter-column"><div class="inner"><span class="count">00</span>Hours</div></div>  <div class="counter-column"><div class="inner"><span class="count">00</span>Mins</div></div>  <div class="counter-column"><div class="inner"><span class="count">00</span>Secs</div></div></div></div>
            </div>
        </div>
    </div>
</section>
<!-- end cart banner section -->

<!-- testimonail-section -->
<div class="abt-section mt-150 mb-150">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1 text-center">
        <div class="">
          <div class="single-testimonial-slider">
            <div class="client-avater">
              <img src="../frontend/assets/img/avaters/avatar2.png" alt="">
            </div>
            <div class="client-meta">
              <h3>David Niph <span>Local shop owner</span></h3>
              <p class="testimonial-body">
                " Sed ut perspiciatis unde omnis iste natus error veritatis et  quasi architecto beatae vitae dict eaque ipsa quae ab illo inventore Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium "
              </p>
              <div class="last-icon">
                <i class="fas fa-quote-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end testimonail-section -->

<!-- advertisement section -->
<div class="abt-section mb-150">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-12">
        <div class="abt-bg">
          <a href="https://www.youtube.com/watch?v=DBLlFWYcIGQ" class="video-play-btn popup-youtube"><i class="fas fa-play"></i></a>
        </div>
      </div>
      <div class="col-lg-6 col-md-12">
        <div class="abt-text">
          <p class="top-sub">Since Year 1999</p>
          <h2>We are <span class="orange-text">Fruitkha</span></h2>
          <p>Etiam vulputate ut augue vel sodales. In sollicitudin neque et massa porttitor vestibulum ac vel nisi. Vestibulum placerat eget dolor sit amet posuere. In ut dolor aliquet, aliquet sapien sed, interdum velit. Nam eu molestie lorem.</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente facilis illo repellat veritatis minus, et labore minima mollitia qui ducimus.</p>
          <a href="/about" class="boxed-btn mt-4">know more</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end advertisement section -->

<!-- shop banner -->
<section class="shop-banner">
    <div class="container">
        <h3>December sale is on! <br> with big <span class="orange-text">Discount...</span></h3>
          <div class="sale-percent"><span>Sale! <br> Upto</span>50% <span>off</span></div>
          <a href="/stores/buah" class="cart-btn btn-lg">Shop Now</a>
      </div>
  </section>
<!-- end shop banner -->
@endsection
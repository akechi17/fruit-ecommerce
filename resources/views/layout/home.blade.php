<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Fruitkha - Slider Version</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="../frontend/assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="../frontend/assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="../frontend/assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="../frontend/assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="../frontend/assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="../frontend/assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="../frontend/assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="../frontend/assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="../frontend/assets/css/responsive.css">

</head>
<body>
	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="index.html">
                @php
                  $about = App\Models\About::first();
                  if (Auth::guard('webcustomer')->check()){
                  $user_id = Illuminate\Support\Facades\Auth::guard('webcustomer')->user()->id;
                  $cart_total = App\Models\Cart::where('id_customer', Auth::guard('webcustomer')->user()->id)->where('is_checkout', 0)->count();
                  }
                @endphp
								<img src="../frontend/assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="{{ (Request::is('/') ? 'current-list-item' : '') ? 'current-list-item' : '' }}"><a href="/">Home</a></li>
								<li class="{{ (Request::is('about') ? 'current-list-item' : '') ? 'current-list-item' : '' }}"><a href="/about">About</a></li>
								<li><a href="/contact">Contact</a></li>
								<li><a href="/stores/buah">Shop</a>
									<ul class="sub-menu">
										<li><a href="/stores/buah">Buah</a></li>
										<li><a href="/stores/sayur">Sayur</a></li>
									</ul>
								</li>
								<li>
                  @if (Auth::guard('webcustomer')->check())
									<div class="header-icons">
										<a class="shopping-cart" href="/wishlist"><i class="fas fa-heart"></i></a>
										<a class="shopping-cart" href="/cart"><i class="fas fa-shopping-cart"></i></a>
										<a href="/logout_customer">Logout</a>
									</div>
                  @else
                  <a href="/login_customer">Sign In</a>
                  @endif
								</li>
							</ul>
						</nav>
						<a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
						<div class="mobile-menu"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->
	
	<!-- search area -->
	<div class="search-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<span class="close-btn"><i class="fas fa-window-close"></i></span>
					<div class="search-bar">
						<div class="search-bar-tablecell">
							<h3>Search For:</h3>
							<input type="text" placeholder="Keywords">
							<button type="submit">Search <i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end search area -->

	@yield('content')

	<!-- logo carousel -->
	<div class="logo-carousel-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="logo-carousel-inner">
						<div class="single-logo-item">
							<img src="../frontend/assets/img/company-logos/1.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="../frontend/assets/img/company-logos/2.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="../frontend/assets/img/company-logos/3.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="../frontend/assets/img/company-logos/4.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="../frontend/assets/img/company-logos/5.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end logo carousel -->

	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="footer-box about-widget">
						<h2 class="widget-title">About us</h2>
						<p>{{$about->deskripsi}}</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box get-in-touch">
						<h2 class="widget-title">Get in Touch</h2>
						<ul>
							<li>{{ $about->alamat }}</li>
							<li>{{ $about->email }}</li>
							<li>{{ $about->telepon }}</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box pages">
						<h2 class="widget-title">Pages</h2>
						<ul>
							<li><a href="/">Home</a></li>
							<li><a href="/about">About</a></li>
							<li><a href="/stores/buah">Shop</a></li>
							<li><a href="/contact">Contact</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box subscribe">
						<h2 class="widget-title">Subscribe</h2>
						<p>Subscribe to our mailing list to get the latest updates.</p>
						<form action="index.html">
							<input type="email" placeholder="Email">
							<button type="submit"><i class="fas fa-paper-plane"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end footer -->
	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; 2019 - <a href="https://imransdesign.com/">Imran Hossain</a>,  All Rights Reserved.</p>
				</div>
				<div class="col-lg-6 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end copyright -->
	
	<!-- jquery -->
	<script src="../frontend/assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="../frontend/assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="../frontend/assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="../frontend/assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="../frontend/assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="../frontend/assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="../frontend/assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="../frontend/assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="../frontend/assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="../frontend/assets/js/main.js"></script>
  	@stack('js')

</body>
</html>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../admin/assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>@yield('title')</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="../admin/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../admin/assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="../admin/assets/demo/demo.css" rel="stylesheet" />
</head>

<body>
    <div class="wrapper ">
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="logo">
                <a href="https://www.creative-tim.com" class="simple-text logo-mini">
                </a>
                <a href="https://www.creative-tim.com" class="simple-text logo-normal">
                Your Logo
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav" id="accordionSidebar">
                    <li class="{{ (Request::is('home') ? 'active' : '') ? 'active' : '' }}">
                        <a href="/home">
                        <i class="nc-icon nc-bank"></i>
                        <p>Home</p>
                        </a>
                    </li>
                    @if (Auth::guard('web')->user()->role == 'admin')
                    <li class="{{ (Request::is('barang') ? 'active' : '') ? 'active' : '' }}">
                        <a href="/barang">
                        <i class="nc-icon nc-single-02"></i>
                        <p>Products</p>
                        </a>
                    </li>
                    <li class="{{ (Request::is('discounts') ? 'active' : '') ? 'active' : '' }}">
                        <a href="/discounts">
                        <i class="nc-icon nc-single-02"></i>
                        <p>Discounts</p>
                        </a>
                    </li>
                    <li class="{{ (Request::is('payment') ? 'active' : '') ? 'active' : '' }}">
                        <a href="/payment">
                        <i class="nc-icon nc-bell-55"></i>
                        <p>Payment</p>
                        </a>
                    </li>
                    <li class="{{ (Request::is('pesanan/*') ? 'active' : '') ? 'active' : '' }} nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pesanan">
                            <i class="nc-icon nc-bell-55"></i>
                            <p>Order</p>
                        </a>
                        <div id="pesanan" class="collapse" aria-labelledby="orderDropdown" data-parent="#accordionSidebar">
                            <div class="py-2 collapse-inner rounded bg-white">
                                <a class="collapse-item" href="/pesanan/baru">New Orders</a>
                                <a class="collapse-item" href="/pesanan/confirmed">Confirmed Orders</a>
                                <a class="collapse-item" href="/pesanan/packed">Packed Orders</a>
                                <a class="collapse-item" href="/pesanan/sent">Sent Orders</a>
                                <a class="collapse-item" href="/pesanan/received">Received Orders</a>
                                <a class="collapse-item" href="/pesanan/finished">Finished Orders</a>
                            </div>
                        </div>
                    </li>
                    @endif
                    @if (Auth::guard('web')->user()->role == 'owner')
                    <li class="{{ (Request::is('report') ? 'active' : '') ? 'active' : '' }}">
                        <a href="/report">
                        <i class="nc-icon nc-single-02"></i>
                        <p>Order Report</p>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="main-panel" style="height: 100vh;">
            <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                        <button type="button" class="navbar-toggler">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </button>
                        </div>
                        <a class="navbar-brand" href="javascript:;">@yield('title')</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link">
                                    {{ Auth::guard('web')->user()->name }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/logout"><span class="btn btn-round btn-danger ms-3">Log Out</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            @yield('content')
            <footer class="footer">
                <div class="container-fluid">
                <div class="row">
                    <nav class="footer-nav">
                    <ul>
                        <li><a href="https://www.creative-tim.com" target="_blank">Creative Tim</a></li>
                        <li><a href="https://www.creative-tim.com/blog" target="_blank">Blog</a></li>
                        <li><a href="https://www.creative-tim.com/license" target="_blank">Licenses</a></li>
                    </ul>
                    </nav>
                    <div class="credits ml-auto">
                    <span class="copyright">
                        © 2020, made with <i class="fa fa-heart heart"></i> by Creative Tim
                    </span>
                    </div>
                </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="../admin/assets/js/core/jquery.min.js"></script>
    <script src="../admin/assets/js/core/popper.min.js"></script>
    <script src="../admin/assets/js/core/bootstrap.min.js"></script>
    <script src="../admin/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="../admin/assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="../admin/assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="../admin/assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>

    @stack('js')

</body>

</html>
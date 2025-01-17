<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../admin/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../admin/assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Register</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="/admin/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/admin/assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link href="/admin/assets/demo/demo.css" rel="stylesheet" />
  </head>
  <body>
      <div class="w-50 rounded px-3 py-3 mx-auto">
        <div class="card card-user">
          <div class="card-header">
            <h5 class="card-title">Register</h5>
          </div>
          <div class="card-body">
            <form action="/register_customer" method="POST">
              @csrf
              @if (Session::has('errors'))
                <ul>
                  @foreach (Session::get('errors_login') as $error)
                    <li style="color: red">{{ $error[0] }}</li>
                  @endforeach
                </ul>       
              @endif
              @if (Session::has('success'))
                <p style="color: green">{{ Session::get('success') }}</p>
              @endif
              @if (Session::has('failed'))
                <p style="color: red">{{ Session::get('failed') }}</p>
              @endif
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" class="form-control" placeholder="Customer Name" name='nama_customer'>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Phone Number</label>
                    <input type="number" class="form-control" placeholder="Phone Number" name='no_hp'>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" placeholder="Email" name='email'>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" id="address" cols="30" rows="10" placeholder="Address" class="form-control"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" placeholder="Password" name="password">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Password Confirmation</label>
                    <input type="password" class="form-control" placeholder="Password Confirmation" name="konfirmasi_password">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="update ml-auto mr-auto">
                  <input type="submit" class="btn btn-primary btn-round" value="Register" />
                  <a href="/"><span class="btn btn-round btn-danger ms-3">Cancel</span></a>
                </div>
              </div>
            </form>
          </div>
        </div>

        <a href="/register_customer">Don't Have an Account? Register!</a>
      </div>
    
    <script src="../js/app.js"></script>
    <script src="/admin/assets/js/core/jquery.min.js"></script>
    <script src="/admin/assets/js/core/popper.min.js"></script>
    <script src="/admin/assets/js/core/bootstrap.min.js"></script>
    <script src="/admin/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <script src="/admin/assets/js/plugins/chartjs.min.js"></script>
    <script src="/admin/assets/js/plugins/bootstrap-notify.js"></script>
    <script src="/admin/assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script><!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="/admin/assets/demo/demo.js"></script>
    <script>
      $(document).ready(function() {
        demo.initChartsPages();
      });
    </script>
  </body>
</html>
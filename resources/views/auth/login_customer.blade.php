<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>

<body>
    <div id="login">
        <h3 class="text-center text-white pt-5">Login</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form action="/login_customer" method="POST" id="login-form" class="form-login form user">
                            @csrf
                            @if (Session::has('errors_login'))
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
                            <h3 class="text-center text-info">Login Member</h3>
                            <div class="form-group">
                                <label for="email" class="text-info">Email Address:</label><br>
                                <input type="email" class="form-control" placeholder="Email" name='email' value="{{ Session::get('email') }}">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" class="form-control" placeholder="Password" name="password">
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span></span><span></span></label><br>
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                            <div id="register-link" class="text-right">
                                <a href="/register_customer" class="text-info">Register here</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="sbadmin2/vendor/jquery/jquery.min.js"></script>
</body>

</html>
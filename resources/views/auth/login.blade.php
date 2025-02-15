<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>

<body>
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form method="POST" action="/login" id="login-form" class="form-login form user">
                            @csrf
                            <h3 class="text-center text-info">Login Dashboard</h3>
                            <div class="form-group">
                                <label for="email" class="text-info">Email Address:</label><br>
                                <input type="email" class="form-control email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email" name="email">
                                @error('email')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" class="form-control password" id="exampleInputPassword" placeholder="Password" name="password">
                                @error('password')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                            {{-- <div id="register-link" class="text-right">
                                <a href="#" class="text-info">Register here</a>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script>
        $(function(){
            function setCookie(name,value,days) {
                var expires = "";
                if (days){
                    var date = new Date();
                    date.setTime(date.getTime()+(days*24*60*60*1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name+"="+value+expires+"; path=/";
            }

            $('.form-login').submit(function(e){
                e.preventDefault();
                const email = $('.email').val();
                const password = $('.password').val();
                const csrf_token = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url : '/login',
                    type : 'POST',
                    data : {
                        email : email,
                        password : password,
                        _token : csrf_token
                    },
                    success : function(data){
                        if(!data.success){
                            alert(data.message);
                        }
                        setCookie('token', data.token, 7);
                        window.location.href = '/dashboard';
                    }
                })
            })
        })
    </script>
</body>

</html>
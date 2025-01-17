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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="bg-gradient-primary">

    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
          <a class="navbar-brand" href="/login">Custom Login Register</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
    </nav>    

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
        
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Failed</strong>
                            <p>{{ $errors->first() }}</p>
                        </div>
                        @endif
                        <form method="POST" action="/login" class="form-login user">
                            @csrf
                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control form-control-user email"
                                            id="exampleInputEmail" aria-describedby="emailHelp"
                                            placeholder="Email" name="email">
                                    @error('email')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control form-control-user password"
                                        id="exampleInputPassword" placeholder="Password" name="password">
                                    @error('password')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <button type="submit" class="col-md-3 offset-md-5 btn btn-primary">Login</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>  
    <script src="admin/assets/js/jquery.min.js"></script>
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
                        window.location.href = '/home';
                    }
                })
            })
        })
    </script>

</body>

</html>
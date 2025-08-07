<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ config('app.name') }}" name="description" />
    <meta content="{{ config('app.name') }}" name="author" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<!-- [ signin-img ] start -->
<div class="auth-wrapper align-items-stretch aut-bg-img">
    <div class="flex-grow-1">
        <div class="h-100 d-md-flex align-items-center auth-side-img">
            <div class="col-sm-10 auth-content w-auto">
                <img src="assets/images/auth/auth-logo.png" alt="" class="img-fluid">
                <h1 class="text-white my-4">Welcome Back!</h1>
                <h4 class="text-white font-weight-normal">Signin to your account and get explore the Able pro Dashboard
                    Template.<br />Do not forget to play with live customizer</h4>
            </div>
        </div>
        <div class="auth-side-form">
            <div class=" auth-content">
                <img src="assets/images/auth/auth-logo-dark.png" alt=""
                    class="img-fluid mb-4 d-block d-xl-none d-lg-none">
                @if ($errors->has('error'))
                    <div class="alert alert-danger mt-3" role="alert">
                        {{ $errors->first('error') }}
                    </div>
                @endif
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <h3 class="mb-4 f-w-400">Signin</h3>
                    <div class="form-group mb-3">
                        <label class="floating-label" for="Email">Email address</label>
                        <input type="text" class="form-control" id="Email" name="email" placeholder="">
                        @error('email')
                            <span class="badge badge-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label class="floating-label" for="Password">Password</label>
                        <input type="password" class="form-control" id="Password" name="password" placeholder="">
                        @error('password')
                            <span class="badge badge-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button class="btn btn-block btn-primary mb-4">Signin</button>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/ripple.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
</body>

</html>

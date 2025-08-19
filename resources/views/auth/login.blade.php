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

    <style>
        body {
            font-family: 'Montserrat', sans-serif !important;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('{{ asset('/upload/bg2.png') }}') no-repeat center center/cover;
            
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
        }

        .login-container {
            position: relative;
            display: flex;
           
            border-radius: 10px;
            
            z-index: 1;
        }

        .left-panel {
            text-align: center;
            padding-right: 50px;
            border-right: 2px solid rgba(255, 255, 255, 0.5);
        }

        .left-panel img {
            width: 120px;
            margin-bottom: 20px;
        }

        .left-panel h2 {
            font-size: 22px;
            color: #fff;
            letter-spacing: 2px;
        }

        .right-panel {
            padding-left: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel h3 {
            color: #fff;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 280px;
            padding: 10px;
            border: none;
            outline: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .forgot {
            font-size: 12px;
            color: #aaa;
            margin-bottom: 20px;
        }

        .login-btn {
            padding: 12px;
            width: 120px;
            border: none;
            border-radius: 4px;

            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }



        .error {
            color: #ff6b6b;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    {{-- <div class="overlay"></div> --}}
    <div class="login-container">
        <!-- Left -->
        <div class="left-panel">
            <img src="{{ asset('/upload/logo2.png') }}" alt="Logo">
            <h2>GHQ-JOPS</h2>
        </div>

        <!-- Right -->
        <div class="right-panel">
            <h3>LOG IN</h3>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <input type="text" class="form-control" name="service_no" placeholder="Service Number"
                        value="{{ old('service_no') }}" required autofocus>
                    @error('service_no')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions"
                    style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-top: 10px;">
                    <div class="forgot">
                        <a href="{{ route('password.request') }}" style="color: #aaa; text-decoration: none;">
                            Forgot Password
                        </a>
                    </div>

                    <button type="submit" class="login-btn">GO &gt;</button>
                </div>

            </form>
        </div>
    </div>

    <script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/ripple.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.min.js') }}"></script>
</body>

</html>

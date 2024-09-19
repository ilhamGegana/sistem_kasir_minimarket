<!-- resources/views/layouts/authMaster.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Login | HappyMart')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- Custom CSS -->
    <style>
        /* Custom styling for the login page */
        .login-wrapper {
            height: 100vh;
            display: flex;
        }

        .login-left {
            width: 50%;
            background-color: #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-left img {
            width: 80%;
            height: auto;
        }

        .login-right {
            width: 50%;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-left, .login-right {
                width: 100%;
            }

            .login-left {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition login-page">
    <div class="login-wrapper">
        <div class="row">
            <!-- Bagian gambar login -->
            <div class="col-lg-6 col-md-6 login-left">
                @yield('login-image')
            </div>

            <!-- Bagian form login -->
            <div class="col-lg-6 col-md-6 login-right">
                @yield('login-form')
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

    @stack('scripts')
</body>

</html>

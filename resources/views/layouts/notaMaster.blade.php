<!-- resources/views/layouts/notaMaster.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Nota | HappyMart')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <!-- Custom CSS for Nota -->
    <style>
        /* Custom styling for the nota */
        .nota-container {
            width: 100%;
            max-width: 350px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .nota-header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .nota-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }

        .table-sm th,
        .table-sm td {
            padding: 5px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12px;
            }

            .nota-container {
                width: 100%;
                border: none;
            }

            .no-print {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="nota-container">
        <!-- Bagian header nota -->
        @yield('nota-header')

        <!-- Bagian utama nota -->
        <div class="nota-content">
            @yield('nota-content')
        </div>

        <!-- Bagian footer nota -->
        @yield('nota-footer')
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

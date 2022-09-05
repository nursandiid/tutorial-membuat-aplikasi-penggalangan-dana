<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $setting->company_name }} - @yield('title')</title>
    <link rel="icon" href="{{ url($setting->path_image ?? '#') }}" type="image/*">
    
    <style> <?php include public_path('AdminLTE/dist/css/adminlte.min.css') ?> </style>
    <style>
        html, body, .container {
            height: 100%;
        }

        .bg-light-primary {
            background: #ccedfc;
        }
        .banner-header::after {
            content: '';
            height: 35%;
            background: #ccedfc;
            width: 100%;
            position: absolute;
        }
    </style>
</head>
<body class="bg-light align-items-center">

    <div class="banner-header"></div>

    @yield('content')

</body>
</html>
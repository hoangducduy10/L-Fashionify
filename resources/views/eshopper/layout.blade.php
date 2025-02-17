<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Link đến file CSS -->
    <link rel="stylesheet" href="{{ asset('eshopper/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('eshopper/css/style.css') }}">
</head>
<body>

    @include('eshopper.header') <!-- Thêm header -->
    
    <div class="container">
        @yield('content')
    </div>

    @include('eshopper.footer') <!-- Thêm footer -->

    <!-- Link đến file JS -->
    <script src="{{ asset('eshopper/js/jquery.min.js') }}"></script>
    <script src="{{ asset('eshopper/js/bootstrap.min.js') }}"></script>
</body>
</html>

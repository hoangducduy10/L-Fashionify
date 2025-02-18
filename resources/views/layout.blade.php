<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Shopper')</title>

    <!-- Load CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>

    @include('header') <!-- Load Header -->

    <div class="container">
        @yield('content')
    </div>

    @include('footer') <!-- Load Footer -->

</body>
</html>

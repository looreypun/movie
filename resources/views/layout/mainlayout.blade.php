<!DOCTYPE html>
<html lang="en">
<head>
    @include('layout.header')
</head>
<body>
    @include('layout.nav')

    @yield('content')

    @include('layout.footer')
    
</body>
</html>
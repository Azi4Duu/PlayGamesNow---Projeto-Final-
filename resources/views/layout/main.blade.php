<!DOCTYPE html>
<html lang="en">

@include('layout.parts.head')

<body>

@include('layout.parts.preloader')

@include('layout.parts.navbar')

@yield('content')

@include('layout.parts.footer')

@vite('resources/js/app.js')

@include('layout.parts.scripts')

@stack('scripts')

</body>

</html>

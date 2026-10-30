<!DOCTYPE html>
<html lang="en">

@include('layout.parts.head')

<body>

@include('layout.parts.preloader')

@include('layout.parts.navbar')

<main class="main-content">
    @yield('content')
</main>

@include('layout.parts.footer')

@vite('resources/js/app.js')

@include('layout.parts.scripts')

@stack('scripts')

</body>

</html>

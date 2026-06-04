<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Balai Air Tanah">
    <meta name="keywords" content="Balai Air Tanah">
    <meta name="author" content="Balai Air Tanah">
    <!-- Page Title -->
    <title>@yield('title', 'Balai Air Tanah')</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/sda/web/images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Manrope:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/sda/web/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
    <!-- SlickNav Css -->
    <link href="{{ asset('assets/sda/web/css/slicknav.min.css') }}" rel="stylesheet">
    <!-- Swiper Css -->
    <link rel="stylesheet" href="{{ asset('assets/sda/web/css/swiper-bundle.min.css') }}">
    <!-- Font Awesome Icon Css-->
    <link href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" media="screen">
    <!-- Animated Css -->
    <link href="{{ asset('assets/sda/web/css/animate.css') }}" rel="stylesheet">
    <!-- Magnific Popup Core Css File -->
    <link rel="stylesheet" href="{{ asset('assets/sda/web/css/magnific-popup.css') }}">
    <!-- Main Custom Css -->
    <link href="{{ asset('assets/sda/web/css/custom.css') }}" rel="stylesheet" media="screen">
    @stack('head')
    @vite(['resources/css/app.css', 'resources/css/pages.css'])
    @stack('styles')

    @production
        <!-- Google tag hanya dimuat di production, tidak di local development. -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-HZX91843N9"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', 'G-HZX91843N9');
        </script>
    @endproduction
</head>
<body>
@include('master.navbar')
@yield('content')
@include('master.footer')
<button type="button" class="scroll-top-btn" id="scrollTopBtn" aria-label="Kembali ke atas" aria-hidden="true">
    <i class="fa-solid fa-chevron-up" aria-hidden="true"></i>
</button>
<script src="{{ asset('assets/sda/web/js/jquery-3.7.1.min.js') }}"></script>
<!-- Bootstrap js file -->
<script src="{{ asset('assets/sda/web/js/bootstrap.min.js') }}"></script>
<!-- Validator js file -->
<script src="{{ asset('assets/sda/web/js/validator.min.js') }}"></script>
<!-- SlickNav js file -->
<script src="{{ asset('assets/sda/web/js/jquery.slicknav.js') }}"></script>
<!-- Swiper js file -->
<script src="{{ asset('assets/sda/web/js/swiper-bundle.min.js') }}"></script>
<!-- Counter js file -->
<script src="{{ asset('assets/sda/web/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/sda/web/js/jquery.counterup.min.js') }}"></script>
<!-- Magnific js file -->
<script src="{{ asset('assets/sda/web/js/jquery.magnific-popup.min.js') }}"></script>
<!-- SmoothScroll -->
<script src="{{ asset('assets/sda/web/js/SmoothScroll.js') }}"></script>
<!-- Parallax js -->
<script src="{{ asset('assets/sda/web/js/parallaxie.js') }}"></script>
<!-- Animation helper js file -->
<script src="{{ asset('assets/sda/web/js/gsap.min.js') }}"></script>
<!-- Text Effect js file -->
<script src="{{ asset('assets/sda/web/js/SplitText.js') }}"></script>
<script src="{{ asset('assets/sda/web/js/ScrollTrigger.min.js') }}"></script>
<!-- Wow js file -->
<script src="{{ asset('assets/sda/web/js/wow.js') }}"></script>
<!-- Main Custom js file -->
<script src="{{ asset('assets/sda/web/js/function.js') }}"></script>
@vite(['resources/js/app.js', 'resources/js/pages.js'])
@stack('scripts')
</body>
</html>

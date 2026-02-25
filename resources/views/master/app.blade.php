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
    <title>Beranda - Balai Air Tanah</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="https://sda.pu.go.id/web/images/favicon.png">
    <!-- Google Fonts Css-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="https://sda.pu.go.id/web/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!-- SlickNav Css -->
    <link href="https://sda.pu.go.id/web/css/slicknav.min.css" rel="stylesheet">
    <!-- Swiper Css -->
    <link rel="stylesheet" href="https://sda.pu.go.id/web/css/swiper-bundle.min.css">
    <!-- Font Awesome Icon Css-->
    <link href="https://sda.pu.go.id/web/css/all.css" rel="stylesheet" media="screen">
    <!-- Animated Css -->
    <link href="https://sda.pu.go.id/web/css/animate.css" rel="stylesheet">
    <!-- Magnific Popup Core Css File -->
    <link rel="stylesheet" href="https://sda.pu.go.id/web/css/magnific-popup.css">
    <!-- Mouse Cursor Css File -->
    <link rel="stylesheet" href="https://sda.pu.go.id/web/css/mousecursor.css">
    <!-- Main Custom Css -->
    <link href="https://sda.pu.go.id/web/css/custom.css" rel="stylesheet" media="screen">
    <style>
        .navbar .nav-item .nav-link::after {
            display: none !important;
            content: none !important;
        }
    
        .navbar .nav-item.submenu > .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .navbar .nav-item.submenu > .nav-link .menu-caret {
            margin-left: 2px;
        }
        .navbar .navbar-nav > li.menu-home {
            margin-left: 14px;
        }
        .publication-menu-link {
            color: #ffffff;
            transition: color 0.2s ease;
        }

        .publication-menu-link:hover {
            color: #ffd84d !important;
        }</style>
    <link rel="preload" href="https://sda.pu.go.id/web/images/slider1.webp" as="image">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-HZX91843N9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'G-HZX91843N9');
    </script>
</head>
<body>
@include('master.navbar')
@yield('content')
@include('master.footer')
<script src="https://sda.pu.go.id/web/js/jquery-3.7.1.min.js"></script>
<!-- Bootstrap js file -->
<script src="https://sda.pu.go.id/web/js/bootstrap.min.js"></script>
<!-- Validator js file -->
<script src="https://sda.pu.go.id/web/js/validator.min.js"></script>
<!-- SlickNav js file -->
<script src="https://sda.pu.go.id/web/js/jquery.slicknav.js"></script>
<!-- Swiper js file -->
<script src="https://sda.pu.go.id/web/js/swiper-bundle.min.js"></script>
<!-- Counter js file -->
<script src="https://sda.pu.go.id/web/js/jquery.waypoints.min.js"></script>
<script src="https://sda.pu.go.id/web/js/jquery.counterup.min.js"></script>
<!-- Magnific js file -->
<script src="https://sda.pu.go.id/web/js/jquery.magnific-popup.min.js"></script>
<!-- SmoothScroll -->
<script src="https://sda.pu.go.id/web/js/SmoothScroll.js"></script>
<!-- Parallax js -->
<script src="https://sda.pu.go.id/web/js/parallaxie.js"></script>
<!-- MagicCursor js file -->
<script src="https://sda.pu.go.id/web/js/gsap.min.js"></script>
<script src="https://sda.pu.go.id/web/js/magiccursor.js"></script>
<!-- Text Effect js file -->
<script src="https://sda.pu.go.id/web/js/SplitText.js"></script>
<script src="https://sda.pu.go.id/web/js/ScrollTrigger.min.js"></script>
<!-- Wow js file -->
<script src="https://sda.pu.go.id/web/js/wow.js"></script>
<!-- Main Custom js file -->
<script src="https://sda.pu.go.id/web/js/function.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

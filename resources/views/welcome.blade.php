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

<!-- Preloader Start -->
<!-- <div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="https://sda.pu.go.id/web/images/loader.svg" alt=""></div>
		</div>
	</div>-->
<!-- Preloader End -->

<!-- Header Start -->
<!--<header class="main-header">-->
<div class="header-sticky sticky-top header-top">
    <nav class="navbar navbar-expand-lg bg-scroll">
        <div class="container-fluid">
            <!-- Logo Start -->
            <a class="navbar-brand" href="{{ route('home') }}" style="display:flex;align-items:center;gap:10px;min-height:48px;margin-left:-12px;">
                <img src="{{ asset('images/logo-pu.png') }}" alt="Logo PU" style="width:38px;height:auto;display:block;">
                <span style="display:block;line-height:1.1;font-weight:700;text-transform:uppercase;">
                    <span style="display:block;color:white;font-size:18px;">Balai Air Tanah</span>
                    <span style="display:block;color:white;font-size:12px;">Kementerian Pekerjaan Umum</span>
                </span>
            </a>
            <!-- Logo End -->
<!-- Main Menu Start -->
            <div class="collapse navbar-collapse main-menu">
                <div class="nav-menu-wrapper">
                    <ul class="navbar-nav mr-auto" id="menu">
                        <li class="nav-item menu-home"><a class="nav-link" href="https://sda.pu.go.id/"><ion-icon name="home-outline" aria-hidden="true"></ion-icon></a></li>
                        <li class="nav-item submenu"><a class="nav-link" href="#">Profil <ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon></a>
                            <ul class="sub-menu">
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/profil/struktur_organisasi">Struktur Organisasi</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/profil/informasi_organisasi">Informasi Organisasi</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/profil/informasi_pejabat">Informasi Pejabat</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/profil/informasi_balai">Informasi Balai</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/profil/kontak_kami">Kontak dan Lokasi</a></li>
                            </ul>
                        </li>
                        <li class="nav-item submenu"><a class="nav-link" href="#">Layanan <ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon></a>
                            <ul>
                                <li class="nav-item"><a class="nav-link" href="https://perizinansda.pu.go.id/">Perizinan SDA</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://lapor.go.id">SP4N - LAPOR!</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://wispu.pu.go.id/">Whistleblowing</a></li>
                            </ul>
                        </li>
                        <li class="nav-item submenu"><a class="nav-link" href="#">Informasi Publik <ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon></a>
                            <ul>
                                <li class="nav-item"><a class="nav-link" href="https://sahabat.pu.go.id/eppid/">e-PPID PU</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/pages/informasi-berkala">Informasi Berkala</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/pages/informasi-serta-merta">Informasi Serta Merta</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/pages/informasi-setiap-saat">Informasi Tersedia Setiap Saat</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sitaba.pu.go.id/">Informasi Bencana</a></li>
                            </ul>
                        </li>
                        <li class="nav-item submenu"><a class="nav-link" href="#">Publikasi <ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon></a>
                            <ul class="sub-menu">
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/post">Berita</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/galeri">Galeri</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/dokumen/kategori/booklet">Buletin</a></li>
                            </ul>
                        </li>
                        <li class="nav-item submenu"><a class="nav-link" href="#"><ion-icon name="search-outline" aria-hidden="true"></ion-icon><ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon></a>
                            <ul class="sub-menu">
                                <li class="nav-item">
                                    <form role="search" action="https://sda.pu.go.id/pencarian" method="post">
                                        <div class="simple-search input-group">
                                            <input type="hidden" name="csrf_test_name" value="e5801c3e000816127e1d702742d63a94" />                                            <input class="form-control text-1 bg-warning" id="headerSearch" name="keywords" type="search" value="" placeholder="Search...">
                                            <button class="btn" type="submit">
                                                <ion-icon name="search-outline" class="header-nav-top-icon" aria-hidden="true"></ion-icon>
                                            </button>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item submenu">
                            <a class="nav-link" href="#">
                                <img src="https://flagcdn.com/w20/id.png" width="20" style="max-width: 20px"  alt="Indonesia"> <ion-icon name="chevron-down-outline" class="menu-caret" aria-hidden="true"></ion-icon>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/lang/id"><img src="https://flagcdn.com/w20/id.png" alt="Indonesia" width="20" style="max-width: 20px"> Indonesia</a></li>
                                <li class="nav-item"><a class="nav-link" href="https://sda.pu.go.id/lang/en"><img src="https://flagcdn.com/w20/us.png" alt="English" width="20" style="max-width: 20px"> English</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Main Menu End -->
            <div class="navbar-toggle"></div>
        </div>
    </nav>
    <div class="responsive-menu"></div>
</div>
<!--</header>-->
<!-- Header End -->

<!-- Slider Section Start -->
<div class="hero bg-section hero-slider">
    <div class="hero-slider-layout">
        <div class="swiper">
            <div class="swiper-wrapper">

                <!-- Hero Slide Start -->
                <div class="swiper-slide">
                    <div class="hero-slide">
                        <div class="hero-slider-image">
                            <picture>
                                <source media="(max-width: 799px)" srcset="https://sda.pu.go.id/assets/uploads/pengumuman/Imlek-02.webp"/>
                                <source media="(min-width: 800px)" srcset="https://sda.pu.go.id/assets/uploads/pengumuman/Imlek-02.webp"/>
                                <img height="100%" src="https://sda.pu.go.id/assets/uploads/pengumuman/Imlek-02.webp" alt="Selamat Imlek 2026">
                            </picture>
                        </div>

                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <div class="hero-content">
                                        <div class="section-title mb-lg-5">
                                            <h3 class=" mt-5 mb-3" style="visibility: hidden;">sigap membangun negeri untuk rakyat</h3>
                                            <h1 class="text-anime-style-3 mb-lg-5 pb-lg-5" style="visibility: hidden;" data-cursor="-opaque">#MengelolaAirUntukNegeri</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Hero Slide End -->

                <!-- Hero Slide Start -->
                <div class="swiper-slide">
                    <div class="hero-slide">
                        <!-- Slider Image Start -->
                        <div class="hero-slider-image">
                            <picture>
                                <source media="(max-width: 799px)" srcset="https://sda.pu.go.id/web/images/slider1-480.webp ?>"/>
                                <source media="(min-width: 800px)" srcset="base_url() ?>web/images/slider1.webp?>"/>
                                <img height="100%" src="https://sda.pu.go.id/web/images/slider1.webp?>" alt="Mengelola Air Untuk Negeri">
                            </picture>
                        </div>
                        <!-- Slider Image End -->

                        <!-- Slider Content Start -->
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <!-- Hero Content Start -->
                                    <div class="hero-content">
                                        <div class="section-title mb-lg-5">
                                            <h3 class="wow fadeInUp mt-5 mb-3">sigap membangun negeri untuk rakyat</h3>
                                            <h1 class="text-anime-style-3 mb-lg-5 pb-lg-5" data-cursor="-opaque">#MengelolaAirUntukNegeri</h1>
                                        </div>
                                    </div>
                                    <!-- Hero Content End -->
                                </div>
                            </div>
                        </div>
                        <!-- Slider Content End -->
                    </div>
                </div>
                <!-- Hero Slide End -->

                <!-- Hero Slide Start -->
                <div class="swiper-slide">
                    <div class="hero-slide">
                        <!-- Slider Image Start -->
                        <div class="hero-slider-image">
                            <picture>
                                <source media="(max-width: 799px)" srcset="https://sda.pu.go.id/web/images/slider2-480.webp"/>
                                <source media="(min-width: 800px)" srcset="https://sda.pu.go.id/web/images/slider2.webp"/>
                                <img height="100%" src="https://sda.pu.go.id/web/images/slider1.webp" alt="Mengelola Air Untuk Negeri">
                            </picture>
                        </div>
                        <!-- Slider Image End -->

                        <!-- Slider Content Start -->
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <!-- Hero Content Start -->
                                    <div class="hero-content">
                                        <div class="section-title">
                                            <h3 class="wow fadeInUp  mt-5 mb-3">sigap membangun negeri untuk rakyat</h3>
                                            <h1 class="text-anime-style-3 mb-lg-5 pb-lg-5" data-cursor="-opaque">#MengelolaAirUntukNegeri</h1>
                                        </div>

                                    </div>
                                    <!-- Hero Content End -->
                                </div>
                            </div>
                        </div>
                        <!-- Slider Content End -->
                    </div>
                </div>
                <!-- Hero Slide End -->

                <div class="swiper-slide">
                    <div class="hero-slide">
                        <!-- Slider Image Start -->
                        <div class="hero-slider-image">
                            <picture>
                                <source media="(max-width: 799px)" srcset="https://sda.pu.go.id/web/images/slider3-480.webp"/>
                                <source media="(min-width: 800px)" srcset="https://sda.pu.go.id/web/images/slider3.webp"/>
                                <img height="100%" src="https://sda.pu.go.id/web/images/slider1.webp" alt="Mengelola Air Untuk Negeri">
                            </picture>
                        </div>
                        <!-- Slider Image End -->

                        <!-- Slider Content Start -->
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <!-- Hero Content Start -->
                                    <div class="hero-content">
                                        <div class="section-title mb-lg-5">
                                            <h3 class="wow fadeInUp mt-5 mb-3">sigap membangun negeri untuk rakyat</h3>
                                            <h1 class="text-anime-style-3 mb-lg-5 pb-lg-5" data-cursor="-opaque">#MengelolaAirUntukNegeri</h1>
                                        </div>
                                    </div>
                                    <!-- Hero Content End -->
                                </div>
                            </div>
                        </div>
                        <!-- Slider Content End -->
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div><!-- Slider Section End -->

<!-- About Section Start -->
<div class="about-us" style="background-image: url('web/images/damoutline.webp'); background-repeat: no-repeat; background-position: right;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-5 col-sm-12">
                <!-- About Us Image Start -->
                <div class="about-image">
                    <div class="about-img">
                        <figure class="reveal">
                            <img src="https://sda.pu.go.id/web/images/home1.webp" alt="Balai Air Tanah">
                        </figure>
                    </div>
                </div>
                <!-- About Us Image End -->
            </div>

            <div class="col-lg-7 col-md-7 col-sm-12">
                <!-- About Content Start -->
                <div class="about-content">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Tentang Kami</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Balai Air Tanah</h2>
                        <p class="wow fadeInUp" data-wow-delay="0.25s">Balai Air Tanah mempunyai tugas menyelenggarakan perumusan dan pelaksanaan kebijakan di bidang pengelolaan sumber daya air sesuai dengan ketentuan peraturan perudang-undangan.</p>
                    </div>
                    <!-- Section Title End -->

                    <!-- About Content Body Start -->
                    <div class="about-content-body wow fadeInUp" data-wow-delay="0.5s">
                        <ul>
                            <li>Perumusan dan Pelaksanaan Kebijakan</li>
                            <li>Penyusunan Norma, Standar, Prosedur, dan Kriteria</li>
                            <li>Pemberian Bimbingan Teknis dan Supervisi</li>
                            <li>Pelaksanaan Evaluasi dan Pelaporan serta Administrasi</li>
                        </ul>
                    </div>
                    <!-- About Content Body End -->

                    <!-- About Content Footer Start -->
                    <div class="about-content-footer wow fadeInUp" data-wow-delay="0.75s">
                        <div class="about-footer-btn">
                            <a href="mailto:infosda@pu.go.id" class="btn-default" style="text-transform: lowercase;">infosda@pu.go.id</a>
                        </div>
                        <div class="about-contact-support">
                            <div class="icon-box">
                                <img src="https://sda.pu.go.id/web/images/icon-phone.svg" alt="kontak sda">
                            </div>
                            <div class="about-support-content">
                                <p>Kontak Kami</p>
                                <h3>(021) 158</h3>
                            </div>
                        </div>
                    </div>
                    <!-- About Content Footer End -->
                </div>
            </div>
        </div>
    </div>
</div><!-- About Section End -->

<!-- Playlist Section Start -->
<div class="video-playlist">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title">
                    <a target="_blank" href="https://www.youtube.com/playlist?list=PLiRaSlMqdVLLcLrOuEJUDzYR5KrlLnQym"><h3 class="wow fadeInUp">Playlist</h3></a>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Apa Kata Mereka?</h2>
                </div>
                <!-- Section Title End -->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <!-- Project Single Content Start -->
                <div class="project-single-content">
                    <!-- Intro Video Box Start -->
                    <div class="intro-video-box mb-1" data-cursor-text="Play">
                        <!-- Video Image Start -->
                        <div class="video-image">
                            <a href="https://www.youtube.com/watch?v=WmGk59pTAis" class="popup-video">
                                <figure class="image-anime">
                                    <img src="https://img.youtube.com/vi/WmGk59pTAis/maxresdefault.jpg" alt="Bendungan dan Irigasi - 'Tulang Punggung Ketahanan Pangan Nasional'">
                                </figure>
                            </a>
                        </div>
                        <!-- Video Image End -->

                        <!-- Video Play Button Start -->
                        <div class="video-play-button">
                            <a href="https://www.youtube.com/watch?v=WmGk59pTAis" class="popup-video">
                                <i class="fa-solid fa-play"></i>
                            </a>
                        </div>
                        <!-- Video Play Button End -->
                    </div>
                    <!-- Intro Video Box End -->

                    <!-- Project Details Gallery Start -->
                    <div class="project-details-gallery">
                        <div class="row project-gallery-items">
                            <div class="col-lg-12">
                                <div class="project-gallery-title wow fadeInUp text-center" style="visibility: visible; animation-name: fadeInUp;">
                                    <h5 class="mt-3">Bendungan dan Irigasi - "Tulang Punggung Ketahanan Pangan Nasional"</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Project Details Gallery End -->
                </div>
                <!-- Project Single Content End -->
            </div>

            <div class="col-lg-6" style="height: 30rem; overflow-y: auto;">
                <!-- Project Sidebar Start -->
                <div class="project-sidebar">
                    <div class="project-info-box wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                        <!-- Portfolio Info Item Start -->
                        <div class="project-info-item">
                            <div class="icon-box">
                                <a href="https://www.youtube.com/watch?v=CdY1yfqwm5M" class="popup-video">
                                    <figure class="image-anime">
                                        <img style="max-width: 100px" src="https://img.youtube.com/vi/CdY1yfqwm5M/maxresdefault.jpg" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="project-info-content">
                                <h3 class="fs-6">Progres Pembangunan Bendungan Jragung</h3>
                                <span><i class="fab fa-youtube-square text-danger"></i> pu_sda</span>
                            </div>
                        </div>
                        <!-- Portfolio Info Item End -->

                        
                            <!-- Portfolio Info Item Start -->
                            <div class="project-info-item">
                                <div class="icon-box">
                                    <a href="https://www.youtube.com/watch?v=wW4Lb9SqzFw" class="popup-video">
                                        <figure class="image-anime">
                                            <img style="max-width: 100px" src="https://i.ytimg.com/vi/wW4Lb9SqzFw/sddefault.jpg" alt="Apa Kata Mereka? - P3-TGAI Jawa Timur">
                                        </figure>
                                    </a>
                                </div>
                                <div class="project-info-content">
                                    <h3 class="fs-6">Apa Kata Mereka? - P3-TGAI Jawa Timur</h3>
                                    <span><i class="fab fa-youtube-square text-danger"></i> pu_sda</span>
                                </div>
                            </div>
                            <!-- Portfolio Info Item End -->
                        
                            <!-- Portfolio Info Item Start -->
                            <div class="project-info-item">
                                <div class="icon-box">
                                    <a href="https://www.youtube.com/watch?v=e_kNeGa1hwg" class="popup-video">
                                        <figure class="image-anime">
                                            <img style="max-width: 100px" src="https://i.ytimg.com/vi/e_kNeGa1hwg/sddefault.jpg" alt="Apa Kata Mereka? - Daerah Irigasi Saddang">
                                        </figure>
                                    </a>
                                </div>
                                <div class="project-info-content">
                                    <h3 class="fs-6">Apa Kata Mereka? - Daerah Irigasi Saddang</h3>
                                    <span><i class="fab fa-youtube-square text-danger"></i> pu_sda</span>
                                </div>
                            </div>
                            <!-- Portfolio Info Item End -->
                        
                            <!-- Portfolio Info Item Start -->
                            <div class="project-info-item">
                                <div class="icon-box">
                                    <a href="https://www.youtube.com/watch?v=_9tLDGZmVVY" class="popup-video">
                                        <figure class="image-anime">
                                            <img style="max-width: 100px" src="https://i.ytimg.com/vi/_9tLDGZmVVY/sddefault.jpg" alt="Apa Kata Mereka? - Pengaman Pantai Pulau Sebetul">
                                        </figure>
                                    </a>
                                </div>
                                <div class="project-info-content">
                                    <h3 class="fs-6">Apa Kata Mereka? - Pengaman Pantai Pulau Sebetul</h3>
                                    <span><i class="fab fa-youtube-square text-danger"></i> pu_sda</span>
                                </div>
                            </div>
                            <!-- Portfolio Info Item End -->
                        
                            <!-- Portfolio Info Item Start -->
                            <div class="project-info-item">
                                <div class="icon-box">
                                    <a href="https://www.youtube.com/watch?v=f2sV0XvuZ0Q" class="popup-video">
                                        <figure class="image-anime">
                                            <img style="max-width: 100px" src="https://i.ytimg.com/vi/f2sV0XvuZ0Q/sddefault.jpg" alt="Apa Kata Mereka? - Pengaman Pantai Bali">
                                        </figure>
                                    </a>
                                </div>
                                <div class="project-info-content">
                                    <h3 class="fs-6">Apa Kata Mereka? - Pengaman Pantai Bali</h3>
                                    <span><i class="fab fa-youtube-square text-danger"></i> pu_sda</span>
                                </div>
                            </div>
                            <!-- Portfolio Info Item End -->
                        
                            <!-- Portfolio Info Item Start -->
                            <div class="project-info-item">
                                <div class="icon-box">
                                    <a href="https://www.youtube.com/watch?v=iqtCanNJRkE" class="popup-video">
                                        <figure class="image-anime">
                                            <img style="max-width: 100px" src="https://i.ytimg.com/vi/iqtCanNJRkE/sddefault.jpg" alt="Apa Kata Mereka? - Irigasi Subak Bali">
                                        </figure>
                                    </a>
                                </div>
                                <div class="project-info-content">
                                    <h3 class="fs-6">Apa Kata Mereka? - Irigasi Subak Bali</h3>
                                    <span><i class="fab fa-youtube-square text-danger"></i> pu_sda</span>
                                </div>
                            </div>
                            <!-- Portfolio Info Item End -->
                        
                            <!-- Portfolio Info Item Start -->
                            <div class="project-info-item">
                                <div class="icon-box">
                                    <a href="https://www.youtube.com/watch?v=3GPq4uF35fs" class="popup-video">
                                        <figure class="image-anime">
                                            <img style="max-width: 100px" src="https://i.ytimg.com/vi/3GPq4uF35fs/sddefault.jpg" alt="Apa Kata Mereka? - P3-TGAI Bali">
                                        </figure>
                                    </a>
                                </div>
                                <div class="project-info-content">
                                    <h3 class="fs-6">Apa Kata Mereka? - P3-TGAI Bali</h3>
                                    <span><i class="fab fa-youtube-square text-danger"></i> pu_sda</span>
                                </div>
                            </div>
                            <!-- Portfolio Info Item End -->
                        
                            <!-- Portfolio Info Item Start -->
                            <div class="project-info-item">
                                <div class="icon-box">
                                    <a href="https://www.youtube.com/watch?v=2rh2ja_U1cc" class="popup-video">
                                        <figure class="image-anime">
                                            <img style="max-width: 100px" src="https://i.ytimg.com/vi/2rh2ja_U1cc/sddefault.jpg" alt="Apa Kata Mereka? -  Daerah Irigasi Gempolsari">
                                        </figure>
                                    </a>
                                </div>
                                <div class="project-info-content">
                                    <h3 class="fs-6">Apa Kata Mereka? -  Daerah Irigasi Gempolsari</h3>
                                    <span><i class="fab fa-youtube-square text-danger"></i> pu_sda</span>
                                </div>
                            </div>
                            <!-- Portfolio Info Item End -->
                        
                            <!-- Portfolio Info Item Start -->
                            <div class="project-info-item">
                                <div class="icon-box">
                                    <a href="https://www.youtube.com/watch?v=E7rApg2499U" class="popup-video">
                                        <figure class="image-anime">
                                            <img style="max-width: 100px" src="https://i.ytimg.com/vi/E7rApg2499U/sddefault.jpg" alt="Apa Kata Mereka? - Revitalisasi Situ Bagendit">
                                        </figure>
                                    </a>
                                </div>
                                <div class="project-info-content">
                                    <h3 class="fs-6">Apa Kata Mereka? - Revitalisasi Situ Bagendit</h3>
                                    <span><i class="fab fa-youtube-square text-danger"></i> pu_sda</span>
                                </div>
                            </div>
                            <!-- Portfolio Info Item End -->
                        
                            <!-- Portfolio Info Item Start -->
                            <div class="project-info-item">
                                <div class="icon-box">
                                    <a href="https://www.youtube.com/watch?v=rjqRcMFNk_Y" class="popup-video">
                                        <figure class="image-anime">
                                            <img style="max-width: 100px" src="https://i.ytimg.com/vi/rjqRcMFNk_Y/sddefault.jpg" alt="Apa Kata Mereka? -  P3-TGAI Kalimantan Barat">
                                        </figure>
                                    </a>
                                </div>
                                <div class="project-info-content">
                                    <h3 class="fs-6">Apa Kata Mereka? -  P3-TGAI Kalimantan Barat</h3>
                                    <span><i class="fab fa-youtube-square text-danger"></i> pu_sda</span>
                                </div>
                            </div>
                            <!-- Portfolio Info Item End -->
                                            </div>
                </div>
                <!-- Project Sidebar End -->
            </div>
        </div>
    </div>
</div><!-- Playlist Section End -->

<!-- Berita Section Start -->
<div class="what-we-do" style="padding: 50px 0;">
    <div class="light-bg-section">
        <div class="container-fluid">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <a href="post"><h3 class="wow fadeInUp">Index Berita</h3></a>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Berita Terkini</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <!-- Testimonial Slider Start -->
                    <div class="testimonial-slider">
                        <div class="swiper">
                            <div class="swiper-wrapper" data-cursor-text="Drag">
                                <!-- Testimonial Slide Start -->
                                                                    <div class="swiper-slide">

                                        <!-- Blog Item Start -->
                                        <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                                            <!-- Post Featured Image Start-->
                                            <div class="post-featured-image" data-cursor-text="View">
                                                <figure>
                                                    <a href="https://sda.pu.go.id/balai/bbwscitanduy/berita/237/kepala-bbws-citanduy-terima-kunjungan-koordinasi-komisi-iii-dprd-kota-banjar" class="image-anime">
                                                        <img src="https://sda.pu.go.id/balai/bbwscitanduy/img/berita/R2puMH2RyBzBw5Swv4AogAJBNVQjHXHOC6PFeg1m.jpg" alt="Kepala BBWS Citanduy Terima Kunjungan Koordinasi Komisi III DPRD Kota Banjar">
<!--                                                        <img src="--><!--assets/uploads/posting/--><!--" alt="--><!--">-->
                                                        <p style="position: absolute; top: 16px; left: 16px; background-color: #334570; color:#F7F9FC; padding: 0px 15px 0px 14px; gap: 0px; border-radius: 40px;">Rabu, 04 Februari 2026 </p>
                                                    </a>
                                                </figure>
                                            </div>
                                            <!-- Post Featured Image End -->

                                            <!-- post Item Content Start -->
                                            <div class="post-item-content">
                                                <!-- post Item Body Start -->
                                                <div class="post-item-body">
                                                    <h2><a href="https://sda.pu.go.id/balai/bbwscitanduy/berita/237/kepala-bbws-citanduy-terima-kunjungan-koordinasi-komisi-iii-dprd-kota-banjar">Kepala BBWS Citanduy Terima Kunjungan Koordinasi Komisi III DPRD Kota Banjar</a></h2>
                                                </div>
                                                <!-- Post Item Body End-->

                                                <!-- Post Item Footer Start-->
                                                <div class="post-item-footer text-end">
                                                    <a href="https://sda.pu.go.id/balai/bbwscitanduy/berita/237/kepala-bbws-citanduy-terima-kunjungan-koordinasi-komisi-iii-dprd-kota-banjar" class="readmore-btn">Selengkapnya</a>
                                                </div>
                                                <!-- Post Item Footer End-->
                                            </div>
                                            <!-- post Item Content End -->
                                        </div>
                                        <!-- Blog Item End -->
                                    </div>
                                    <!-- Testimonial Slide End -->
                                                                    <div class="swiper-slide">

                                        <!-- Blog Item Start -->
                                        <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                                            <!-- Post Featured Image Start-->
                                            <div class="post-featured-image" data-cursor-text="View">
                                                <figure>
                                                    <a href="https://sda.pu.go.id/balai/bbwsc3/post/detail/bbws_c3_perkuat_kolaborasi_dengan_pemkab_tangerang_dalam_penanganan_banjir_sungai_cidurian" class="image-anime">
                                                        <img src="https://sda.pu.go.id/balai/bbwsc3/assets/uploads/posting/bbws_c3_perkuat_kolaborasi_dengan_pemkab_tangerang_dalam_penanganan_banjir_sungai_cidurian_1770175010_c7a2796133c5916683d3.png" alt="BBWS C3 Perkuat Kolaborasi dengan Pemkab Tangerang dalam Penanganan Banjir Sungai Cidurian">
<!--                                                        <img src="--><!--assets/uploads/posting/--><!--" alt="--><!--">-->
                                                        <p style="position: absolute; top: 16px; left: 16px; background-color: #334570; color:#F7F9FC; padding: 0px 15px 0px 14px; gap: 0px; border-radius: 40px;">Rabu, 04 Februari 2026 </p>
                                                    </a>
                                                </figure>
                                            </div>
                                            <!-- Post Featured Image End -->

                                            <!-- post Item Content Start -->
                                            <div class="post-item-content">
                                                <!-- post Item Body Start -->
                                                <div class="post-item-body">
                                                    <h2><a href="https://sda.pu.go.id/balai/bbwsc3/post/detail/bbws_c3_perkuat_kolaborasi_dengan_pemkab_tangerang_dalam_penanganan_banjir_sungai_cidurian">BBWS C3 Perkuat Kolaborasi dengan Pemkab Tangerang dalam Penanganan Banjir Sungai Cidurian</a></h2>
                                                </div>
                                                <!-- Post Item Body End-->

                                                <!-- Post Item Footer Start-->
                                                <div class="post-item-footer text-end">
                                                    <a href="https://sda.pu.go.id/balai/bbwsc3/post/detail/bbws_c3_perkuat_kolaborasi_dengan_pemkab_tangerang_dalam_penanganan_banjir_sungai_cidurian" class="readmore-btn">Selengkapnya</a>
                                                </div>
                                                <!-- Post Item Footer End-->
                                            </div>
                                            <!-- post Item Content End -->
                                        </div>
                                        <!-- Blog Item End -->
                                    </div>
                                    <!-- Testimonial Slide End -->
                                                                    <div class="swiper-slide">

                                        <!-- Blog Item Start -->
                                        <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                                            <!-- Post Featured Image Start-->
                                            <div class="post-featured-image" data-cursor-text="View">
                                                <figure>
                                                    <a href="https://sda.pu.go.id/balai/bbwspemalijuana/pages/posts/rehabilitasi-jaringan-irigasi-di-gung-menyambung-saluran-menguatkan-produktivitas" class="image-anime">
                                                        <img src="https://sda.pu.go.id/balai/bbwspemalijuana/files/berita/IMG_0869.jpg" alt="Rehabilitasi Jaringan Irigasi D.I Gung : Menyambung Saluran Menguatkan Produktivitas">
<!--                                                        <img src="--><!--assets/uploads/posting/--><!--" alt="--><!--">-->
                                                        <p style="position: absolute; top: 16px; left: 16px; background-color: #334570; color:#F7F9FC; padding: 0px 15px 0px 14px; gap: 0px; border-radius: 40px;">Rabu, 04 Februari 2026 </p>
                                                    </a>
                                                </figure>
                                            </div>
                                            <!-- Post Featured Image End -->

                                            <!-- post Item Content Start -->
                                            <div class="post-item-content">
                                                <!-- post Item Body Start -->
                                                <div class="post-item-body">
                                                    <h2><a href="https://sda.pu.go.id/balai/bbwspemalijuana/pages/posts/rehabilitasi-jaringan-irigasi-di-gung-menyambung-saluran-menguatkan-produktivitas">Rehabilitasi Jaringan Irigasi D.I Gung : Menyambung Saluran Menguatkan Produktivitas</a></h2>
                                                </div>
                                                <!-- Post Item Body End-->

                                                <!-- Post Item Footer Start-->
                                                <div class="post-item-footer text-end">
                                                    <a href="https://sda.pu.go.id/balai/bbwspemalijuana/pages/posts/rehabilitasi-jaringan-irigasi-di-gung-menyambung-saluran-menguatkan-produktivitas" class="readmore-btn">Selengkapnya</a>
                                                </div>
                                                <!-- Post Item Footer End-->
                                            </div>
                                            <!-- post Item Content End -->
                                        </div>
                                        <!-- Blog Item End -->
                                    </div>
                                    <!-- Testimonial Slide End -->
                                                                    <div class="swiper-slide">

                                        <!-- Blog Item Start -->
                                        <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                                            <!-- Post Featured Image Start-->
                                            <div class="post-featured-image" data-cursor-text="View">
                                                <figure>
                                                    <a href="https://sda.pu.go.id/balai/bbwsc3/post/detail/bbws_c3_lakukan_penanganan_banjir_di_sungai_cidurian_untuk_pulihkan_aksesibilitas_masyarakat" class="image-anime">
                                                        <img src="https://sda.pu.go.id/balai/bbwsc3/assets/uploads/posting/bbws_c3_lakukan_penanganan_banjir_di_sungai_cidurian_untuk_pulihkan_aksesibilitas_masyarakat_1770086421_9702d2380dbbf8660038.jpg" alt="BBWS C3 Lakukan Penanganan Banjir di Sungai Cidurian untuk Pulihkan Aksesibilitas Masyarakat">
<!--                                                        <img src="--><!--assets/uploads/posting/--><!--" alt="--><!--">-->
                                                        <p style="position: absolute; top: 16px; left: 16px; background-color: #334570; color:#F7F9FC; padding: 0px 15px 0px 14px; gap: 0px; border-radius: 40px;">Selasa, 03 Februari 2026 </p>
                                                    </a>
                                                </figure>
                                            </div>
                                            <!-- Post Featured Image End -->

                                            <!-- post Item Content Start -->
                                            <div class="post-item-content">
                                                <!-- post Item Body Start -->
                                                <div class="post-item-body">
                                                    <h2><a href="https://sda.pu.go.id/balai/bbwsc3/post/detail/bbws_c3_lakukan_penanganan_banjir_di_sungai_cidurian_untuk_pulihkan_aksesibilitas_masyarakat">BBWS C3 Lakukan Penanganan Banjir di Sungai Cidurian untuk Pulihkan Aksesibilitas Masyarakat</a></h2>
                                                </div>
                                                <!-- Post Item Body End-->

                                                <!-- Post Item Footer Start-->
                                                <div class="post-item-footer text-end">
                                                    <a href="https://sda.pu.go.id/balai/bbwsc3/post/detail/bbws_c3_lakukan_penanganan_banjir_di_sungai_cidurian_untuk_pulihkan_aksesibilitas_masyarakat" class="readmore-btn">Selengkapnya</a>
                                                </div>
                                                <!-- Post Item Footer End-->
                                            </div>
                                            <!-- post Item Content End -->
                                        </div>
                                        <!-- Blog Item End -->
                                    </div>
                                    <!-- Testimonial Slide End -->
                                                                    <div class="swiper-slide">

                                        <!-- Blog Item Start -->
                                        <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                                            <!-- Post Featured Image Start-->
                                            <div class="post-featured-image" data-cursor-text="View">
                                                <figure>
                                                    <a href="https://sda.pu.go.id/balai/bbwscitanduy/berita/236/dari-atas-tampak-tertata-di-bwah-memberi-manfaat-nyata" class="image-anime">
                                                        <img src="https://sda.pu.go.id/balai/bbwscitanduy/img/berita/D7DAtjgXSaJXaBpFL29KifJS8n1aeKuT9WcIOta1.jpg" alt="Dari Atas Tampak Tertata di Bwah Memberi Manfaat Nyata">
<!--                                                        <img src="--><!--assets/uploads/posting/--><!--" alt="--><!--">-->
                                                        <p style="position: absolute; top: 16px; left: 16px; background-color: #334570; color:#F7F9FC; padding: 0px 15px 0px 14px; gap: 0px; border-radius: 40px;">Senin, 02 Februari 2026 </p>
                                                    </a>
                                                </figure>
                                            </div>
                                            <!-- Post Featured Image End -->

                                            <!-- post Item Content Start -->
                                            <div class="post-item-content">
                                                <!-- post Item Body Start -->
                                                <div class="post-item-body">
                                                    <h2><a href="https://sda.pu.go.id/balai/bbwscitanduy/berita/236/dari-atas-tampak-tertata-di-bwah-memberi-manfaat-nyata">Dari Atas Tampak Tertata di Bwah Memberi Manfaat Nyata</a></h2>
                                                </div>
                                                <!-- Post Item Body End-->

                                                <!-- Post Item Footer Start-->
                                                <div class="post-item-footer text-end">
                                                    <a href="https://sda.pu.go.id/balai/bbwscitanduy/berita/236/dari-atas-tampak-tertata-di-bwah-memberi-manfaat-nyata" class="readmore-btn">Selengkapnya</a>
                                                </div>
                                                <!-- Post Item Footer End-->
                                            </div>
                                            <!-- post Item Content End -->
                                        </div>
                                        <!-- Blog Item End -->
                                    </div>
                                    <!-- Testimonial Slide End -->
                                
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <!-- Testimonial Slider End -->
                </div>
            </div>
        </div>
    </div>
</div><!-- Berita Section End -->

<!-- Buletin Section Start -->
<div class="buletin">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title">
                    <a href="dokumen"><h3 class="wow fadeInUp">Publikasi</h3></a>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Buletin & Buku</h2>
                </div>
            </div>
        </div>

                <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6">
                <div class="bulletin-item wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bulletin-body mb-3" style="background:#0b1f4d;border-radius:30px;padding:24px;min-height:100%;color:#ffffff;">
                        <div class="bulletin-body-title">
                            <h3 style="color:#ffffff;">Menu Publikasi</h3>
                        </div>
                        <div class="bulletin-content">
                            <p style="color:#dbe7ff;">Pilih kategori publikasi:</p>
                            <ul style="margin:0;padding-left:18px;line-height:1.9;color:#ffffff;">
                                <li><a class="publication-menu-link" href="post">Berita</a></li>
                                <li><a class="publication-menu-link" href="galeri">Galeri</a></li>
                                <li><a class="publication-menu-link" href="dokumen/kategori/booklet">Buletin</a></li>
                                <li><a class="publication-menu-link" href="dokumen">Dokumen</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="bulletin-item wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bulletin-image" data-cursor-text="View">
			<a href="https://sda.pu.go.id/dokumen/view/swasembada-pangan-bukan-sekadar-angan#book/">
                        <!--<a href="https://sda.pu.go.id/dokumen/view/edisi-03-2024---pengelolaan-sumber-daya-air-di-kepulauan#book/">-->
                            <figure>
				<img src="https://sda.pu.go.id/web/images/swasembadapangan.webp" alt="">
                                <!--<img src="https://sda.pu.go.id/web/images/edisi3.webp" alt="">-->
                            </figure>
                        </a>
                    </div>

                    <div class="bulletin-body mb-3">
                        <div class="bulletin-body-title">
                            <h3>Ebook Swasembada Pangan</h3>
                        </div>

                        <div class="bulletin-content">
                            <p>Tahun 2025</p>
                            <div class="bulletin-content-footer">
                                <a href="https://sda.pu.go.id/dokumen/view/swasembada-pangan-bukan-sekadar-angan#book/" class="readmore-btn">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="bulletin-item wow fadeInUp" data-wow-delay="0.25s">
                    <div class="bulletin-image" data-cursor-text="View">
                        <a href="https://sda.pu.go.id/dokumen/view/ipha-air-minimalis-manfaat-maksimalis#book/">
                            <figure>
                                <img src="https://sda.pu.go.id/web/images/ipha.png" alt="">
                            </figure>
                        </a>
                    </div>

                    <div class="bulletin-body mb-3">
                        <div class="bulletin-body-title">
                            <h3>IPHA : Air Minimalis, Hasil Maksimalis</h3>
                        </div>

                        <div class="bulletin-content">
                            <p>Tahun Panduan Praktis Irigasi Padi Hebat</p>
                            <div class="bulletin-content-footer">
                                <a href="https://sda.pu.go.id/dokumen/view/ipha-air-minimalis-manfaat-maksimalis#book/" class="readmore-btn">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-6">
                <div class="bulletin-item wow fadeInUp" data-wow-delay="0.5s">
                    <div class="bulletin-image" data-cursor-text="View">
                        <a href="https://sda.pu.go.id/dokumen/view/edisi-03-2024---pengelolaan-sumber-daya-air-di-kepulauan#book/">
                            <figure>
                                <img src="https://sda.pu.go.id/web/images/edisi3.webp" alt="">
                            </figure>
                        </a>
                    </div>

                    <div class="bulletin-body mb-3">
                        <div class="bulletin-body-title">
                            <h3>Buletin SDA Edisi 3</h3>
                        </div>

                        <div class="bulletin-content">
                            <p>Tahun 2024
                            </p>
                            <div class="bulletin-content-footer">
                                <a href="https://sda.pu.go.id/dokumen/view/edisi-03-2024---pengelolaan-sumber-daya-air-di-kepulauan#book/" class="readmore-btn">Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div><!-- Buletin Section End -->

<!-- Jurnal Section Start -->
<div class="our-faqs">
    <div class="light-bg-section">
        <div class="container">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">Wadah Informasi</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">Jurnal SDA</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <!-- Project Item Start -->
                    <div class="project-item wow fadeInUp" data-wow-delay="0.25s">
                        <!-- Project Image Start -->
                        <div class="project-image" data-cursor-text="View">
                            <a href="https://jurnalsda.pusair-pu.go.id/index.php/JSDA">
                                <figure>
                                    <img src="https://sda.pu.go.id/web/images/jurnal-sda.webp" alt="Jurnal Sumber Daya Air">
                                </figure>
                            </a>
                        </div>
                        <!-- Project Image End -->

                        <!-- Project Body Start -->
                        <div class="project-body mb-3">
                            <!-- Project Body Title Start -->
                            <div class="project-body-title">
                                <h3>Jurnal Sumber Daya Air</h3>
                            </div>
                            <!-- Project Body Title End -->

                            <!-- Project Content Start -->
                            <div class="project-content">
                                <div class="project-content-footer">
                                    <a href="https://jurnalsda.pusair-pu.go.id/index.php/JSDA" class="readmore-btn">Selengkapnya</a>
                                </div>
                            </div>
                            <!-- Project Content End -->
                        </div>
                        <!-- Project Body End -->
                    </div>
                    <!-- Project Item End -->
                </div>

                <div class="col-lg-4 col-md-4">
                    <!-- Project Item Start -->
                    <div class="project-item wow fadeInUp" data-wow-delay="0.5s">
                        <!-- Project Image Start -->
                        <div class="project-image" data-cursor-text="View">
                            <a href="https://jurnalth.pusair-pu.go.id/">
                                <figure>
                                    <img src="https://sda.pu.go.id/web/images/jurnal-hidraulik.webp" alt="Jurnal Teknik Hidraulik">
                                </figure>
                            </a>
                        </div>

                        <!-- Project Image End -->

                        <!-- Project Body Start -->
                        <div class="project-body mb-3">
                            <!-- Project Body Title Start -->
                            <div class="project-body-title">
                                <h3>Jurnal Hidraulik</h3>
                            </div>
                            <!-- Project Body Title End -->

                            <!-- Project Content Start -->
                            <div class="project-content">
                                <div class="project-content-footer">
                                    <a href="https://jurnalth.pusair-pu.go.id/" class="readmore-btn">Selengkapnya</a>
                                </div>
                            </div>
                            <!-- Project Content End -->
                        </div>
                        <!-- Project Body End -->
                    </div>
                    <!-- Project Item End -->
                </div>

                <div class="col-lg-4 col-md-4">
                    <!-- Project Item Start -->
                    <div class="project-item wow fadeInUp" data-wow-delay="0.75s">
                        <!-- Project Image Start -->
                        <div class="project-image" data-cursor-text="View">
                            <a href="#">
                                <figure>
                                    <img src="https://sda.pu.go.id/web/images/jurnal-irigasi.webp" alt="Jurnal Irigasi">
                                </figure>
                            </a>
                        </div>
                        <!-- Project Image End -->

                        <!-- Project Body Start -->
                        <div class="project-body mb-3">
                            <!-- Project Body Title Start -->
                            <div class="project-body-title">
                                <h3>Jurnal Irigasi</h3>
                            </div>
                            <!-- Project Body Title End -->

                            <!-- Project Content Start -->
                            <div class="project-content">
                                <div class="project-content-footer">
                                    <a href="#" class="readmore-btn">Selengkapnya</a>
                                </div>
                            </div>
                            <!-- Project Content End -->
                        </div>
                        <!-- Project Body End -->
                    </div>
                    <!-- Project Item End -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Jurnal Section End -->

<!-- Why Choose Us Section Start -->
<div class="akun">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title">
                    <h3 class="wow fadeInUp">Akun Resmi</h3>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Media Sosial</h2>
                </div>
                <!-- Section Title End -->
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                <div class="iframely-embed"><div class="iframely-responsive" style="height: 140px; padding-bottom: 0;"><a href="https://www.youtube.com/channel/UCSIbT953e30J_K0fKT8nPgA" data-iframely-url="//iframely.net/BOkn3PiP?theme=dark"></a></div></div><script async src="//iframely.net/embed.js"></script>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                <!-- Project Item Start -->
                <div class="project-item wow fadeInUp" data-wow-delay="0.5s">
                    <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/pu_sda_balaiairtanah/?utm_source=ig_embed&utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:658px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                        <div style="padding:16px;"><a href="https://www.instagram.com/pu_sda_balaiairtanah/?utm_source=ig_embed&utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">
                                <div style=" display: flex; flex-direction: row; align-items: center;">
                                    <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>
                                    <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">
                                        <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>
                                        <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>
                                    </div>
                                </div>
                                <div style="padding: 19% 0;"></div>
                                <div style="display:block; height:50px; margin:0 auto 12px; width:50px;">
                                    <svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <g transform="translate(-511.000000, -20.000000)" fill="#000000">
                                                <g>
                                                    <path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div style="padding-top: 8px;">
                                    <div style=" color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this profile on Instagram</div>
                                </div>
                                <div style="padding: 12.5% 0;"></div>
                                <div style="display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;">
                                    <div>
                                        <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);"></div>
                                        <div style="background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;"></div>
                                        <div style="background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);"></div>
                                    </div>
                                    <div style="margin-left: 8px;">
                                        <div style=" background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;"></div>
                                        <div style=" width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)"></div>
                                    </div>
                                    <div style="margin-left: auto;">
                                        <div style=" width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);"></div>
                                        <div style=" background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);"></div>
                                        <div style=" width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);"></div>
                                    </div>
                                </div>
                                <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;">
                                    <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;"></div>
                                    <div style=" background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;"></div>
                                </div>
                            </a>
                            <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/pu_sda_balaiairtanah/?utm_source=ig_embed&utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank">Ditjen Sumber Daya
                                    Air</a> (@<a href="https://www.instagram.com/pu_sda_balaiairtanah/?utm_source=ig_embed&utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank">pu_sda_balaiairtanah</a>) • Instagram photos and videos</p></div>
                    </blockquote>
                    <script async src="//platform.instagram.com/en_US/embeds.js"></script>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                <!-- Project Item Start -->
                <div class="project-item wow fadeInUp" data-wow-delay="1s">
                    <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@pu_sda" data-unique-id="pu_sda" data-embed-type="creator" style="max-width: 780px; min-width: 288px;margin-top: 0;">
                        <section><a target="_blank" href="https://www.tiktok.com/@pu_sda?refer=creator_embed">&#64;pu_sda</a></section>
                    </blockquote>
                    <script async src="https://www.tiktok.com/embed.js"></script>
                </div>
                <!-- Project Item End -->
            </div>
        </div>
    </div>
</div><!-- Why Choose Us Section End -->

<!-- Cta Box Section Start -->
<div class="" style="background: linear-gradient(180deg, #F7C95F 0%, #FDB235 100%);">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h3 class="mt-5 mb-3 text-center">Produk Hukum <br>Balai Air Tanah</h3>

                <div class="wow fadeInUp" data-wow-delay="0.75s" style="padding: 40px 40px 0;">
                    <a href="https://sda.pu.go.id/dokumen/kategori/produk_hukum">
                        <figure>
                            <img style="border-radius: 40px" src="https://sda.pu.go.id/web/images/ProdukHukum_.webp" alt="Produk Hukum">
                        </figure>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div><!-- Cta Box Section End -->

<!-- Pengumuman Section Start -->
<div class="what-we-do">
    <div class="light-bg-section">
        <div class="container">
            <div class="row section-row mb-0">
                <div class="col-lg-12">
                    <div class="section-title">
                        <a href="#"><h3 class="wow fadeInUp">
                                Pengumuman</h3>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row section-row mb-0 ">
                <div class="col-lg-12">
                    <div class="pengumuman-slider">
                        <div class="swiper">
                            <div class="swiper-wrapper" data-cursor-text="Drag">
<!--                                <div class="swiper-slide ">-->
<!--                                    <div class="link-item align-items-center justify-content-center align-content-center">-->
<!--                                        <a href="https://pmb.sttpu.civitas.id/" title="Penerimaan Mahasiswa Baru STT Pekerjaan Umum Jakarta" target="_blank">-->
<!--                                            <div class="link-body">-->
<!--                                                <figure class="image-anime">-->
<!--                                                    <img width="80%" src="https://sda.pu.go.id//assets/uploads/pages/1745910775_0b3ba24ebbacbbe52fe5.jpeg" alt="Penerimaan Mahasiswa Baru STT Pekerjaan Umum Jakarta">-->
<!--                                                </figure>-->
<!--                                                <video width="60%" controls>-->
<!--                                                    <source src="--><!--assets/uploads/pengumuman/VideoPromotionSTTPU.mp4" type="video/mp4">-->
<!--                                                    Your browser does not support HTML video.-->
<!--                                                </video>-->
<!--                                            </div>-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                </div>-->

                                <div class="swiper-slide ">
                                    <div class="link-item">
                                        <div class="link-body">
                                            <a href="https://www.instagram.com/p/DTZ8FAIkgDN/?igsh=MW42NGRnaDF5OGs2Ng==">
                                                <div class="row text-center align-content-center justify-content-center">
                                                    <div class="col-5 com-sm-12">
                                                        <figure class="image-anime">
                                                            <img width="100%" src="https://sda.pu.go.id/assets/uploads/pengumuman/Batas Akhir Permen PUPR No. 3 Tahun 2023 (Cover).webp" alt="Batas Akhir Permen PUPR No. 3 Tahun 2023">
                                                        </figure>
                                                    </div>
                                                    <div class="col-5 com-sm-12">
                                                        <figure class="image-anime">
                                                            <img width="100%" src="https://sda.pu.go.id/assets/uploads/pengumuman/Batas Akhir Permen PUPR No. 3 Tahun 2023 (01).webp" alt="Batas Akhir Permen PUPR No. 3 Tahun 2023">
                                                        </figure>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="swiper-slide ">
                                    <div class="link-item">
                                        <div class="link-body">
                                            <a href="https://sda.pu.go.id/pages/waspada-penipuan">
                                                <div class="row text-center align-content-center justify-content-center">
                                                    <div class="col-5 com-sm-12">
                                                        <figure class="image-anime">
                                                            <img width="100%" src="https://sda.pu.go.id/assets/uploads/pengumuman/Waspada Penipuan-01.jpg" alt="Waspada Penipuan-01">
                                                        </figure>
                                                    </div>
                                                    <div class="col-5 com-sm-12">
                                                        <figure class="image-anime">
                                                            <img width="100%" src="https://sda.pu.go.id/assets/uploads/pengumuman/Waspada Penipuan-02.jpg" alt="Waspada Penipuan-01">
                                                        </figure>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div><!-- Pengumuman Section End -->

<!-- Our Galeri Section Start -->
<div class="gallery-home">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title">
                    <h3 class="wow fadeInUp">Galeri</h3>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">Foto dan Video</h2>
                </div>
                <!-- Section Title End -->
            </div>
        </div>

        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.25s">
                <div class="col-md-12 mb-3">
                    <!-- Intro Video Box Start -->
                    <div class="intro-video-box" data-cursor-text="Play">
                        <!-- Video Image Start -->
                        <div class="video-image">
                            <a href="https://www.youtube.com/watch?v=CdY1yfqwm5M" class="popup-video">
                                <figure class="image-anime">
                                    <img src="https://sda.pu.go.id/web/images/thumbnail-1.webp" alt="">
                                </figure>
                            </a>
                        </div>
                        <!-- Video Image End -->

                        <!-- Video Play Button Start -->
                        <div class="video-play-button">
                            <a href="https://www.youtube.com/watch?v=CdY1yfqwm5M" class="popup-video">
                                <i class="fa-solid fa-play"></i>
                            </a>
                        </div>
                        <!-- Video Play Button End -->
                    </div>
                    <!-- Intro Video Box End -->
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <a href="https://sda.pu.go.id/galeri/detail/bendungan-dan-danau">
                    <div class="why-choose-image">
                        <figure class="image-anime reveal">
                            <img src="https://sda.pu.go.id/web/images/P4.jpg" alt="Bendungan dan Danau">
                        </figure>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <a href="https://sda.pu.go.id/galeri/detail/air-tanah-air-baku">
                    <div class="why-choose-image">
                        <figure class="image-anime reveal">
                            <img src="https://sda.pu.go.id/web/images/P1.jpg" alt="Air Tanah Air Baku">
                        </figure>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <!-- Why Choose Image Start -->
                <a href="https://sda.pu.go.id/galeri/detail/irigasi-dan-rawa">
                    <div class="why-choose-image">
                        <figure class="image-anime reveal">
                            <img src="https://sda.pu.go.id/web/images/P3.jpg" alt="Irigasi dan Rawa">
                        </figure>
                    </div>
                </a>
                <!-- Why Choose Image End -->
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <a href="https://sda.pu.go.id/galeri/detail/sungai-dan-pantai">
                    <div class="why-choose-image">
                        <figure class="image-anime reveal">
                            <img src="https://sda.pu.go.id/web/images/P2.jpg" alt="Sungai dan Pantai">
                        </figure>
                    </div>
                </a>
            </div>

            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.25s">
                <div class="col-md-12">
                    <div class="intro-video-box" data-cursor-text="Play">
                        <div class="video-image">
                            <a href="https://www.youtube.com/watch?v=ZXjwL82IQAg" class="popup-video">
                                <figure class="image-anime">
                                    <img src="https://sda.pu.go.id/web/images/thumbnail-2.webp" alt="">
                                </figure>
                            </a>
                        </div>

                        <div class="video-play-button">
                            <a href="https://www.youtube.com/watch?v=ZXjwL82IQAg" class="popup-video">
                                <i class="fa-solid fa-play"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<!-- Our Galeri Section End -->

<!-- Link Terkait Section Start-->
<div class="container">
    <div class="row section-row">
        <div class="col-lg-12">
            <div class="link-slider">
                <div class="swiper">
                    <div class="swiper-wrapper" data-cursor-text="Drag">

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="http://himpsda.dev-tunnels.id" title="HIMPESDA">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="https://sda.pu.go.id/web/images/link/Logo HIMPESDA High Res1.png" alt="HIMPESDA">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>
                        
                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="https://www.lapor.go.id/" title="Saran dan Pengaduan">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="https://sda.pu.go.id/web/images/link/icons-saran.svg" alt="Saran dan Pengaduan">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="https://sahabat.pu.go.id/" title="Pelayanan Publik">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="https://sda.pu.go.id/web/images/link/icons-layanan.svg" alt="Pelayanan Publik">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="https://sahabat.pu.go.id/eppid/" title="Layanan Informasi Publik (e-PPID)">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="https://sda.pu.go.id/web/images/link/icons-eppid.svg" alt="Layanan Informasi Publik (e-PPID)">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="https://saberpungli.id/" title="Saber Pungli">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="https://sda.pu.go.id/web/images/link/20201015042055icons-pungli.svg" alt="Saber Pungli">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="https://pdsda.sda.pu.go.id/" title="Pusat Data Sumber Daya Air">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="https://sda.pu.go.id/web/images/link/icons-wrdc.svg" alt="Pusat Data Sumber Daya Air">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="https://sihka.sda.pu.go.id/" title="Sistem Informasi Hidrologi dan Kualitas Air">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="https://sda.pu.go.id/web/images/link/icons-sihka.svg" alt="Sistem Informasi Hidrologi dan Kualitas Air">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="https://perizinansda.pu.go.id/" title="Perizinan SDA">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="https://sda.pu.go.id/web/images/link/icons-perizinan.svg" alt="Perizinan SDA">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="https://jdih.pu.go.id/" title="Jaringan Dokumentasi dan Informasi Hukum Kementerian PU">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="https://sda.pu.go.id/web/images/link/jdih.png" alt="Jaringan Dokumentasi dan Informasi Hukum Kementerian PU">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="https://elhkpn.kpk.go.id/" title="e-LKHPN">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="https://sda.pu.go.id/web/images/link/icons-elhkpn.svg" alt="e-LKHPN">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Link Terkait Section End-->

<style>
    #popup {
        display: none; /* Awalnya disembunyikan */
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5); /* Latar transparan */
    }

    #popup-content {
        /*background: white;*/
        padding: 10px;
        width: 450px;
        margin: 100px auto;
        border-radius: 8px;
        text-align: center;
    }

</style>
<!--start: floating ads-->
<div id="popup">
    <div id="popup-content">
        <div class="text-end"><a id='close-floatads' onclick='document.getElementById(&apos;popup&apos;).style.display = &apos;none&apos;;' style=' cursor:pointer;'>
                <i class="fa fa-2x fa-window-close"></i></a>
        </div>
        <!--Script iklan-->
        <a href='#' title='Integritas Hentikan Gratifikasi'>
            <img style='max-width:400px;height:auto; left:0;' alt='Integritas Hentikan Gratifikasi' src='https://sda.pu.go.id/assets/uploads/pengumuman/Poster Stop Gratifikasi Ilustratif Merah dan Kuning.jpg'/>
        </a>
        <!--Akhir script iklan-->
    </div>
</div><!--end: floating ads-->

<script>
    window.onload = function() {
        // Tampilkan pop-up setelah 3 detik
        setTimeout(function() {
            document.getElementById("popup").style.display = "block";

            // Sembunyikan pop-up setelah 5 detik tampil
            setTimeout(function() {
                document.getElementById("popup").style.display = "none";
            }, 8000); // 5000 ms = 5 detik tampil
        }, 0000);
    };
</script>

<!-- Footer Start -->
<footer class="main-footer">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="footer-logo">
                    <figure>
                        <img src="https://sda.pu.go.id/web/images/logopu-white.png" alt="Balai Air Tanah">
                    </figure>
                    <h3 class="text-uppercase mt-2 text-white ">Balai Air Tanah</h3>
                </div>
                <div class="footer-info-box">
                    <p>Gedung Ditjen Sumber Daya Air - Kementerian Pekerjaan Umum<br>
                        JL. Pattimura 20, Kebayoran Baru, Jakarta - Indonesia - 12110</p>
                </div>
                <div class="row justify-content-center mt-3" >
                    <div class="col-lg-6 col-md-6 col-12 pt-lg-3" style="background: rgba(255, 255, 255, 0.08);border-radius: 40px;" >
                        <div class="row text-white">
                            <div class="col-lg-6 text-md-end text-sm-center"><p><img height="20px" src="https://sda.pu.go.id/web/images/icon-phone.svg" alt="Call Center"> Call Center: (021) 158</p></div>
                            <div class="col-lg-6 text-md-start text-sm-center"><p><img height="20px" src="https://sda.pu.go.id/web/images/icon-mail.svg" alt="Email SDA"> infosda@pu.go.id</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-copyright">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <!-- BEGIN: Powered by Supercounters.com -->
                    <center>
                        <script type="text/javascript" src="//widget.supercounters.com/ssl/flag.js"></script>
                        <script type="text/javascript">sc_flag(1723216, "FFFFFF", "000000", "cccccc", 2, 2, 0, 0)</script>
                        <br>
                        <noscript><a href="http://www.supercounters.com/">Flag Counter</a></noscript>
                    </center>
                    <!-- END: Powered by Supercounters.com -->
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="footer-copyright-text">
                        <p>Copyright © 2025 Balai Air Tanah. All Rights Reserved.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-5">
                    <div class="footer-social-links">
                        <ul>
                            <li><a href="https://www.instagram.com/pu_sda_balaiairtanah/" aria-label="instagram"><i class="fa-brands fa-instagram"></i></a></li>
                            <li><a href="https://x.com/pupr_sda" aria-label="twitter"><i class="fa-brands fa-x-twitter"></i></a></li>
                            <li><a href="https://www.youtube.com/@pu_sda" aria-label="youtube"><i class="fa-brands fa-youtube"></i></a></li>
                            <li><a href="https://www.tiktok.com/@pu_sda" aria-label="tiktok"><i class="fa-brands fa-tiktok"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer><!-- Footer End -->

<!-- Jquery Library File -->
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


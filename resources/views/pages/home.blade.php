@extends('master.app')

@php
    $nilaiSkm = '98,10%'; // Nilai dummy untuk SKM
@endphp

@section('title', 'Beranda - Balai Air Tanah')

@php
    $heroContent = $heroThumbnails->first();
    $heroTitle = $heroContent?->title ?: 'BALAI AIR TANAH';
    $heroDescription = $heroContent?->description ?: 'Mengelola air tanah secara berkelanjutan untuk mendukung ketahanan air dan kesejahteraan masyarakat.';
    $heroPreloadImage = $heroContent?->image_url ?: asset('assets/sda/assets/uploads/pengumuman/imlek-02.webp');
@endphp

@push('head')
    <link rel="preload" href="{{ $heroPreloadImage }}" as="image" fetchpriority="high">
@endpush

@push('styles')
    <style>
        .social-profile-logo {
            color: #ffffff;
            font-size: 34px;
            border-color: rgba(255, 255, 255, 0.32);
        }

        .social-profile-card {
            grid-template-columns: 86px minmax(0, 1fr);
        }

        .social-profile-logo i {
            line-height: 1;
        }

        .facebook-card .social-profile-logo {
            background: #1877f2;
        }

        .x-card .social-profile-logo {
            background: #000000;
        }

        .threads-card .social-profile-logo {
            background: #101010;
        }

        .social-profile-desc {
            display: none;
        }

        .sp4n-lapor-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 170px;
            margin: 0;
        }

        .sp4n-lapor-logo img {
            width: min(175px, 100%);
            height: auto;
            object-fit: contain;
        }

        /* ── Gallery Showcase ── */
        .gallery-showcase {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            grid-auto-rows: clamp(190px, 21vw, 300px);
            gap: clamp(10px, 1.2vw, 14px);
            max-width: 1160px;
            margin: 0 auto;
        }

        .gallery-tile {
            position: relative;
            display: block;
            overflow: hidden;
            border-radius: 18px;
            color: inherit;
            text-decoration: none;
            background: #1a2744;
            box-shadow: 0 6px 24px rgba(9, 30, 66, 0.16);
            transition: transform 0.28s cubic-bezier(.22,.68,0,1.2), box-shadow 0.28s ease;
        }

        .gallery-tile:hover,
        .gallery-tile:focus-visible {
            color: inherit;
            text-decoration: none;
            transform: translateY(-6px) scale(1.015);
            box-shadow: 0 20px 56px rgba(9, 30, 66, 0.30);
            outline: 0;
        }

        /* videos span 2 of 3 columns */
        .gallery-tile-video {
            grid-column: span 2;
        }

        /* photos fill 1 column each */
        .gallery-tile-photo {
            /* height controlled by grid-auto-rows */
        }

        .gallery-tile figure {
            width: 100%;
            height: 100%;
            margin: 0;
            border-radius: inherit;
        }

        .gallery-tile img {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: inherit;
            object-fit: cover;
            transition: transform 0.52s cubic-bezier(.22,.68,0,1.2), filter 0.52s ease;
        }

        .gallery-tile:hover img,
        .gallery-tile:focus-visible img {
            transform: scale(1.09);
            filter: brightness(1.06) saturate(1.14);
        }

        /* ── gradient overlay ── */
        .gallery-tile-overlay {
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(
                to top,
                rgba(4, 18, 44, 0.82) 0%,
                rgba(4, 18, 44, 0.22) 48%,
                transparent 100%
            );
            pointer-events: none;
            transition: background 0.3s ease;
        }

        .gallery-tile:hover .gallery-tile-overlay {
            background: linear-gradient(
                to top,
                rgba(4, 18, 44, 0.90) 0%,
                rgba(4, 18, 44, 0.36) 58%,
                rgba(4, 18, 44, 0.08) 100%
            );
        }

        /* ── glass badge (top-right) ── */
        .gallery-tile-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 4;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.14);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.22);
            color: #fff;
            font-size: 0.58rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            pointer-events: none;
            transition: background 0.25s ease;
        }

        .gallery-tile:hover .gallery-tile-badge {
            background: rgba(255, 255, 255, 0.24);
        }

        /* ── label (bottom) ── */
        .gallery-tile-label {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 0.9rem 1rem;
            z-index: 3;
            pointer-events: none;
        }

        .gallery-tile-label .label-sub {
            display: block;
            font-size: 0.57rem;
            font-weight: 600;
            letter-spacing: 0.13em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.62);
            margin-bottom: 3px;
        }

        .gallery-tile-label h5 {
            margin: 0;
            font-size: clamp(0.78rem, 1vw, 0.97rem);
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #ffffff;
        }

        /* ── video play button ── */
        .gallery-tile .video-play-button {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
            pointer-events: none;
        }

        .gallery-tile .video-play-button > span {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: clamp(50px, 5.5vw, 72px);
            height: clamp(50px, 5.5vw, 72px);
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            color: var(--bat-accent, #f4b000);
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.28), 0 2px 8px rgba(0, 0, 0, 0.16);
            transition: transform 0.28s cubic-bezier(.22,.68,0,1.2), box-shadow 0.28s ease;
        }

        .gallery-tile:hover .video-play-button > span {
            transform: scale(1.16);
            box-shadow: 0 14px 44px rgba(0, 0, 0, 0.38), 0 4px 12px rgba(0, 0, 0, 0.22);
        }

        .gallery-tile .video-play-button > span::before {
            content: "";
            position: absolute;
            inset: -12px;
            border-radius: 50%;
            border: 3px solid rgba(255, 255, 255, 0.44);
            animation: border-zooming 1.6s infinite ease-out;
        }

        .gallery-tile .video-play-button i {
            position: relative;
            z-index: 1;
            margin-left: 3px;
        }

        /* ── CTA button ── */
        .gallery-cta {
            text-align: center;
            margin-top: 2.4rem;
        }

        .gallery-cta a {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            padding: 0.72rem 2rem;
            border-radius: 50px;
            background: var(--bat-accent, #f4b000);
            color: #1a1a1a;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            letter-spacing: 0.02em;
            box-shadow: 0 4px 20px rgba(244, 176, 0, 0.32);
            transition: transform 0.22s ease, box-shadow 0.22s ease, background 0.22s ease;
        }

        .gallery-cta a:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 32px rgba(244, 176, 0, 0.48);
            background: #ffc107;
            color: #1a1a1a;
            text-decoration: none;
        }

        /* ── placeholder tile (belum ada foto di DB) ── */
        .gallery-tile-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: linear-gradient(145deg, #071836 0%, #0d2d5e 60%, #153d7a 100%);
            border-radius: inherit;
        }

        .gallery-tile-placeholder::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: radial-gradient(circle at 70% 30%, rgba(255,255,255,0.07), transparent 65%);
            pointer-events: none;
        }

        .gallery-tile-placeholder .ph-sub {
            position: relative;
            z-index: 1;
            font-size: 0.58rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.5);
        }

        .gallery-tile-placeholder h5 {
            position: relative;
            z-index: 1;
            margin: 0;
            font-size: clamp(0.9rem, 1.4vw, 1.2rem);
            font-weight: 900;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #ffffff;
            text-align: center;
            line-height: 1.25;
            padding: 0 1rem;
        }

        @media (max-width: 767px) {
            .gallery-showcase {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                grid-auto-rows: clamp(160px, 28vw, 240px);
            }

            .gallery-tile-video {
                grid-column: span 2;
            }
        }

        @media (max-width: 479px) {
            .gallery-showcase {
                grid-template-columns: 1fr;
                grid-auto-rows: clamp(180px, 56vw, 260px);
            }

            .gallery-tile-video {
                grid-column: span 1;
            }
        }
    </style>
@endpush

@section('content')
<!-- Preloader Start -->
<!-- <div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="{{ asset('assets/sda/web/images/loader.svg') }}" alt=""></div>
		</div>
	</div>-->
<!-- Preloader End -->


<!-- Slider Section Start -->
<div class="hero bg-section hero-slider home-hero">
    <div class="hero-slider-layout">
        <div class="swiper">
            <div class="swiper-wrapper">
                @forelse ($heroThumbnails as $heroThumbnail)
                    @php
                        $heroImageUrl = $heroThumbnail->image_url;
                    @endphp
                    <div class="swiper-slide">
                        <div class="hero-slide">
                            <div class="hero-slider-image">
                                <picture>
                                    <source media="(max-width: 799px)" srcset="{{ $heroImageUrl }}"/>
                                    <source media="(min-width: 800px)" srcset="{{ $heroImageUrl }}"/>
                                    <img
                                        height="100%"
                                        src="{{ $heroImageUrl }}"
                                        alt="{{ $heroThumbnail->title ?: 'Hero Thumbnail ' . $heroThumbnail->id }}"
                                        decoding="async"
                                        loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                        fetchpriority="{{ $loop->first ? 'high' : 'low' }}"
                                    >
                                </picture>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="hero-slide">
                            <div class="hero-slider-image">
                                <picture>
                                    <source media="(max-width: 799px)" srcset="{{ asset('assets/sda/assets/uploads/pengumuman/imlek-02.webp') }}"/>
                                    <source media="(min-width: 800px)" srcset="{{ asset('assets/sda/assets/uploads/pengumuman/imlek-02.webp') }}"/>
                                    <img height="100%" src="{{ asset('assets/sda/assets/uploads/pengumuman/imlek-02.webp') }}" alt="Balai Air Tanah" decoding="async" loading="eager" fetchpriority="high">
                                </picture>
                            </div>

                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="hero-slide-content">
        <p class="hero-kicker">Selamat Datang</p>
        <h1 class="hero-title bat-text-anime" data-bat-anime="hero">{{ $heroTitle }}</h1>
        <p class="hero-description">{{ $heroDescription }}</p>
        <!-- <div class="hero-actions" aria-label="Navigasi cepat halaman utama">
            <a href="#tentang-kami" class="hero-btn hero-btn-primary">
                <span>Tentang Kami</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
            <a href="#publikasi" class="hero-btn hero-btn-outline">
                <span>Informasi Publik</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div> -->
    </div>
</div><!-- Slider Section End -->

<!-- About Section Start -->
<section class="about-us home-about" id="tentang-kami">
    <div class="container">
        <div class="home-about-grid">
            <div class="about-content">
                <p class="about-kicker">{{ $aboutProfilePage?->title ?? 'Tentang Kami' }}</p>
                <h2 class="about-name bat-text-anime" data-bat-anime="scroll">Balai Air Tanah</h2>
                <p class="about-desc">{{ $aboutDescription }}</p>

                <div class="about-actions">
                    <a href="{{ route('profil.index') }}" class="about-more-link">
                        <span>Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <figure class="about-image reveal">
                <img src="{{ asset('images/cp.png') }}" alt="Balai Air Tanah" decoding="async" loading="eager" fetchpriority="high">
            </figure>

            <aside class="about-service-panel" aria-labelledby="aboutServiceTitle">
                <h3 id="aboutServiceTitle">Akses Cepat</h3>
                <div class="about-service-grid" aria-label="Informasi unggulan Balai Air Tanah">
                    <a href="{{ route('peta') }}" class="about-service-card">
                        <span class="about-service-card-icon" aria-hidden="true">
                            <i class="fa-solid fa-headset" aria-hidden="true"></i>
                        </span>
                        <span class="about-service-card-copy">
                            <span class="about-service-card-title">Advis Teknis</span>
                            <span class="about-service-card-desc">Konsultasi dan Advis teknis bidang air tanah</span>
                        </span>
                        <i class="fa-solid fa-arrow-right about-service-card-arrow" aria-hidden="true"></i>
                    </a>

                    <a href="https://siatab.sda.pu.go.id/" target="_blank" rel="noopener noreferrer" class="about-service-card">
                        <span class="about-service-card-icon" aria-hidden="true">
                            <i class="fa-solid fa-database" aria-hidden="true"></i>
                        </span>
                        <span class="about-service-card-copy">
                            <span class="about-service-card-title">SIATAB</span>
                            <span class="about-service-card-desc">Sistem Informasi Air Tanah dan Air Baku</span>
                        </span>
                        <i class="fa-solid fa-arrow-right about-service-card-arrow" aria-hidden="true"></i>
                    </a>

                    <a href="https://siatab.sda.pu.go.id/" class="about-service-card">
                        <span class="about-service-card-icon" aria-hidden="true">
                            <i class="fa-regular fa-map" aria-hidden="true"></i>
                        </span>
                        <span class="about-service-card-copy">
                            <span class="about-service-card-title">GeMS</span>
                            <span class="about-service-card-desc">Groundwater Monitoring System</span>
                        </span>
                        <i class="fa-solid fa-arrow-right about-service-card-arrow" aria-hidden="true"></i>
                    </a>

                    <a href="http://168.110.204.252/" class="about-service-card">
                        <span class="about-service-card-icon" aria-hidden="true">
                            <i class="fa-solid fa-flask" aria-hidden="true"></i>
                        </span>
                        <span class="about-service-card-copy">
                            <span class="about-service-card-title">SILEBAT</span>
                            <span class="about-service-card-desc">Labora</span>
                        </span>
                        <i class="fa-solid fa-arrow-right about-service-card-arrow" aria-hidden="true"></i>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section><!-- About Section End -->

<!-- Publikasi Section Start -->
<div class="what-we-do home-publication-wrapper home-publication-spacing">
    <div class="light-bg-section home-publication-section home-publication-tabs js-publication-tabs" data-page-size="4">
        <div class="container-fluid">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <a href="post">
                            <h3 class="wow fadeInUp section-label-link">Publikasi</h3>
                        </a>
                        <h2 class="text-anime-style-3">Informasi dan Edukasi Air Tanah</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <nav class="publication-menu-box home-publication-menu" aria-label="Kategori publikasi landing page">
                <ul class="publication-menu-list">
                    <li>
                        <button type="button" class="publication-menu-link is-active js-publication-menu" data-target="home-berita">
                            <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
                            <span>Berita</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="publication-menu-link js-publication-menu" data-target="home-edukasi">
                            <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                            <span>Edukasi</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="publication-menu-link js-publication-menu" data-target="home-infografis">
                            <i class="fa-solid fa-chart-pie" aria-hidden="true"></i>
                            <span>Infografis</span>
                        </button>
                    </li>
                </ul>
            </nav>

            <div class="row publication-group is-active" data-publication-group="home-berita">
                @forelse ($publikasiBeritas as $berita)
                    @php
                        $firstImage = $berita->images->first();
                        $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : asset('assets/images/placeholders/berita.svg');
                        $beritaUrl = route('publikasi.berita.show', $berita);
                    @endphp
                    <div class="col-xl-3 col-lg-3 col-md-6 js-publication-item">
                        <article class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                            <a class="post-featured-image post-featured-link" href="{{ $beritaUrl }}">
                                <img src="{{ $imageUrl }}" alt="{{ $berita->judul }}" decoding="async" loading="lazy">
                                <p class="news-date-badge">
                                    {{ $berita->created_at ? $berita->created_at->locale('id')->translatedFormat('l, d F Y') : '-' }}
                                </p>
                            </a>
                            <div class="post-item-content">
                                <div class="post-item-body">
                                    <h2>{{ $berita->judul }}</h2>
                                </div>
                                <div class="post-item-footer text-end">
                                    <a href="{{ $beritaUrl }}" class="publication-detail-btn">Selengkapnya</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                            <div class="post-item-content">
                                <div class="post-item-body">
                                    <h2>Belum ada data berita.</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
                <div class="col-12"><div class="publication-dots js-publication-dots"></div></div>
            </div>

            <div class="row publication-group" data-publication-group="home-edukasi">
                @forelse($publikasiEdukasi as $item)
                    @php
                        $firstImage = $item->images->first();
                        $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : asset('assets/images/placeholders/publikasi.svg');
                    @endphp
                    <div class="col-xl-3 col-lg-3 col-md-6 js-publication-item">
                        <article class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                            <a class="post-featured-image post-featured-link" href="{{ route('publikasi.buletin.show', $item->slug) }}">
                                <img src="{{ $imageUrl }}" alt="{{ $item->judul }}" decoding="async" loading="lazy">
                                <p class="news-date-badge">
                                    {{ $item->published_at ? $item->published_at->locale('id')->translatedFormat('l, d F Y') : '-' }}
                                </p>
                            </a>
                            <div class="post-item-content">
                                <div class="post-item-body">
                                    <h2>{{ $item->judul }}</h2>
                                </div>
                                <div class="post-item-footer text-end">
                                    <a href="{{ route('publikasi.buletin.show', $item->slug) }}" class="publication-detail-btn">Selengkapnya</a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                            <div class="post-item-content">
                                <div class="post-item-body">
                                    <h2>Belum ada data edukasi.</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
                <div class="col-12"><div class="publication-dots js-publication-dots"></div></div>
            </div>

            <div class="row publication-group" data-publication-group="home-infografis">
                @forelse($publikasiInfografis as $item)
                    @php
                        $firstImage = $item->images->first();
                        $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : asset('assets/images/placeholders/publikasi.svg');
                        $imagePayload = $item->images
                            ->map(function ($image) {
                                return [
                                    'url' => asset('storage/' . $image->image_path),
                                ];
                            })
                            ->values()
                            ->toJson();
                    @endphp
                    <div class="col-xl-3 col-lg-3 col-md-6 js-publication-item">
                        <article class="blog-item publication-image-card wow fadeInUp" data-wow-delay="0.25s">
                            <button
                                type="button"
                                class="post-featured-image publication-image-btn js-publication-detail-btn"
                                data-judul="{{ $item->judul }}"
                                data-tanggal="{{ $item->created_at ? $item->created_at->locale('id')->translatedFormat('l, d F Y') : '-' }}"
                                data-deskripsi="{{ e($item->deskripsi) }}"
                                data-images="{{ e($imagePayload) }}"
                            >
                                <img src="{{ $imageUrl }}" alt="{{ $item->judul }}" decoding="async" loading="lazy">
                                <span class="news-date-badge">
                                    {{ $item->created_at ? $item->created_at->locale('id')->translatedFormat('l, d F Y') : '-' }}
                                </span>
                                <span class="publication-image-caption">
                                    <span class="publication-image-title">{{ $item->judul }}</span>
                                    <span class="publication-image-action">Selengkapnya</span>
                                </span>
                            </button>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                            <div class="post-item-content">
                                <div class="post-item-body">
                                    <h2>Belum ada data infografis.</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
                <div class="col-12"><div class="publication-dots js-publication-dots"></div></div>
            </div>
        </div>
    </div>
</div><!-- Publikasi Section End -->

<div class="publication-detail-overlay" id="publicationDetailOverlay" aria-hidden="true">
    <div class="publication-detail-card" role="dialog" aria-modal="true" aria-labelledby="publicationDetailTitle">
        <h2 class="publication-detail-title" id="publicationDetailTitle">Detail Publikasi</h2>
        <p class="publication-detail-date" id="publicationDetailDate">-</p>
        <div class="publication-detail-slider">
            <div class="publication-detail-track" id="publicationDetailTrack"></div>
        </div>
        <div class="publication-detail-dots" id="publicationDetailDots"></div>
        <p class="publication-detail-description" id="publicationDetailDescription"></p>
        <div class="text-end publication-detail-actions">
            <button type="button" class="publication-detail-btn" id="closePublicationDetail">Tutup</button>
        </div>
    </div>
</div>

<!-- Why Choose Us Section Start -->
<div class="akun">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row section-row">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title">
                    <h3 class="wow fadeInUp">Akun Resmi</h3>
                    <h2 class="text-anime-style-3">Media Sosial</h2>
                </div>
                <!-- Section Title End -->
            </div>
        </div>

        <div class="row justify-content-center g-4">
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="social-embed-card instagram-card instagram-widget wow fadeInUp" data-wow-delay="0.5s">
                    <div class="social-embed-frame">
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
                                    <div style=" color:#3897f0; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this profile on Instagram</div>
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
                            <p style=" color:#c9c8cd; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/pu_sda_balaiairtanah/?utm_source=ig_embed&utm_campaign=loading" style=" color:#c9c8cd; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank">Ditjen Sumber Daya
                                    Air</a> (@<a href="https://www.instagram.com/pu_sda_balaiairtanah/?utm_source=ig_embed&utm_campaign=loading" style=" color:#c9c8cd; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank">pu_sda_balaiairtanah</a>) - Instagram photos and videos</p></div>
                        </blockquote>
                    </div>
                    <script async src="//platform.instagram.com/en_US/embeds.js"></script>
                    <a class="social-embed-footer instagram-link" href="https://www.instagram.com/pu_sda_balaiairtanah/" target="_blank" rel="noopener noreferrer">
                        <span class="social-embed-kicker">Instagram</span>
                        <span class="social-embed-title">pu_sda_balaiairtanah</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="social-embed-card youtube-card wow fadeInUp" data-wow-delay="0.65s">
                    <div class="social-embed-frame">
                        <iframe
                            src="https://www.youtube.com/embed/videoseries?list=UULwA6GMkzfPwzCbDYIszIHA"
                            title="YouTube Balai Air Tanah"
                            loading="lazy"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen>
                        </iframe>
                    </div>
                    <a class="social-embed-footer" href="https://www.youtube.com/@pu_sda_balaiairtanah" target="_blank" rel="noopener noreferrer">
                        <span class="social-embed-kicker">YouTube</span>
                        <span class="social-embed-title">Balai Air Tanah</span>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="social-link-stack wow fadeInUp" data-wow-delay="0.8s" aria-label="Akun media sosial Balai Air Tanah">
                    <a class="social-profile-card facebook-card" href="https://www.facebook.com/pupr.sda.balaiairtanah" target="_blank" rel="noopener noreferrer">
                        <span class="social-profile-logo">
                            <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                        </span>
                        <span class="social-profile-copy">
                            <span class="social-profile-name">pupr.sda.balaiairtanah</span>
                            <span class="social-profile-url">facebook.com</span>
                        </span>
                    </a>

                    <a class="social-profile-card x-card" href="https://x.com/pu_sda_bat?s=20" target="_blank" rel="noopener noreferrer">
                        <span class="social-profile-logo">
                            <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                        </span>
                        <span class="social-profile-copy">
                            <span class="social-profile-name">pu_sda_bat</span>
                            <span class="social-profile-url">x.com</span>
                        </span>
                    </a>

                    <a class="social-profile-card threads-card" href="https://www.threads.com/@pu_sda_balaiairtanah" target="_blank" rel="noopener noreferrer">
                        <span class="social-profile-logo">
                            <i class="fa-brands fa-threads" aria-hidden="true"></i>
                        </span>
                        <span class="social-profile-copy">
                            <span class="social-profile-name">pu_sda_balaiairtanah</span>
                            <span class="social-profile-url">threads.com</span>
                        </span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div><!-- Why Choose Us Section End -->

<!-- Complaint Survey Section Start -->
<section class="complaint-survey-section">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h3 class="wow fadeInUp">Umpan Balik</h3>
                    <h2 class="text-anime-style-3">Layanan Pengaduan dan Survei Kepuasan Masyarakat</h2>
                </div>
            </div>
        </div>

        <div class="complaint-survey-grid">
            <article class="complaint-survey-panel wow fadeInUp" data-wow-delay="0.2s">
                <header class="complaint-survey-head">
                    <span class="complaint-survey-icon" aria-hidden="true">
                        <i class="fa-solid fa-headset"></i>
                    </span>
                    <div>
                        <p>Layanan Pengaduan</p>
                        <h3>Informasi dan Kanal Pengaduan</h3>
                    </div>
                </header>

                <div class="complaint-survey-items">
                    <div class="complaint-survey-metric">
                        <span class="complaint-survey-label">Jumlah Pengaduan</span>
                        <strong>{{ $jumlahPengaduan ? number_format($jumlahPengaduan) : '0' }}</strong>
                        <small>Data pengaduan terdata</small>
                    </div>
                    <a class="complaint-survey-link" href="https://www.lapor.go.id/" target="_blank" rel="noopener noreferrer">
                        <span>
                            <strong>SP4N LAPOR!</strong>
                            <small>Kanal resmi pengaduan pelayanan publik nasional</small>
                        </span>
                        <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                    </a>
                </div>
            </article>

            <article class="complaint-survey-panel complaint-survey-panel-skm wow fadeInUp" data-wow-delay="0.35s">
                <header class="complaint-survey-head">
                    <span class="complaint-survey-icon" aria-hidden="true">
                        <i class="fa-solid fa-chart-line"></i>
                    </span>
                    <div>
                        <p>Indeks Kepuasan Masyarakat</p>
                        <h3>Hasil Survei dan Laporan</h3>
                    </div>
                </header>

                <div class="complaint-survey-items">
                    <div class="complaint-survey-metric">
                        <span class="complaint-survey-label">Nilai IKM</span>
                        <strong>{{ $nilaiSkm ?? '0%' }}</strong>
                        <small>Persentase kepuasan masyarakat</small>
                    </div>
                    <a class="complaint-survey-link" href="{{ route('pelayanan_publik.laporan_skm') }}">
                        <span>
                            <strong>Laporan Kepuasan Masyarakat</strong>
                            <small>{{ number_format($jumlahLaporanSkm) }} dokumen laporan tersedia</small>
                        </span>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </article>
        </div>
    </div>
</section>
<!-- Complaint Survey Section End -->

<!-- Pengumuman Section Start -->
<!-- <div class="what-we-do">
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
                            <div class="swiper-wrapper">
                                @forelse ($pengumumans->chunk(2) as $pengumumanChunk)
                                    <div class="swiper-slide">
                                        <div class="link-item">
                                            <div class="link-body">
                                                <div class="row text-center align-content-center justify-content-center g-3">
                                                    @foreach ($pengumumanChunk as $pengumuman)
                                                        @php
                                                            $pengumumanImage = asset('storage/' . $pengumuman->image_path);
                                                        @endphp
                                                        <div class="col-6">
                                                            <a href="{{ $pengumumanImage }}" class="pengumuman-card" target="_blank" rel="noopener noreferrer">
                                                                <figure class="image-anime mb-0">
                                                                    <img src="{{ $pengumumanImage }}" alt="Pengumuman {{ $pengumuman->id }}" decoding="async" loading="lazy">
                                                                </figure>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                    @if ($pengumumanChunk->count() === 1)
                                                        <div class="col-6"></div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <div class="link-item">
                                            <div class="link-body">
                                                <div class="row text-center align-content-center justify-content-center">
                                                    <div class="col-lg-10 col-md-10 col-sm-12">
                                                        <figure class="image-anime">
                                                            <img width="100%" src="{{ asset('assets/images/placeholders/pengumuman.svg') }}" alt="Belum ada pengumuman" decoding="async" loading="lazy">
                                                        </figure>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse

                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div> -->
<!-- Pengumuman Section End -->

<!-- Our Galeri Section Start -->
<div class="gallery-home">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h3 class="wow fadeInUp">Galeri</h3>
                    <h2 class="text-anime-style-3">Foto dan Video</h2>
                </div>
            </div>
        </div>

        <div class="gallery-showcase wow fadeInUp" data-wow-delay="0.25s">

            {{-- Video 1 (large, spans 2 cols) --}}
            <a class="gallery-tile gallery-tile-video" href="{{ route('publikasi.galeri.video') }}">
                <figure class="image-anime">
                    <img src="{{ asset('assets/sda/web/images/thumbnail-1.webp') }}" alt="Video Sumber Daya Air" decoding="async" loading="lazy">
                </figure>
                <div class="gallery-tile-overlay"></div>
                <span class="gallery-tile-badge"><i class="fa-solid fa-play fa-xs"></i>&nbsp;Video</span>
                <div class="gallery-tile-label">
                    <span class="label-sub">Direktorat Jenderal</span>
                    <h5>Sumber Daya Air</h5>
                </div>
                <span class="video-play-button" aria-hidden="true">
                    <span><i class="fa-solid fa-play"></i></span>
                </span>
            </a>

            @foreach ([
                ['judul' => 'Geolistrik 1D',   'sub' => 'Pengukuran'],
                ['judul' => 'Geolistrik 2D',   'sub' => 'Pengukuran'],
                ['judul' => 'Pumping Test',    'sub' => 'Pengukuran'],
                ['judul' => 'Borehole Camera', 'sub' => 'Pengukuran'],
                ['judul' => 'Logger',          'sub' => 'Pengukuran'],
            ] as $tile)
                @php $g = $galeriTiles[strtolower($tile['judul'])] ?? null; @endphp
                <a class="gallery-tile gallery-tile-photo" href="{{ route('publikasi.galeri.foto') }}">
                    @if ($g && $g->hasImage())
                        <figure class="image-anime reveal"@if($g->background_color) style="background:{{ $g->background_color }}"@endif>
                            <img src="{{ $g->image_url }}" alt="{{ $tile['judul'] }}" decoding="async" loading="lazy">
                        </figure>
                        <div class="gallery-tile-overlay"></div>
                        <span class="gallery-tile-badge"><i class="fa-solid fa-camera fa-xs"></i>&nbsp;Foto</span>
                        <div class="gallery-tile-label">
                            <span class="label-sub">{{ $tile['sub'] }}</span>
                            <h5>{{ $tile['judul'] }}</h5>
                        </div>
                    @else
                        <div class="gallery-tile-placeholder"
                            @if($g && $g->background_color) style="background:{{ $g->background_color }}" @endif>
                            <span class="ph-sub">{{ $tile['sub'] }}</span>
                            <h5>{{ $tile['judul'] }}</h5>
                        </div>
                        <span class="gallery-tile-badge"><i class="fa-solid fa-camera fa-xs"></i>&nbsp;Foto</span>
                    @endif
                </a>
            @endforeach

            {{-- Video 2 (spans 2 of 3 cols) --}}
            <a class="gallery-tile gallery-tile-video" href="{{ route('publikasi.galeri.video') }}">
                <figure class="image-anime">
                    <img src="{{ asset('assets/sda/web/images/thumbnail-2.webp') }}" alt="Video Sumber Daya Air" decoding="async" loading="lazy">
                </figure>
                <div class="gallery-tile-overlay"></div>
                <span class="gallery-tile-badge"><i class="fa-solid fa-play fa-xs"></i>&nbsp;Video</span>
                <div class="gallery-tile-label">
                    <span class="label-sub">Direktorat Jenderal</span>
                    <h5>Sumber Daya Air</h5>
                </div>
                <span class="video-play-button" aria-hidden="true">
                    <span><i class="fa-solid fa-play"></i></span>
                </span>
            </a>

        </div>

        <div class="gallery-cta wow fadeInUp" data-wow-delay="0.45s">
            <a href="{{ route('publikasi.galeri.foto') }}">
                Lihat Semua Galeri&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i>
            </a>
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
                    <div class="swiper-wrapper">
                        
                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="https://www.lapor.go.id/" title="Saran dan Pengaduan">
                                    <div class="link-body">
                                        <figure class="image-anime sp4n-lapor-logo">
                                            <img src="{{ asset('assets/images/sp4n_lapor.png') }}" alt="Saran dan Pengaduan" decoding="async" loading="lazy">
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
                                            <img src="{{ asset('assets/sda/web/images/link/icons-layanan.svg') }}" alt="Pelayanan Publik" decoding="async" loading="lazy">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="{{ route('informasi_publik.informasi_berkala') }}" title="Layanan Informasi Publik (e-PPID)">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="{{ asset('assets/sda/web/images/link/icons-eppid.svg') }}" alt="Layanan Informasi Publik (e-PPID)" decoding="async" loading="lazy">
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
                                            <img src="{{ asset('assets/sda/web/images/link/20201015042055icons-pungli.svg') }}" alt="Saber Pungli" decoding="async" loading="lazy">
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
                                            <img src="{{ asset('assets/sda/web/images/link/icons-wrdc.svg') }}" alt="Pusat Data Sumber Daya Air" decoding="async" loading="lazy">
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
                                            <img src="{{ asset('assets/sda/web/images/link/jdih.png') }}" alt="Jaringan Dokumentasi dan Informasi Hukum Kementerian PU" decoding="async" loading="lazy">
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
                                            <img src="{{ asset('assets/sda/web/images/link/icons-elhkpn.svg') }}" alt="e-LKHPN" decoding="async" loading="lazy">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="https://wispu.pu.go.id/" title="WISPU">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="{{ asset('assets/images/wispu.png') }}" alt="WISPU" decoding="async" loading="lazy">
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

<!-- Jquery Library File -->
@endsection

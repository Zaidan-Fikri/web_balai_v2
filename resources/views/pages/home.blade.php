@extends('master.app')

@section('title', 'Beranda - Balai Air Tanah')

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
                    <div class="swiper-slide">
                        <div class="hero-slide">
                            <div class="hero-slider-image">
                                <picture>
                                    <source media="(max-width: 799px)" srcset="{{ asset('storage/' . $heroThumbnail->image_path) }}"/>
                                    <source media="(min-width: 800px)" srcset="{{ asset('storage/' . $heroThumbnail->image_path) }}"/>
                                    <img height="100%" src="{{ asset('storage/' . $heroThumbnail->image_path) }}" alt="{{ $heroThumbnail->title ?: 'Hero Thumbnail ' . $heroThumbnail->id }}">
                                </picture>
                                <div class="hero-slide-content">
                                    <p class="hero-kicker">Selamat Datang di</p>
                                    <h1 class="hero-title bat-text-anime" data-bat-anime="hero">{{ $heroThumbnail->title ?: 'BALAI AIR TANAH' }}</h1>
                                    @if ($heroThumbnail->description)
                                        <p class="hero-description">{{ $heroThumbnail->description }}</p>
                                    @endif
                                    <div class="hero-actions" aria-label="Navigasi cepat halaman utama">
                                        <a href="#tentang-kami" class="hero-btn hero-btn-primary">
                                            <span>Tentang Kami</span>
                                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                        <a href="#publikasi" class="hero-btn hero-btn-outline">
                                            <span>Informasi Publik</span>
                                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
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
                                    <img height="100%" src="{{ asset('assets/sda/assets/uploads/pengumuman/imlek-02.webp') }}" alt="Balai Air Tanah">
                                </picture>
                                <div class="hero-slide-content">
                                    <p class="hero-kicker">Selamat Datang di</p>
                                    <h1 class="hero-title bat-text-anime" data-bat-anime="hero">BALAI AIR TANAH</h1>
                                    <p class="hero-description">Mengelola air tanah secara berkelanjutan untuk mendukung ketahanan air dan kesejahteraan masyarakat.</p>
                                    <div class="hero-actions" aria-label="Navigasi cepat halaman utama">
                                        <a href="#tentang-kami" class="hero-btn hero-btn-primary">
                                            <span>Tentang Kami</span>
                                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                        </a>
                                        <a href="#publikasi" class="hero-btn hero-btn-outline">
                                            <span>Informasi Publik</span>
                                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                        </a>
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
</div><!-- Slider Section End -->

<!-- About Section Start -->
<section class="about-us home-about" id="tentang-kami">
    <div class="container">
        <div class="home-about-grid">
            <div class="about-content">
                <p class="about-kicker">Tentang Kami</p>
                <h2 class="about-name bat-text-anime" data-bat-anime="scroll">Balai Air Tanah</h2>
                <p class="about-desc">Balai Air Tanah merupakan unit pelaksana teknis di lingkungan Direktorat Jenderal Sumber Daya Air, Kementerian Pekerjaan Umum, yang berperan dalam mendukung pengelolaan sumber daya air tanah di Indonesia. Kegiatannya meliputi pengembangan, perekayasaan, pelayanan teknis, pengujian, pengkajian, serta inspeksi terkait air tanah.</p>

                <div class="about-actions">
                    <a href="{{ route('profil.index') }}" class="about-more-link">
                        <span>Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <figure class="about-image reveal">
                <img src="{{ asset('images/cp.png') }}" alt="Balai Air Tanah">
            </figure>

            <aside class="about-service-panel" aria-labelledby="aboutServiceTitle">
                <h3 id="aboutServiceTitle">Akses Layanan</h3>
                <div class="about-service-grid" aria-label="Informasi unggulan Balai Air Tanah">
                    <a href="{{ route('peta') }}" class="about-service-card">
                        <span class="about-service-card-icon" aria-hidden="true">
                            <i class="fa-solid fa-headset" aria-hidden="true"></i>
                        </span>
                        <span class="about-service-card-copy">
                            <span class="about-service-card-title">Advis Teknis</span>
                            <span class="about-service-card-desc">Konsultasi dan rekomendasi teknis air tanah</span>
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

                    <a href="{{ route('gems') }}" class="about-service-card">
                        <span class="about-service-card-icon" aria-hidden="true">
                            <i class="fa-regular fa-map" aria-hidden="true"></i>
                        </span>
                        <span class="about-service-card-copy">
                            <span class="about-service-card-title">GEMS</span>
                            <span class="about-service-card-desc">Groundwater Monitoring System</span>
                        </span>
                        <i class="fa-solid fa-arrow-right about-service-card-arrow" aria-hidden="true"></i>
                    </a>

                    <a href="{{ route('laboratorium') }}" class="about-service-card">
                        <span class="about-service-card-icon" aria-hidden="true">
                            <i class="fa-solid fa-flask" aria-hidden="true"></i>
                        </span>
                        <span class="about-service-card-copy">
                            <span class="about-service-card-title">Layanan Data</span>
                            <span class="about-service-card-desc">Layanan data Balai Air Tanah</span>
                        </span>
                        <i class="fa-solid fa-arrow-right about-service-card-arrow" aria-hidden="true"></i>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section><!-- About Section End -->

<!-- Berita Section Start -->
<div class="what-we-do berita-terkini-wrapper home-news-section">
    <div class="light-bg-section berita-terkini-section news-tabs js-publication-tabs">g
        <div class="container-fluid">
            <div class="row section-row">
                <div class="col-lg-12">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <a href="post">
                            <h3 class="wow fadeInUp section-label-link">Publikasi</h3>
                        </a>
                        <h2 class="text-anime-style-3">Berita dan Buletin</h2>
                    </div>
                    <!-- Section Title End -->
                </div>
            </div>

            <nav class="publication-menu-box news-tabs-menu" aria-label="Kategori berita dan buletin">
                <ul class="publication-menu-list">
                    <li>
                        <button type="button" class="publication-menu-link is-active js-publication-menu" data-target="home-berita">
                            <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
                            <span>Berita</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="publication-menu-link js-publication-menu" data-target="home-buletin">
                            <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                            <span>Buletin</span>
                        </button>
                    </li>
                </ul>
            </nav>

            <div class="row publication-group is-active" data-publication-group="home-berita">
                <div class="col-lg-12">
                    <!-- Testimonial Slider Start -->
                    <div class="testimonial-slider">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @forelse ($beritas as $berita)
                                    @php
                                        $firstImage = $berita->images->first();
                                        $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : asset('assets/images/placeholders/berita.svg');
                                        $imagePayload = $berita->images
                                            ->map(function ($image) {
                                                return [
                                                    'url' => asset('storage/' . $image->image_path),
                                                ];
                                            })
                                            ->values()
                                            ->toJson();
                                    @endphp
                                    <div class="swiper-slide">
                                        <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                                            <div class="post-featured-image">
                                                <figure>
                                                    <div class="image-anime">
                                                        <img src="{{ $imageUrl }}" alt="{{ $berita->judul }}">
                                                        <p class="news-date-badge">
                                                            {{ $berita->created_at ? $berita->created_at->locale('id')->translatedFormat('l, d F Y') : '-' }}
                                                        </p>
                                                    </div>
                                                </figure>
                                            </div>
                                            <div class="post-item-content">
                                                <div class="post-item-body">
                                                    <h2>{{ $berita->judul }}</h2>
                                                </div>
                                                <div class="post-item-footer text-end">
                                                    <button
                                                        type="button"
                                                        class="berita-detail-btn js-berita-detail-btn"
                                                        data-judul="{{ $berita->judul }}"
                                                        data-tanggal="{{ $berita->created_at ? $berita->created_at->locale('id')->translatedFormat('l, d F Y') : '-' }}"
                                                        data-deskripsi="{{ e($berita->deskripsi) }}"
                                                        data-images="{{ e($imagePayload) }}"
                                                    >
                                                        Selengkapnya
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                                            <div class="post-item-content">
                                                <div class="post-item-body">
                                                    <h2>Belum ada data berita.</h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    <!-- Testimonial Slider End -->
                </div>
            </div>

            <div class="row publication-group" data-publication-group="home-buletin">
                @forelse($publikasiBuletins as $item)
                    @php
                        $firstImage = $item->images->first();
                        $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : asset('assets/images/placeholders/publikasi.svg');
                    @endphp
                    <div class="col-lg-4 col-md-6 js-publication-item">
                        <div class="bulletin-item wow fadeInUp publication-card" data-wow-delay="0.25s">
                            <div class="bulletin-image">
                                <a href="{{ route('publikasi.buletin.show', $item->slug) }}">
                                    <figure>
                                        <img src="{{ $imageUrl }}" alt="{{ $item->judul }}">
                                    </figure>
                                </a>
                            </div>
                            <div class="bulletin-body mb-3">
                                <div class="bulletin-body-title">
                                    <h3>{{ $item->judul }}</h3>
                                </div>
                                <div class="bulletin-content">
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->isi), 110) }}</p>
                                    <div class="bulletin-content-footer">
                                        <a href="{{ route('publikasi.buletin.show', $item->slug) }}" class="readmore-btn">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="blog-item wow fadeInUp" data-wow-delay="0.25s">
                            <div class="post-item-content">
                                <div class="post-item-body">
                                    <h2>Belum ada data buletin.</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
                <div class="col-12"><div class="publication-dots js-publication-dots"></div></div>
            </div>
        </div>
    </div>
</div><!-- Berita Section End -->

<div class="berita-detail-overlay" id="beritaDetailOverlay" aria-hidden="true">
    <div class="berita-detail-card" role="dialog" aria-modal="true" aria-labelledby="beritaDetailTitle">
        <h2 class="berita-detail-title" id="beritaDetailTitle">Detail Berita</h2>
        <p class="berita-detail-date" id="beritaDetailDate">-</p>
        <div class="berita-detail-slider">
            <div class="berita-detail-track" id="beritaDetailTrack"></div>
        </div>
        <div class="berita-detail-dots" id="beritaDetailDots"></div>
        <p class="berita-detail-description" id="beritaDetailDescription"></p>
        <div class="text-end berita-detail-actions">
            <button type="button" class="berita-detail-btn" id="closeBeritaDetail">Tutup</button>
        </div>
    </div>
</div>
<!-- Buletin Section Start -->
<section class="buletin document-tabs js-publication-tabs" id="publikasi" aria-labelledby="publicationTitle">
    <div class="container">
        <header class="publication-head">
            <div class="section-title publication-title">
                <a href="dokumen"><h3 class="wow fadeInUp">Informasi Publik</h3></a>
                <h2 class="text-anime-style-3" id="publicationTitle">Buku &amp; Laporan</h2>
            </div>

            <nav class="publication-menu-box document-tabs-menu" aria-label="Kategori publikasi">
                <ul class="publication-menu-list">
                    <li>
                        <button type="button" class="publication-menu-link is-active js-publication-menu" data-target="karya-ilmiah">
                            <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                            <span>Karya Ilmiah</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="publication-menu-link js-publication-menu" data-target="sni">
                            <i class="fa-solid fa-building-columns" aria-hidden="true"></i>
                            <span>SNI</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="publication-menu-link js-publication-menu" data-target="laporan-skm">
                            <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                            <span>Laporan SKM</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </header>

        <div class="publication-data-pane">
            <div class="row publication-group is-active" data-publication-group="karya-ilmiah">
                @forelse($publikasiKaryaIlmiahs as $item)
                    <div class="col-lg-4 col-md-6 js-publication-item">
                        <div class="bulletin-item wow fadeInUp publication-card" data-wow-delay="0.25s">
                            <div class="bulletin-image">
                                <a href="{{ asset('storage/' . $item->pdf_path) }}" target="_blank" rel="noopener">
                                    <figure>
                                        <img src="{{ $item->thumbnail_path ? asset('storage/' . $item->thumbnail_path) : asset('assets/images/placeholders/publikasi.svg') }}" alt="{{ $item->judul }}">
                                    </figure>
                                </a>
                            </div>
                            <div class="bulletin-body mb-3">
                                <div class="bulletin-body-title">
                                    <h3>{{ $item->judul }}</h3>
                                </div>
                                <div class="bulletin-content">
                                    <p>{{ \Illuminate\Support\Str::limit($item->deskripsi, 110) }}</p>
                                    <div class="bulletin-content-footer">
                                        <a href="{{ asset('storage/' . $item->pdf_path) }}" target="_blank" rel="noopener" class="readmore-btn">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><p>Belum ada data Karya Ilmiah.</p></div>
                @endforelse
                <div class="col-12"><div class="publication-dots js-publication-dots"></div></div>
            </div>

            <div class="row publication-group" data-publication-group="sni">
                @forelse($publikasiSnis as $item)
                    <div class="col-lg-4 col-md-6 js-publication-item">
                        <div class="bulletin-item wow fadeInUp publication-card" data-wow-delay="0.25s">
                            <div class="bulletin-image">
                                <a href="{{ asset('storage/' . $item->pdf_path) }}" target="_blank" rel="noopener">
                                    <figure>
                                        <img src="{{ $item->thumbnail_path ? asset('storage/' . $item->thumbnail_path) : asset('assets/images/placeholders/publikasi.svg') }}" alt="{{ $item->judul }}">
                                    </figure>
                                </a>
                            </div>
                            <div class="bulletin-body mb-3">
                                <div class="bulletin-body-title">
                                    <h3>{{ $item->judul }}</h3>
                                </div>
                                <div class="bulletin-content">
                                    <p>{{ \Illuminate\Support\Str::limit($item->deskripsi, 110) }}</p>
                                    <div class="bulletin-content-footer">
                                        <a href="{{ asset('storage/' . $item->pdf_path) }}" target="_blank" rel="noopener" class="readmore-btn">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><p>Belum ada data SNI.</p></div>
                @endforelse
                <div class="col-12"><div class="publication-dots js-publication-dots"></div></div>
            </div>

            <div class="row publication-group" data-publication-group="laporan-skm">
                @forelse($publikasiLaporanSkms as $item)
                    <div class="col-lg-4 col-md-6 js-publication-item">
                        <div class="bulletin-item wow fadeInUp publication-card" data-wow-delay="0.25s">
                            <div class="bulletin-image">
                                <a href="{{ asset('storage/' . $item->pdf_path) }}" target="_blank" rel="noopener">
                                    <figure>
                                        <img src="{{ $item->thumbnail_path ? asset('storage/' . $item->thumbnail_path) : asset('assets/images/placeholders/publikasi.svg') }}" alt="{{ $item->judul }}">
                                    </figure>
                                </a>
                            </div>
                            <div class="bulletin-body mb-3">
                                <div class="bulletin-body-title">
                                    <h3>{{ $item->judul }}</h3>
                                </div>
                                <div class="bulletin-content">
                                    <p>{{ \Illuminate\Support\Str::limit($item->deskripsi, 110) }}</p>
                                    <div class="bulletin-content-footer">
                                        <a href="{{ asset('storage/' . $item->pdf_path) }}" target="_blank" rel="noopener" class="readmore-btn">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12"><p>Belum ada data Laporan SKM.</p></div>
                @endforelse
                <div class="col-12"><div class="publication-dots js-publication-dots"></div></div>
            </div>
        </div>
    </div>
</section><!-- Buletin Section End -->
<!-- Why Choose Us Section Start -->
<div class="akun">
    <div class="container-fluid px-3 px-lg-4">
        <div class="row section-row">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title">
                    <h3 class="wow fadeInUp">Akun Resmi</h3>
                    <h2 class="text-anime-style-3">Media Sosial & Aplikasi</h2>
                </div>
                <!-- Section Title End -->
            </div>
        </div>

        <div class="row justify-content-center">            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="siatab-widget instagram-widget wow fadeInUp" data-wow-delay="0.5s">
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
                                    <div style=" color:#3897f0; font-family:'DM Sans',sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this profile on Instagram</div>
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
                            <p style=" color:#c9c8cd; font-family:'DM Sans',sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;"><a href="https://www.instagram.com/pu_sda_balaiairtanah/?utm_source=ig_embed&utm_campaign=loading" style=" color:#c9c8cd; font-family:'DM Sans',sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank">Ditjen Sumber Daya
                                    Air</a> (@<a href="https://www.instagram.com/pu_sda_balaiairtanah/?utm_source=ig_embed&utm_campaign=loading" style=" color:#c9c8cd; font-family:'DM Sans',sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank">pu_sda_balaiairtanah</a>) � Instagram photos and videos</p></div>
                    </blockquote>
                    <script async src="//platform.instagram.com/en_US/embeds.js"></script>
                    <a class="siatab-link" href="https://www.instagram.com/pu_sda_balaiairtanah/" target="_blank" rel="noopener noreferrer">
                        <h5 class="siatab-slide-title">Instagram Balai Air Tanah</h5>
                    </a>
                </div>
            </div>

            {{-- <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="siatab-widget wow fadeInUp" data-wow-delay="0.8s">
                    <div class="swiper siatab-swiper" id="siatabSwiper">
                        <div class="swiper-wrapper">
                            @php
                                $hasSiatabSlides = false;
                            @endphp
                            @foreach ($siatabs as $siatab)
                                @if ($siatab->images->isNotEmpty())
                                    @php $hasSiatabSlides = true; @endphp
                                    @foreach ($siatab->images as $siatabImage)
                                        <div class="swiper-slide" data-title="{{ $siatab->judul }}">
                                            <article class="siatab-slide-card">
                                                <div class="siatab-slide-image">
                                                    <a class="siatab-link" href="https://siatab.sda.pu.go.id/" target="_blank" rel="noopener noreferrer">
                                                        <img src="{{ asset('storage/' . $siatabImage->image_path) }}" alt="{{ $siatab->judul }}">
                                                    </a>
                                                </div>
                                            </article>
                                        </div>
                                    @endforeach
                                @elseif ($siatab->image_path)
                                    @php $hasSiatabSlides = true; @endphp
                                    <div class="swiper-slide" data-title="{{ $siatab->judul }}">
                                        <article class="siatab-slide-card">
                                            <div class="siatab-slide-image">
                                                <a class="siatab-link" href="https://siatab.sda.pu.go.id/" target="_blank" rel="noopener noreferrer">
                                                    <img src="{{ asset('storage/' . $siatab->image_path) }}" alt="{{ $siatab->judul }}">
                                                </a>
                                            </div>
                                        </article>
                                    </div>
                                @endif
                            @endforeach
                            @if (!$hasSiatabSlides)
                                <div class="swiper-slide" data-title="Belum ada data SIATAB.">
                                    <article class="siatab-slide-card">
                                        <div class="siatab-slide-image">
                                            <a class="siatab-link" href="https://siatab.sda.pu.go.id/" target="_blank" rel="noopener noreferrer">
                                                <div class="siatab-empty">Belum ada SIATAB</div>
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            @endif
                        </div>
                        <div class="swiper-pagination siatab-pagination" id="siatabPagination"></div>
                    </div>
                    <a class="siatab-link" href="https://siatab.sda.pu.go.id/" target="_blank" rel="noopener noreferrer">
                        <h5 class="siatab-slide-title" id="siatabActiveTitle">Belum ada data SIATAB.</h5>
                    </a>
                </div>
            </div> --}}

        </div>
    </div>
</div><!-- Why Choose Us Section End -->

{{-- <!-- Cta Box Section Start -->
<div class="" style="background: linear-gradient(180deg, #F7C95F 0%, #FDB235 100%);">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <h3 class="mt-5 mb-3 text-center">Produk Hukum <br>Balai Air Tanah</h3>

                <div class="wow fadeInUp" data-wow-delay="0.75s" style="padding: 40px 40px 0;">
                    <a href="https://sda.pu.go.id/dokumen/kategori/produk_hukum">
                        <figure>
                            <img style="border-radius: 40px" src="{{ asset('assets/sda/web/images/ProdukHukum_.webp') }}" alt="Produk Hukum">
                        </figure>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div><!-- Cta Box Section End --> --}}

<!-- Pengumuman Section Start -->
<div class="what-we-do">
    <div class="light-bg-section">        <div class="container">
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
                                                                    <img src="{{ $pengumumanImage }}" alt="Pengumuman {{ $pengumuman->id }}">
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
                                                            <img width="100%" src="{{ asset('assets/images/placeholders/pengumuman.svg') }}" alt="Belum ada pengumuman">
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
</div><!-- Pengumuman Section End -->

<!-- Our Galeri Section Start -->
<div class="gallery-home">    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title">
                    <h3 class="wow fadeInUp">Galeri</h3>
                    <h2 class="text-anime-style-3">Foto dan Video</h2>
                </div>
                <!-- Section Title End -->
            </div>
        </div>

        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.25s">
                <div class="col-md-12 mb-3">
                    <!-- Intro Video Box Start -->
                    <div class="intro-video-box">
                        <!-- Video Image Start -->
                        <div class="video-image">
                            <a href="https://www.youtube.com/watch?v=CdY1yfqwm5M" class="popup-video">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/sda/web/images/thumbnail-1.webp') }}" alt="">
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
                            <img src="{{ asset('assets/sda/web/images/P4.jpg') }}" alt="Bendungan dan Danau">
                        </figure>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <a href="https://sda.pu.go.id/galeri/detail/air-tanah-air-baku">
                    <div class="why-choose-image">
                        <figure class="image-anime reveal">
                            <img src="{{ asset('assets/sda/web/images/P1.jpg') }}" alt="Air Tanah Air Baku">
                        </figure>
                    </div>
                </a>
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <!-- Why Choose Image Start -->
                <a href="https://sda.pu.go.id/galeri/detail/irigasi-dan-rawa">
                    <div class="why-choose-image">
                        <figure class="image-anime reveal">
                            <img src="{{ asset('assets/sda/web/images/P3.jpg') }}" alt="Irigasi dan Rawa">
                        </figure>
                    </div>
                </a>
                <!-- Why Choose Image End -->
            </div>

            <div class="col-lg-3 col-md-6 col-6">
                <a href="https://sda.pu.go.id/galeri/detail/sungai-dan-pantai">
                    <div class="why-choose-image">
                        <figure class="image-anime reveal">
                            <img src="{{ asset('assets/sda/web/images/P2.jpg') }}" alt="Sungai dan Pantai">
                        </figure>
                    </div>
                </a>
            </div>

            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.25s">
                <div class="col-md-12">
                    <div class="intro-video-box">
                        <div class="video-image">
                            <a href="https://www.youtube.com/watch?v=ZXjwL82IQAg" class="popup-video">
                                <figure class="image-anime">
                                    <img src="{{ asset('assets/sda/web/images/thumbnail-2.webp') }}" alt="">
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
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="http://himpsda.dev-tunnels.id" title="HIMPESDA">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="{{ asset('assets/sda/web/images/link/Logo-HIMPESDA-High-Res1.png') }}" alt="HIMPESDA">
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
                                            <img src="{{ asset('assets/sda/web/images/link/icons-saran.svg') }}" alt="Saran dan Pengaduan">
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
                                            <img src="{{ asset('assets/sda/web/images/link/icons-layanan.svg') }}" alt="Pelayanan Publik">
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
                                            <img src="{{ asset('assets/sda/web/images/link/icons-eppid.svg') }}" alt="Layanan Informasi Publik (e-PPID)">
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
                                            <img src="{{ asset('assets/sda/web/images/link/20201015042055icons-pungli.svg') }}" alt="Saber Pungli">
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
                                            <img src="{{ asset('assets/sda/web/images/link/icons-wrdc.svg') }}" alt="Pusat Data Sumber Daya Air">
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
                                            <img src="{{ asset('assets/sda/web/images/link/icons-sihka.svg') }}" alt="Sistem Informasi Hidrologi dan Kualitas Air">
                                        </figure>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="link-item">
                                <a href="{{ route('pelayanan_publik.standar_pelayanan') }}" title="Perizinan SDA">
                                    <div class="link-body">
                                        <figure class="image-anime">
                                            <img src="{{ asset('assets/sda/web/images/link/icons-perizinan.svg') }}" alt="Perizinan SDA">
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
                                            <img src="{{ asset('assets/sda/web/images/link/jdih.png') }}" alt="Jaringan Dokumentasi dan Informasi Hukum Kementerian PU">
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
                                            <img src="{{ asset('assets/sda/web/images/link/icons-elhkpn.svg') }}" alt="e-LKHPN">
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
<!-- Link Terkait Section End--><!--start: floating ads-->
{{-- <div id="popup">
    <div id="popup-content">
        <div class="text-end"><a id='close-floatads' onclick='document.getElementById(&apos;popup&apos;).style.display = &apos;none&apos;;' style=' cursor:pointer;'>
                <i class="fa fa-2x fa-window-close"></i></a>
        </div>
        <!--Script iklan-->
        <a href='#' title='Integritas Hentikan Gratifikasi'>
            <img style='max-width:400px;height:auto; left:0;' alt='Integritas Hentikan Gratifikasi' src='{{ asset('assets/sda/assets/uploads/pengumuman/poster-stop-gratifikasi.jpg') }}'/>
        </a>
        <!--Akhir script iklan-->
    </div>
</div> --}}
<!--end: floating ads-->

<!-- Jquery Library File -->
@endsection



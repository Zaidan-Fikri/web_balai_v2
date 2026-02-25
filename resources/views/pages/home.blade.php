@extends('master.app')

@section('content')

<!-- Preloader Start -->
<!-- <div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="https://sda.pu.go.id/web/images/loader.svg" alt=""></div>
		</div>
	</div>-->
<!-- Preloader End -->


<!-- Slider Section Start -->
<div class="hero bg-section hero-slider">
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
                                    <img height="100%" src="{{ asset('storage/' . $heroThumbnail->image_path) }}" alt="Hero Thumbnail {{ $heroThumbnail->id }}">
                                </picture>
                            </div>

                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-lg-12">
                                        <div class="hero-content">
                                            <div class="section-title mb-lg-5">
                                                <h3 class="wow fadeInUp mt-5 mb-3">sigap membangun negeri untuk rakyat</h3>
                                                <h1 class="text-anime-style-3 mb-lg-5 pb-lg-5" data-cursor="-opaque">#MengelolaAirUntukNegeri</h1>
                                            </div>
                                        </div>
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
                                    <source media="(max-width: 799px)" srcset="https://sda.pu.go.id/assets/uploads/pengumuman/Imlek-02.webp"/>
                                    <source media="(min-width: 800px)" srcset="https://sda.pu.go.id/assets/uploads/pengumuman/Imlek-02.webp"/>
                                    <img height="100%" src="https://sda.pu.go.id/assets/uploads/pengumuman/Imlek-02.webp" alt="Balai Air Tanah">
                                </picture>
                            </div>

                            <div class="container">
                                <div class="row align-items-center">
                                    <div class="col-lg-12">
                                        <div class="hero-content">
                                            <div class="section-title mb-lg-5">
                                                <h3 class="wow fadeInUp mt-5 mb-3">sigap membangun negeri untuk rakyat</h3>
                                                <h1 class="text-anime-style-3 mb-lg-5 pb-lg-5" data-cursor="-opaque">#MengelolaAirUntukNegeri</h1>
                                            </div>
                                        </div>
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
                            <a href="mailto:balaiairtanah@pu.go.id" class="btn-default" style="text-transform: lowercase;">balaiairtanah@pu.go.id</a>
                        </div>
                        <div class="about-contact-support">
                            {{-- <div class="icon-box">
                                <img src="https://sda.pu.go.id/web/images/icon-phone.svg" alt="kontak sda">
                            </div>
                            <div class="about-support-content">
                                <p>Kontak Kami</p>
                                <h3>(021) 158</h3>
                            </div> --}}
                        </div>
                    </div>
                    <!-- About Content Footer End -->
                </div>
            </div>
        </div>
    </div>
</div><!-- About Section End -->

<!-- Berita Section Start -->
<div class="what-we-do" style="padding: 50px 0;">
    <div class="light-bg-section">
        <style>
            .berita-detail-btn {
                border: 1px solid #edaa00;
                background: #fff4d8;
                color: #d48b00;
                border-radius: 999px;
                padding: 8px 14px;
                font-size: 14px;
                font-weight: 700;
                cursor: pointer;
            }

            .berita-detail-overlay {
                position: fixed;
                inset: 0;
                background: rgba(11, 18, 32, 0.52);
                display: none;
                align-items: center;
                justify-content: center;
                z-index: 1500;
                padding: 16px;
            }

            .berita-detail-overlay.is-open {
                display: flex;
            }

            .berita-detail-card {
                width: min(100%, 980px);
                max-height: 88vh;
                overflow: auto;
                background: #f7fbff;
                border: 1px solid #d4dfec;
                border-radius: 22px;
                padding: 18px;
            }

            .berita-detail-title {
                margin: 0 0 8px;
                color: #1a2e4a;
            }

            .berita-detail-date {
                margin: 0 0 14px;
                color: #4c5c73;
                font-size: 14px;
                font-weight: 600;
            }

            .berita-detail-slider {
                position: relative;
                overflow: hidden;
                border-radius: 12px;
                border: 1px solid #d5dfeb;
                background: #0f1b30;
                margin-bottom: 10px;
            }

            .berita-detail-track {
                display: flex;
                transition: transform .28s ease;
            }

            .berita-detail-slide {
                min-width: 100%;
            }

            .berita-detail-slide img {
                width: 100%;
                max-height: min(70vh, 760px);
                object-fit: contain;
                display: block;
                margin: 0 auto;
            }

            .berita-detail-description {
                margin: 0;
                color: #172335;
                line-height: 1.65;
                white-space: pre-wrap;
                word-break: break-word;
            }

            .berita-detail-dots {
                display: flex;
                justify-content: center;
                gap: 6px;
                margin: 0 0 14px;
            }

            .berita-detail-dot {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                border: 0;
                background: #b8c5d6;
                cursor: pointer;
                padding: 0;
            }

            .berita-detail-dot.is-active {
                background: #334570;
            }
        </style>
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
                                @forelse ($beritas as $berita)
                                    @php
                                        $firstImage = $berita->images->first();
                                        $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : 'https://placehold.co/800x520/e6edf5/27364a?text=Berita';
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
                                            <div class="post-featured-image" data-cursor-text="View">
                                                <figure>
                                                    <div class="image-anime">
                                                        <img src="{{ $imageUrl }}" alt="{{ $berita->judul }}">
                                                        <p style="position: absolute; top: 16px; left: 16px; background-color: #334570; color:#F7F9FC; padding: 0px 15px 0px 14px; gap: 0px; border-radius: 40px;">
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
        <div class="text-end" style="margin-top: 14px;">
            <button type="button" class="berita-detail-btn" id="closeBeritaDetail">Tutup</button>
        </div>
    </div>
</div>

<script>
    (function () {
        const overlay = document.getElementById('beritaDetailOverlay');
        const title = document.getElementById('beritaDetailTitle');
        const date = document.getElementById('beritaDetailDate');
        const description = document.getElementById('beritaDetailDescription');
        const track = document.getElementById('beritaDetailTrack');
        const dots = document.getElementById('beritaDetailDots');
        const closeButton = document.getElementById('closeBeritaDetail');
        const detailButtons = document.querySelectorAll('.js-berita-detail-btn');
        let currentIndex = 0;
        let currentImages = [];

        if (!overlay || !title || !date || !description || !track || !dots || !closeButton || !detailButtons.length) return;

        function decodeHtmlEntities(value) {
            const textarea = document.createElement('textarea');
            textarea.innerHTML = value;
            return textarea.value;
        }

        function parseImages(raw) {
            if (!raw) return [];
            try {
                const normalized = decodeHtmlEntities(String(raw));
                const parsed = JSON.parse(normalized);
                return Array.isArray(parsed) ? parsed : [];
            } catch (error) {
                return [];
            }
        }

        function renderSlider() {
            track.innerHTML = '';
            dots.innerHTML = '';

            if (!currentImages.length) {
                track.innerHTML = '<div class="berita-detail-slide"><img src="https://placehold.co/800x520/e6edf5/27364a?text=Tidak+ada+gambar" alt="Tidak ada gambar"></div>';
                track.style.transform = 'translateX(0)';
                return;
            }

            currentImages.forEach(function (item, index) {
                const slide = document.createElement('div');
                slide.className = 'berita-detail-slide';
                slide.innerHTML = '<img src="' + item.url + '" alt="Gambar berita ' + (index + 1) + '">';
                track.appendChild(slide);

                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'berita-detail-dot' + (index === currentIndex ? ' is-active' : '');
                dot.addEventListener('click', function () {
                    currentIndex = index;
                    track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
                    dots.querySelectorAll('.berita-detail-dot').forEach(function (dotEl, dotIndex) {
                        dotEl.classList.toggle('is-active', dotIndex === currentIndex);
                    });
                });
                dots.appendChild(dot);
            });

            dots.style.display = currentImages.length > 1 ? 'flex' : 'none';
            track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
        }

        function openOverlay() {
            overlay.classList.add('is-open');
            overlay.setAttribute('aria-hidden', 'false');
        }

        function closeOverlay() {
            overlay.classList.remove('is-open');
            overlay.setAttribute('aria-hidden', 'true');
        }

        detailButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                currentImages = parseImages(button.dataset.images);
                currentIndex = 0;

                title.textContent = button.dataset.judul || 'Detail Berita';
                date.textContent = button.dataset.tanggal || '-';
                description.textContent = button.dataset.deskripsi || '-';
                renderSlider();

                openOverlay();
            });
        });

        closeButton.addEventListener('click', closeOverlay);

        overlay.addEventListener('click', function (event) {
            if (event.target === overlay) {
                closeOverlay();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && overlay.classList.contains('is-open')) {
                closeOverlay();
            }
        });
    })();
</script>

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

                <div class="publication-split">
            <aside class="publication-menu-pane">
                <div class="publication-menu-box">
                    <div class="publication-menu-head">
                        <h3 class="publication-menu-title">Menu Publikasi</h3>
                    </div>
                        <style>
                            .publication-menu-box {
                                background: #0b1f4d;
                                border-radius: 22px;
                                padding: 18px 14px;
                                min-height: 220px;
                                color: #ffffff;
                                border: 1px solid rgba(255, 255, 255, 0.14);
                                box-shadow: 0 14px 28px rgba(8, 15, 36, 0.34);
                                position: relative;
                                z-index: 5;
                            }

                            .publication-menu-title {
                                margin: 0;
                                color: #ffffff;
                                font-size: 18px;
                                font-weight: 800;
                                line-height: 1.2;
                            }

                            .publication-menu-desc {
                                margin: 10px 0 14px;
                                color: #dbe7ff;
                            }

                            .publication-menu-list {
                                list-style: none;
                                margin: 0;
                                padding: 0;
                                display: grid;
                                gap: 6px;
                            }

                            .publication-menu-content {
                                display: block;
                            }

                            .publication-menu-link {
                                width: 100%;
                                display: flex;
                                align-items: center;
                                gap: 8px;
                                color: #dbe7ff;
                                text-decoration: none;
                                cursor: pointer;
                                border: 1px solid transparent;
                                background: transparent;
                                padding: 10px 12px;
                                border-radius: 12px;
                                text-align: left;
                                font: inherit;
                                font-weight: 700;
                                font-size: 16px;
                                line-height: 1.35;
                            }

                            .publication-menu-link span {
                                color: inherit;
                                display: inline-block;
                            }

                            .publication-menu-link ion-icon {
                                font-size: 16px;
                                color: inherit;
                                flex-shrink: 0;
                            }

                            .publication-menu-link.is-active {
                                color: #ffffff;
                                background: rgba(255, 255, 255, 0.12);
                                border-color: rgba(255, 255, 255, 0.22);
                            }

                            .publication-group {
                                display: none;
                                min-height: 620px;
                            }

                            .publication-group.is-active {
                                display: flex;
                            }

                            .publication-dots {
                                width: 100%;
                                display: none;
                                justify-content: center;
                                align-items: center;
                                gap: 8px;
                                margin-top: 8px;
                            }

                            .publication-dot {
                                width: 10px;
                                height: 10px;
                                border: 0;
                                border-radius: 50%;
                                background: #b4c2d6;
                                cursor: pointer;
                                padding: 0;
                            }

                            .publication-dot.is-active {
                                background: #334570;
                            }

                            .publication-split {
                                display: grid;
                                grid-template-columns: 240px minmax(0, 1fr);
                                gap: 22px;
                                align-items: start;
                            }

                            .publication-menu-pane {
                                min-width: 0;
                            }

                            .publication-menu-box { width: 100%; }

                            .publication-data-pane {
                                min-width: 0;
                            }

                            .publication-card {
                                max-width: 420px;
                                margin-left: auto;
                                margin-right: auto;
                            }

                            .publication-card .bulletin-image figure {
                                height: 560px;
                                overflow: hidden;
                                border-radius: 30px;
                            }

                            .publication-card .bulletin-image img {
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                            }

                            .publication-card .bulletin-body {
                                min-height: 210px;
                            }

                            @media (max-width: 991px) {
                                .publication-group {
                                    min-height: 0;
                                }
                                .publication-split {
                                    grid-template-columns: 1fr;
                                }
                                .publication-card .bulletin-image figure { height: 420px; }
                                .publication-menu-box { min-height: 0; }
                            }

                            @media (max-width: 575px) {
                                .publication-card .bulletin-image figure { height: 360px; }
                            }
                        </style>
                        <div class="publication-menu-content">
                            <p class="publication-menu-desc">Pilih kategori publikasi:</p>
                            <ul class="publication-menu-list">
                                <li><button type="button" class="publication-menu-link is-active js-publication-menu" data-target="karya-ilmiah"><ion-icon name="book-outline" aria-hidden="true"></ion-icon><span>Karya Ilmiah</span></button></li>
                                <li><button type="button" class="publication-menu-link js-publication-menu" data-target="sni"><ion-icon name="library-outline" aria-hidden="true"></ion-icon><span>SNI</span></button></li>
                                <li><button type="button" class="publication-menu-link js-publication-menu" data-target="laporan-skm"><ion-icon name="document-text-outline" aria-hidden="true"></ion-icon><span>Laporan SKM</span></button></li>
                                {{-- <li><a class="publication-menu-link" href="dokumen">Dokumen</a></li> --}}
                            </ul>
                        </div>
                </div>
            </aside>
            <div class="publication-data-pane">
                <div class="row publication-group is-active" data-publication-group="karya-ilmiah">
                    @forelse($publikasiKaryaIlmiahs as $item)
                        <div class="col-lg-4 col-md-6 js-publication-item">
                            <div class="bulletin-item wow fadeInUp publication-card" data-wow-delay="0.25s">
                                <div class="bulletin-image" data-cursor-text="View">
                                    <a href="{{ asset('storage/' . $item->pdf_path) }}" target="_blank" rel="noopener">
                                        <figure>
                                            <img src="{{ $item->thumbnail_path ? asset('storage/' . $item->thumbnail_path) : 'https://placehold.co/500x680/e6edf5/27364a?text=Publikasi' }}" alt="{{ $item->judul }}">
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
                                <div class="bulletin-image" data-cursor-text="View">
                                    <a href="{{ asset('storage/' . $item->pdf_path) }}" target="_blank" rel="noopener">
                                        <figure>
                                            <img src="{{ $item->thumbnail_path ? asset('storage/' . $item->thumbnail_path) : 'https://placehold.co/500x680/e6edf5/27364a?text=Publikasi' }}" alt="{{ $item->judul }}">
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
                                <div class="bulletin-image" data-cursor-text="View">
                                    <a href="{{ asset('storage/' . $item->pdf_path) }}" target="_blank" rel="noopener">
                                        <figure>
                                            <img src="{{ $item->thumbnail_path ? asset('storage/' . $item->thumbnail_path) : 'https://placehold.co/500x680/e6edf5/27364a?text=Publikasi' }}" alt="{{ $item->judul }}">
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
    </div>
</div><!-- Buletin Section End -->

<script>
    (function () {
        const menuButtons = document.querySelectorAll('.js-publication-menu');
        const groups = document.querySelectorAll('[data-publication-group]');
        if (!menuButtons.length || !groups.length) return;

        const pageSize = 3;

        function renderGroupPage(group, page) {
            const items = Array.from(group.querySelectorAll('.js-publication-item'));
            const dotsWrap = group.querySelector('.js-publication-dots');
            const totalPages = Math.ceil(items.length / pageSize);
            const safePage = Math.max(1, Math.min(page, Math.max(totalPages, 1)));
            group.dataset.currentPage = String(safePage);

            items.forEach(function (item, index) {
                const start = (safePage - 1) * pageSize;
                const end = safePage * pageSize;
                item.style.display = (index >= start && index < end) ? '' : 'none';
            });

            if (!dotsWrap) return;
            dotsWrap.innerHTML = '';
            if (totalPages <= 1) {
                dotsWrap.style.display = 'none';
                return;
            }

            dotsWrap.style.display = 'flex';
            for (let i = 1; i <= totalPages; i++) {
                const dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'publication-dot' + (i === safePage ? ' is-active' : '');
                dot.addEventListener('click', function () {
                    renderGroupPage(group, i);
                });
                dotsWrap.appendChild(dot);
            }
        }

        function activateTarget(target) {
            menuButtons.forEach(function (btn) {
                btn.classList.toggle('is-active', btn.getAttribute('data-target') === target);
            });

            groups.forEach(function (group) {
                const isActive = group.getAttribute('data-publication-group') === target;
                group.classList.toggle('is-active', isActive);
                if (isActive) {
                    renderGroupPage(group, 1);
                }
            });
        }

        menuButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const target = button.getAttribute('data-target');
                if (!target) return;
                activateTarget(target);
            });
        });

        const activeButton = document.querySelector('.js-publication-menu.is-active') || menuButtons[0];
        if (activeButton) {
            const initialTarget = activeButton.getAttribute('data-target');
            if (initialTarget) {
                activateTarget(initialTarget);
            }
        }
    })();
</script>

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
                {{-- <div class="iframely-embed"><div class="iframely-responsive" style="height: 140px; padding-bottom: 0;"><a href="https://www.youtube.com/channel/UCSIbT953e30J_K0fKT8nPgA" data-iframely-url="//iframely.net/BOkn3PiP?theme=dark"></a></div></div><script async src="//iframely.net/embed.js"></script> --}}
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
                                    Air</a> (@<a href="https://www.instagram.com/pu_sda_balaiairtanah/?utm_source=ig_embed&utm_campaign=loading" style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px;" target="_blank">pu_sda_balaiairtanah</a>) � Instagram photos and videos</p></div>
                    </blockquote>
                    <script async src="//platform.instagram.com/en_US/embeds.js"></script>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                <!-- Project Item Start -->
                {{-- <div class="project-item wow fadeInUp" data-wow-delay="1s">
                    <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@pu_sda" data-unique-id="pu_sda" data-embed-type="creator" style="max-width: 780px; min-width: 288px;margin-top: 0;">
                        <section><a target="_blank" href="https://www.tiktok.com/@pu_sda?refer=creator_embed">&#64;pu_sda</a></section>
                    </blockquote>
                    <script async src="https://www.tiktok.com/embed.js"></script>
                </div> --}}
                <!-- Project Item End -->
            </div>
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
                            <img style="border-radius: 40px" src="https://sda.pu.go.id/web/images/ProdukHukum_.webp" alt="Produk Hukum">
                        </figure>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div><!-- Cta Box Section End --> --}}

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
                                <a href="{{ route('informasi_publik.informasi_berkala') }}" title="Layanan Informasi Publik (e-PPID)">
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
                                <a href="{{ route('pelayanan_publik.standar_pelayanan') }}" title="Perizinan SDA">
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


<!-- Jquery Library File -->
@endsection

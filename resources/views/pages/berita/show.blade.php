@extends('master.app')

@section('title', $berita->judul . ' - Berita Balai Air Tanah')

@push('styles')
<style>
    .berita-show-section {
        padding: clamp(36px, 5vw, 64px) 0 clamp(48px, 6vw, 80px);
        background: #f0f4f9;
    }
    .berita-back-link { margin-bottom: 24px; }

    /* Two-column layout */
    .berita-show-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 28px;
        align-items: start;
    }

    /* Main card */
    .berita-show-card {
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 8px 40px rgba(10,38,71,0.11), 0 2px 8px rgba(10,38,71,0.06);
        border: 1px solid #e2e9f4;
    }
    .berita-show-head {
        padding: 24px 36px 28px;
        border-bottom: 1px solid #edf0f8;
        background: linear-gradient(135deg, #ffffff 0%, #f7f9ff 100%);
    }
    .berita-show-title {
        margin: 0 0 14px;
        color: #061d3f;
        font-size: clamp(1.3rem, 2.5vw, 1.9rem);
        font-weight: 900;
        line-height: 1.18;
        letter-spacing: -.01em;
    }

    .berita-show-card .buletin-slider {
        border-radius: 0;
        border: none;
        border-top: 1px solid #e4ecf7;
        border-bottom: 1px solid #e4ecf7;
        margin-bottom: 0;
    }
    .berita-show-content {
        padding: 28px 36px 32px;
        color: #253145;
        font-size: clamp(15px, 1.3vw, 16.5px);
        line-height: 1.95;
        word-break: break-word;
    }
    .berita-show-empty {
        padding: 36px;
        text-align: center;
        color: #8899aa;
        font-size: .9rem;
    }


    /* Sidebar */
    .berita-sidebar {
        background: #fff;
        border-radius: 24px;
        border: 1px solid #e2e9f4;
        box-shadow: 0 8px 32px rgba(10,38,71,0.09);
        overflow: hidden;
        position: sticky;
        top: 24px;
    }
    .berita-sidebar-head {
        background: linear-gradient(135deg, #0f2d5a 0%, #1a6bcc 100%);
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .berita-sidebar-head-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: rgba(255,255,255,0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: .85rem;
        flex-shrink: 0;
    }
    .berita-sidebar-head-text {
        font-size: .78rem;
        font-weight: 900;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #fff;
    }
    .berita-sidebar-list {
        padding: 8px 0;
    }
    .berita-sidebar-item {
        display: flex;
        gap: 14px;
        align-items: flex-start;
        padding: 12px 16px;
        text-decoration: none;
        border-bottom: 1px solid #f0f4fb;
        transition: background .18s;
        position: relative;
    }
    .berita-sidebar-item:last-child { border-bottom: none; }
    .berita-sidebar-item::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, #1a6bcc, #0f2d5a);
        border-radius: 0 3px 3px 0;
        opacity: 0;
        transition: opacity .18s;
    }
    .berita-sidebar-item:hover {
        background: #f4f8ff;
        text-decoration: none;
    }
    .berita-sidebar-item:hover::before {
        opacity: 1;
    }
    .berita-sidebar-thumb {
        width: 72px;
        min-width: 72px;
        height: 56px;
        border-radius: 10px;
        overflow: hidden;
        background: #e4ecf7;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(10,38,71,0.10);
    }
    .berita-sidebar-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .3s;
    }
    .berita-sidebar-item:hover .berita-sidebar-thumb img {
        transform: scale(1.06);
    }
    .berita-sidebar-info {
        flex: 1;
        min-width: 0;
        padding-top: 2px;
    }
    .berita-sidebar-date {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: .66rem;
        font-weight: 700;
        color: #d89100;
        margin-bottom: 6px;
    }
    .berita-sidebar-title {
        font-size: .83rem;
        font-weight: 800;
        color: #0f2d5a;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin: 0;
        transition: color .18s;
    }
    .berita-sidebar-item:hover .berita-sidebar-title {
        color: #1a6bcc;
    }
    .berita-sidebar-footer {
        padding: 14px 16px;
        border-top: 1px solid #e8eef8;
        background: linear-gradient(135deg, #f7faff 0%, #eef4ff 100%);
    }
    .berita-sidebar-all {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        font-size: .8rem;
        font-weight: 800;
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 12px;
        background: linear-gradient(135deg, #0f2d5a 0%, #1a6bcc 100%);
        box-shadow: 0 4px 14px rgba(26,107,204,.3);
        transition: opacity .18s, transform .18s, box-shadow .18s;
        letter-spacing: .02em;
    }
    .berita-sidebar-all:hover {
        opacity: .88;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(26,107,204,.38);
        color: #fff;
        text-decoration: none;
    }
    .berita-sidebar-all i {
        transition: transform .2s;
    }
    .berita-sidebar-all:hover i {
        transform: translateX(3px);
    }
    .berita-sidebar-empty {
        padding: 28px 20px;
        text-align: center;
        color: #99aabb;
        font-size: .82rem;
    }
    .berita-sidebar-empty-inner {
        background: #fff;
        border: 1px dashed #d0ddf0;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        color: #99aabb;
        font-size: .82rem;
    }



    @media (max-width: 900px) {
        .berita-show-layout { grid-template-columns: 1fr; }
        .berita-sidebar { position: static; }
    }
    @media (max-width: 640px) {
        .berita-show-head,
        .berita-show-content { padding: 22px 20px; }
        .berita-show-empty { padding: 28px 20px; }
    }
</style>
@endpush


@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Berita', 'pageTitle' => $berita->judul])

    <section class="berita-show-section">
        <div class="container">

            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <a href="{{ route('publikasi.berita') }}">Berita</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <span class="bc-current">{{ $berita->judul }}</span>
            </nav>

            <div class="berita-show-layout">

                {{-- Main Article --}}
                <article class="berita-show-card">
                    <div class="berita-show-head">
                        <h1 class="berita-show-title">{{ $berita->judul }}</h1>
                        <div class="buletin-detail-meta">
                            <span>
                                <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                {{ $berita->created_at ? $berita->created_at->locale('id')->translatedFormat('d F Y') : '-' }}
                            </span>
                            <span>
                                <i class="fa-regular fa-eye" aria-hidden="true"></i>
                                {{ number_format($berita->views) }} Views
                            </span>
                        </div>
                    </div>

                    @php
                        $hasVideo = !empty($berita->video_path);
                        $hasImages = $berita->images->isNotEmpty();
                        $totalSlides = ($hasVideo ? 1 : 0) + $berita->images->count();
                        $posterUrl = $hasImages ? asset('storage/' . $berita->images->first()->image_path) : '';
                    @endphp

                    @if ($hasVideo || $hasImages)
                    <div class="buletin-slider js-buletin-slider" aria-label="Slide-show berita">
                        <div class="buletin-slider-track js-buletin-slider-track">

                            {{-- Video slide (first) --}}
                            @if ($hasVideo)
                                <div class="buletin-slider-slide buletin-slider-slide--video">
                                    @if ($berita->video_orientasi === 'portrait')
                                        <video class="buletin-slide-video--portrait"
                                               src="{{ asset('storage/' . $berita->video_path) }}"
                                               @if($posterUrl) poster="{{ $posterUrl }}" @endif
                                               controls preload="metadata"></video>
                                    @else
                                        <video class="buletin-slide-video--landscape"
                                               src="{{ asset('storage/' . $berita->video_path) }}"
                                               @if($posterUrl) poster="{{ $posterUrl }}" @endif
                                               controls preload="metadata"></video>
                                    @endif
                                    <span class="buletin-slide-video-badge">
                                        <i class="fa-solid fa-play fa-xs"></i> Video
                                    </span>
                                </div>
                            @endif

                            {{-- Photo slides --}}
                            @foreach ($berita->images as $image)
                                <div class="buletin-slider-slide">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                         alt="{{ $berita->judul }} - foto {{ $loop->iteration }}">
                                </div>
                            @endforeach

                        </div>
                        @if ($totalSlides > 1)
                        <button type="button" class="buletin-slider-nav buletin-slider-prev js-buletin-slider-prev" aria-label="Sebelumnya">
                            <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="buletin-slider-nav buletin-slider-next js-buletin-slider-next" aria-label="Berikutnya">
                            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                        </button>
                        @endif
                        <div class="buletin-slider-dots js-buletin-slider-dots"></div>
                    </div>
                    @endif

                    @if ($berita->deskripsi)
                        <div class="berita-show-content">
                            {!! nl2br(e($berita->deskripsi)) !!}
                        </div>
                    @else
                        <div class="berita-show-empty">Belum ada deskripsi untuk berita ini.</div>
                    @endif
                </article>

                {{-- Sidebar: Berita Lainnya --}}
                <aside class="berita-sidebar">
                    {{-- Header --}}
                    <div class="berita-sidebar-head">
                        <div class="berita-sidebar-head-icon">
                            <i class="fa-solid fa-newspaper"></i>
                        </div>
                        <span class="berita-sidebar-head-text">Berita Lainnya</span>
                    </div>

                    {{-- List --}}
                    <div class="berita-sidebar-list">
                        @forelse ($otherBeritas as $other)
                            @php
                                $thumb = $other->images->first();
                                $thumbUrl = $thumb
                                    ? asset('storage/' . $thumb->image_path)
                                    : asset('assets/images/placeholders/berita.svg');
                            @endphp
                            <a href="{{ route('publikasi.berita.show', $other) }}" class="berita-sidebar-item">
                                <div class="berita-sidebar-thumb">
                                    <img src="{{ $thumbUrl }}" alt="{{ $other->judul }}">
                                </div>
                                <div class="berita-sidebar-info">
                                    <p class="berita-sidebar-date">
                                        <i class="fa-regular fa-calendar fa-xs"></i>
                                        {{ $other->created_at ? $other->created_at->locale('id')->translatedFormat('d M Y') : '-' }}
                                    </p>
                                    <p class="berita-sidebar-title">{{ $other->judul }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="berita-sidebar-empty">Belum ada berita lainnya.</div>
                        @endforelse
                    </div>

                    {{-- Footer --}}
                    @if ($otherBeritas->isNotEmpty())
                        <div class="berita-sidebar-footer">
                            <a href="{{ route('publikasi.berita') }}" class="berita-sidebar-all">
                                Lihat Semua Berita
                                <i class="fa-solid fa-arrow-right fa-xs"></i>
                            </a>
                        </div>
                    @endif
                </aside>

            </div>
        </div>
    </section>
@endsection

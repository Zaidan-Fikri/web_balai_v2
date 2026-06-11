@extends('master.app')

@section('title', $infografis->judul . ' - Infografis Balai Air Tanah')

@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Publikasi', 'pageTitle' => $infografis->judul])

    <section class="buletin-detail-section">
        <div class="container">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <a href="{{ route('publikasi.infografis') }}">Infografis</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <span class="bc-current">{{ $infografis->judul }}</span>
            </nav>

            <div class="pub-sidebar-layout">

                {{-- Main Content --}}
                <article class="buletin-detail-card">
                    <header class="buletin-detail-head">
                        <h2>{{ $infografis->judul }}</h2>
                        <div class="buletin-detail-meta">
                            <span><i class="fa-regular fa-calendar" aria-hidden="true"></i>{{ $infografis->created_at ? $infografis->created_at->locale('id')->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                    </header>

                    <div class="buletin-slider js-buletin-slider" aria-label="Slide-show infografis">
                        <div class="buletin-slider-track js-buletin-slider-track">
                            @forelse ($infografis->images as $image)
                                <div class="buletin-slider-slide">
                                    <a href="{{ asset('storage/' . $image->image_path) }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ asset('storage/' . $image->image_path) }}"
                                             alt="{{ $infografis->judul }} - gambar {{ $loop->iteration }}"
                                             style="cursor: zoom-in;">
                                    </a>
                                </div>
                            @empty
                                <div class="buletin-slider-slide">
                                    <img src="{{ asset('assets/images/placeholders/no-image.svg') }}" alt="Tidak ada gambar">
                                </div>
                            @endforelse
                        </div>
                        @if ($infografis->images->count() > 1)
                            <button type="button" class="buletin-slider-nav buletin-slider-prev js-buletin-slider-prev" aria-label="Gambar sebelumnya">
                                <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="buletin-slider-nav buletin-slider-next js-buletin-slider-next" aria-label="Gambar berikutnya">
                                <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                            </button>
                        @endif
                        <div class="buletin-slider-dots js-buletin-slider-dots"></div>
                    </div>

                    @if ($infografis->deskripsi)
                        <div class="buletin-detail-content">
                            {!! nl2br(e($infografis->deskripsi)) !!}
                        </div>
                    @endif

                </article>

                {{-- Sidebar: Infografis Lainnya --}}
                <aside class="pub-sidebar">
                    <div class="pub-sidebar-head">
                        <div class="pub-sidebar-head-icon">
                            <i class="fa-solid fa-chart-bar"></i>
                        </div>
                        <span class="pub-sidebar-head-text">Infografis Lainnya</span>
                    </div>
                    <div class="pub-sidebar-list">
                        @forelse ($otherInfografis as $other)
                            @php
                                $thumb = $other->images->first();
                                $thumbUrl = $thumb
                                    ? asset('storage/' . $thumb->image_path)
                                    : asset('assets/images/placeholders/publikasi.svg');
                            @endphp
                            <a href="{{ route('publikasi.infografis.show', $other) }}" class="pub-sidebar-item">
                                <div class="pub-sidebar-thumb">
                                    <img src="{{ $thumbUrl }}" alt="{{ $other->judul }}">
                                </div>
                                <div class="pub-sidebar-info">
                                    <p class="pub-sidebar-date">
                                        <i class="fa-regular fa-calendar fa-xs"></i>
                                        {{ $other->created_at ? $other->created_at->locale('id')->translatedFormat('d M Y') : '-' }}
                                    </p>
                                    <p class="pub-sidebar-title">{{ $other->judul }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="pub-sidebar-empty">Belum ada infografis lainnya.</div>
                        @endforelse
                    </div>
                    @if ($otherInfografis->isNotEmpty())
                        <div class="pub-sidebar-footer">
                            <a href="{{ route('publikasi.infografis') }}" class="pub-sidebar-all">
                                Lihat Semua Infografis
                                <i class="fa-solid fa-arrow-right fa-xs"></i>
                            </a>
                        </div>
                    @endif
                </aside>

            </div>
        </div>
    </section>
@endsection

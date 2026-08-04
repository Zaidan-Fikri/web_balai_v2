@extends('master.app')

@section('title', $buletin->judul . ' - Edukasi Balai Air Tanah')

@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Edukasi'])

    <section class="buletin-detail-section">
        <div class="container">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <a href="{{ route('publikasi.buletin.index') }}">Edukasi</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <span class="bc-current">{{ $buletin->judul }}</span>
            </nav>

            <div class="pub-sidebar-layout">

                {{-- Main Article --}}
                <article class="buletin-detail-card">
                    <header class="buletin-detail-head">
                        <h2>{{ $buletin->judul }}</h2>
                        <div class="buletin-detail-meta">
                            <span><i class="fa-regular fa-calendar" aria-hidden="true"></i>{{ $buletin->published_at ? $buletin->published_at->locale('id')->translatedFormat('d F Y') : '-' }}</span>
                            <span><i class="fa-regular fa-eye" aria-hidden="true"></i>{{ number_format($buletin->views) }} Views</span>
                        </div>
                    </header>

                    <div class="buletin-slider js-buletin-slider" aria-label="Slide-show gambar edukasi">
                        <div class="buletin-slider-track js-buletin-slider-track">
                            @forelse ($buletin->images as $image)
                                <div class="buletin-slider-slide">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $buletin->judul }} - gambar {{ $loop->iteration }}">
                                </div>
                            @empty
                                <div class="buletin-slider-slide">
                                    <img src="{{ asset('assets/images/placeholders/no-image.svg') }}" alt="Tidak ada gambar">
                                </div>
                            @endforelse
                        </div>
                        <button type="button" class="buletin-slider-nav buletin-slider-prev js-buletin-slider-prev" aria-label="Gambar sebelumnya">
                            <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="buletin-slider-nav buletin-slider-next js-buletin-slider-next" aria-label="Gambar berikutnya">
                            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                        </button>
                        <div class="buletin-slider-dots js-buletin-slider-dots"></div>
                    </div>

                    <div class="buletin-detail-content">
                        {!! nl2br(e($buletin->isi)) !!}
                    </div>

                </article>

                {{-- Sidebar: Edukasi Lainnya --}}
                <aside class="pub-sidebar">
                    <div class="pub-sidebar-head">
                        <div class="pub-sidebar-head-icon">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <span class="pub-sidebar-head-text">Edukasi Lainnya</span>
                    </div>
                    <div class="pub-sidebar-list">
                        @forelse ($otherBuletins as $other)
                            @php
                                $thumb = $other->images->first();
                                $thumbUrl = $thumb
                                    ? asset('storage/' . $thumb->image_path)
                                    : asset('assets/images/placeholders/publikasi.svg');
                            @endphp
                            <a href="{{ route('publikasi.buletin.show', $other->slug) }}" class="pub-sidebar-item">
                                <div class="pub-sidebar-thumb">
                                    <img src="{{ $thumbUrl }}" alt="{{ $other->judul }}">
                                </div>
                                <div class="pub-sidebar-info">
                                    <p class="pub-sidebar-date">
                                        <i class="fa-regular fa-calendar fa-xs"></i>
                                        {{ $other->published_at ? $other->published_at->locale('id')->translatedFormat('d M Y') : '-' }}
                                    </p>
                                    <p class="pub-sidebar-title">{{ $other->judul }}</p>
                                </div>
                            </a>
                        @empty
                            <div class="pub-sidebar-empty">Belum ada edukasi lainnya.</div>
                        @endforelse
                    </div>
                    @if ($otherBuletins->isNotEmpty())
                        <div class="pub-sidebar-footer">
                            <a href="{{ route('publikasi.buletin.index') }}" class="pub-sidebar-all">
                                Lihat Semua Edukasi
                                <i class="fa-solid fa-arrow-right fa-xs"></i>
                            </a>
                        </div>
                    @endif
                </aside>

            </div>
        </div>
    </section>
@endsection

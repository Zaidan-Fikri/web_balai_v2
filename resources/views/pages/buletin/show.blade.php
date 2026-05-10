@extends('master.app')

@section('title', $buletin->judul . ' - Buletin Balai Air Tanah')

@section('content')
    <section class="content-page-hero buletin-detail-hero">
        <div class="container">
            <p class="content-page-kicker">Buletin</p>
            <h1>{{ $buletin->judul }}</h1>
            <div class="content-page-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <a href="{{ route('publikasi.buletin.index') }}">Buletin</a>
                <span>/</span>
                <span>Detail</span>
            </div>
        </div>
    </section>

    <section class="buletin-detail-section">
        <div class="container">
            <article class="buletin-detail-card">
                <header class="buletin-detail-head">
                    <h2>{{ $buletin->judul }}</h2>
                    <div class="buletin-detail-meta">
                        <span><i class="fa-regular fa-calendar" aria-hidden="true"></i>{{ $buletin->published_at ? $buletin->published_at->locale('id')->translatedFormat('d F Y') : '-' }}</span>
                        <span><i class="fa-regular fa-eye" aria-hidden="true"></i>{{ number_format($buletin->views) }} Views</span>
                        <span><i class="fa-regular fa-user" aria-hidden="true"></i>{{ $buletin->author?->email ?? 'Admin BAT' }}</span>
                    </div>
                </header>

                <div class="buletin-slider js-buletin-slider" aria-label="Slide-show gambar buletin">
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
        </div>
    </section>
@endsection

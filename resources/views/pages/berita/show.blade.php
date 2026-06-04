@extends('master.app')

@section('title', $berita->judul . ' - Berita Balai Air Tanah')

@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Berita', 'pageTitle' => $berita->judul])

    <section class="buletin-detail-section">
        <div class="container">
            <article class="buletin-detail-card">
                <header class="buletin-detail-head">
                    <h2>{{ $berita->judul }}</h2>
                    <div class="buletin-detail-meta">
                        <span><i class="fa-regular fa-calendar" aria-hidden="true"></i>{{ $berita->created_at ? $berita->created_at->locale('id')->translatedFormat('d F Y') : '-' }}</span>
                    </div>
                </header>

                <div class="buletin-slider js-buletin-slider" aria-label="Slide-show gambar berita">
                    <div class="buletin-slider-track js-buletin-slider-track">
                        @forelse ($berita->images as $image)
                            <div class="buletin-slider-slide">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $berita->judul }} - gambar {{ $loop->iteration }}">
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
                    {!! nl2br(e($berita->deskripsi)) !!}
                </div>
            </article>
        </div>
    </section>
@endsection

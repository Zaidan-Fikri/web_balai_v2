@extends('master.app')

@section('title', 'Edukasi - Balai Air Tanah')

@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Edukasi'])

    <section class="buletin-list-section">
        <div class="container">
            <div class="buletin-card-grid">
                @forelse ($buletins as $buletin)
                    @php
                        $firstImage = $buletin->images->first();
                        $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : asset('assets/images/placeholders/publikasi.svg');
                    @endphp
                    <article class="buletin-card">
                        <a class="buletin-card-image" href="{{ route('publikasi.buletin.show', $buletin->slug) }}">
                            <img src="{{ $imageUrl }}" alt="{{ $buletin->judul }}">
                        </a>
                        <div class="buletin-card-body">
                            <p class="buletin-card-date">
                                <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                {{ $buletin->published_at ? $buletin->published_at->locale('id')->translatedFormat('d F Y') : '-' }}
                            </p>
                            <h2><a href="{{ route('publikasi.buletin.show', $buletin->slug) }}">{{ $buletin->judul }}</a></h2>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($buletin->isi), 155) }}</p>
                            <a class="buletin-card-link" href="{{ route('publikasi.buletin.show', $buletin->slug) }}">
                                Selengkapnya
                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="buletin-empty">
                        <h2>Belum ada edukasi yang dipublish.</h2>
                        <p>Silakan cek kembali halaman ini secara berkala.</p>
                    </div>
                @endforelse
            </div>

            @if ($buletins->hasPages())
                <div class="buletin-pagination">
                    {{ $buletins->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>
@endsection

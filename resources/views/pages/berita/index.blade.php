@extends('master.app')

@section('title', 'Berita - Balai Air Tanah')

@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Berita'])

    <section class="buletin-list-section">
        <div class="container">
            <div class="buletin-card-grid">
                @forelse ($beritas as $berita)
                    @php
                        $firstImage = $berita->images->first();
                        $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : asset('assets/images/placeholders/berita.svg');
                    @endphp
                    <article class="buletin-card">
                        <a class="buletin-card-image" href="{{ route('publikasi.berita.show', $berita) }}">
                            <img src="{{ $imageUrl }}" alt="{{ $berita->judul }}">
                        </a>
                        <div class="buletin-card-body">
                            <p class="buletin-card-date">
                                <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                {{ $berita->created_at ? $berita->created_at->locale('id')->translatedFormat('d F Y') : '-' }}
                            </p>
                            <h2><a href="{{ route('publikasi.berita.show', $berita) }}">{{ $berita->judul }}</a></h2>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($berita->deskripsi), 155) }}</p>
                            <a class="buletin-card-link" href="{{ route('publikasi.berita.show', $berita) }}">
                                Selengkapnya
                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="buletin-empty">
                        <h2>Belum ada berita.</h2>
                        <p>Konten berita akan tampil setelah ditambahkan dari halaman admin.</p>
                    </div>
                @endforelse
            </div>

            @if ($beritas->hasPages())
                <div class="buletin-pagination">
                    {{ $beritas->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>
@endsection

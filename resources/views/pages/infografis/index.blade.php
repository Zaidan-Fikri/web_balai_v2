@extends('master.app')

@section('title', 'Infografis - Balai Air Tanah')

@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Infografis'])

    <section class="buletin-list-section">
        <div class="container">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <span class="bc-current">Infografis</span>
            </nav>
            <div class="buletin-card-grid">
                @forelse ($infografisItems as $infografis)
                    @php
                        $firstImage = $infografis->images->first();
                        $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : asset('assets/images/placeholders/publikasi.svg');
                    @endphp
                    <article class="buletin-card infografis-list-card">
                        <a class="buletin-card-image" href="{{ $imageUrl }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ $imageUrl }}" alt="{{ $infografis->judul }}">
                        </a>
                        <div class="buletin-card-body">
                            <p class="buletin-card-date">
                                <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                {{ $infografis->created_at ? $infografis->created_at->locale('id')->translatedFormat('d F Y') : '-' }}
                            </p>
                            <h2><a href="{{ $imageUrl }}" target="_blank" rel="noopener noreferrer">{{ $infografis->judul }}</a></h2>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($infografis->deskripsi), 155) }}</p>
                            <a class="buletin-card-link" href="{{ $imageUrl }}" target="_blank" rel="noopener noreferrer">
                                Lihat Infografis
                                <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="buletin-empty">
                        <h2>Belum ada infografis.</h2>
                        <p>Konten infografis akan tampil setelah ditambahkan dari halaman admin.</p>
                    </div>
                @endforelse
            </div>

            @if ($infografisItems->hasPages())
                <div class="buletin-pagination">
                    {{ $infografisItems->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>
@endsection

@extends('master.app')

@section('title', 'Infografis - Balai Air Tanah')

@section('content')
    <section class="public-buletin-hero">
        <div class="public-buletin-hero-inner">
            <p>Publikasi</p>
            <h1>Infografis</h1>
            <nav aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <span>Infografis</span>
            </nav>
        </div>
    </section>

    <section class="public-buletin-section">
        <div class="public-buletin-grid">
            @forelse ($infografisItems as $infografis)
                @php
                    $firstImage = $infografis->images->first();
                    $imageUrl = $firstImage ? asset('storage/' . $firstImage->image_path) : asset('assets/images/placeholders/publikasi.svg');
                @endphp
                <article class="public-buletin-card">
                    <div class="buletin-card-image">
                        <img src="{{ $imageUrl }}" alt="{{ $infografis->judul }}">
                    </div>
                    <div class="public-buletin-card-body">
                        <p class="public-buletin-date">{{ $infografis->created_at ? $infografis->created_at->locale('id')->translatedFormat('d F Y') : '-' }}</p>
                        <h2>{{ $infografis->judul }}</h2>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($infografis->deskripsi), 150) }}</p>
                    </div>
                </article>
            @empty
                <div class="public-buletin-empty">
                    <h2>Belum ada infografis.</h2>
                    <p>Konten infografis akan tampil setelah dipublikasikan dari CMS.</p>
                </div>
            @endforelse
        </div>

        @if ($infografisItems->hasPages())
            <div class="buletin-pagination">
                {{ $infografisItems->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </section>
@endsection

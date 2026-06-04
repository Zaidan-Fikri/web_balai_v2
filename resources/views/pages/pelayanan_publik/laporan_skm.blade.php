@extends('master.app')

@section('title', 'Laporan SKM - Balai Air Tanah')

@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Laporan SKM'])

    <section class="buletin-list-section">
        <div class="container">
            <div class="buletin-card-grid skm-report-grid">
                @forelse ($laporanSkms as $laporan)
                    @php
                        $thumbnailUrl = $laporan->thumbnail_path ? asset('storage/' . $laporan->thumbnail_path) : asset('assets/images/placeholders/publikasi.svg');
                        $pdfUrl = asset('storage/' . $laporan->pdf_path);
                    @endphp
                    <article class="buletin-card skm-report-card">
                        <a class="buletin-card-image" href="{{ $pdfUrl }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ $thumbnailUrl }}" alt="{{ $laporan->judul }}">
                        </a>
                        <div class="buletin-card-body">
                            <p class="buletin-card-date">
                                <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                                {{ $laporan->created_at ? $laporan->created_at->locale('id')->translatedFormat('d F Y') : '-' }}
                            </p>
                            <h2><a href="{{ $pdfUrl }}" target="_blank" rel="noopener noreferrer">{{ $laporan->judul }}</a></h2>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($laporan->deskripsi), 155) }}</p>
                            <a class="buletin-card-link" href="{{ $pdfUrl }}" target="_blank" rel="noopener noreferrer">
                                Buka Laporan
                                <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="buletin-empty">
                        <h2>Belum ada laporan SKM.</h2>
                        <p>Dokumen laporan akan ditampilkan setelah tersedia dari halaman admin.</p>
                    </div>
                @endforelse
            </div>

            @if ($laporanSkms->hasPages())
                <div class="buletin-pagination">
                    {{ $laporanSkms->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>
@endsection

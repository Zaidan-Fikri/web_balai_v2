@extends('master.app')

@section('title', 'Pencarian - Balai Air Tanah')

@section('content')
<section class="search-page-section">
    <div class="search-page-wrap">
        <div class="search-page-heading">
            <p class="content-page-kicker">Pencarian</p>
            <h1>Hasil Pencarian</h1>
            <form class="search-page-form" action="{{ route('search') }}" method="GET" role="search">
                <label class="visually-hidden" for="searchPageInput">Cari</label>
                <input
                    id="searchPageInput"
                    type="search"
                    name="q"
                    value="{{ $query }}"
                    placeholder="Cari..."
                    autocomplete="off"
                >
                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <span>Cari</span>
                </button>
            </form>
        </div>

        @if ($query === '')
            <div class="search-empty-state">
                <h2>Masukkan kata kunci</h2>
                <p>Ketik kata kunci untuk mencari halaman, berita, dan buletin.</p>
            </div>
        @elseif ($results->isEmpty())
            <div class="search-empty-state">
                <h2>Tidak ada hasil</h2>
                <p>Tidak ditemukan konten untuk kata kunci "{{ $query }}".</p>
            </div>
        @else
            <div class="search-result-summary">
                Ditemukan {{ $results->count() }} hasil untuk "{{ $query }}".
            </div>

            <div class="search-results-list">
                @foreach ($results as $result)
                    <a class="search-result-item" href="{{ $result['url'] }}">
                        <span class="search-result-meta">{{ $result['category'] }} / {{ $result['type'] }}</span>
                        <strong>{{ $result['title'] }}</strong>
                        <span>{{ $result['excerpt'] }}</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection

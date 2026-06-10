@extends('master.app')

@section('title', 'Galeri Video - Balai Air Tanah')

@push('styles')
<style>
    .galeri-video-section {
        padding: 64px 0 96px;
        background: #f4f7fb;
    }

    /* Grid */
    .galeri-video-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    /* Card */
    .galeri-video-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,30,80,.08);
        cursor: pointer;
        transition: transform .25s ease, box-shadow .25s ease;
        display: flex;
        flex-direction: column;
    }
    .galeri-video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 14px 36px rgba(0,30,80,.16);
    }

    /* Thumbnail */
    .galeri-video-thumb {
        position: relative;
        aspect-ratio: 16 / 9;
        background: #061d3f;
        overflow: hidden;
        flex-shrink: 0;
    }
    .galeri-video-thumb img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .4s ease;
    }
    .galeri-video-card:hover .galeri-video-thumb img {
        transform: scale(1.06);
    }

    /* Play button overlay */
    .galeri-video-play-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(4,18,44,.32);
        transition: background .25s;
    }
    .galeri-video-card:hover .galeri-video-play-overlay {
        background: rgba(4,18,44,.52);
    }
    .galeri-video-play-btn {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: rgba(255,255,255,.92);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #061d3f;
        font-size: 1.1rem;
        box-shadow: 0 4px 20px rgba(0,0,0,.3);
        transition: transform .2s, background .2s;
        padding-left: 3px;
    }
    .galeri-video-card:hover .galeri-video-play-btn {
        transform: scale(1.12);
        background: #fff;
    }

    /* Duration badge */
    .galeri-video-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(4,18,44,.82);
        color: #fff;
        font-size: .65rem;
        font-weight: 800;
        letter-spacing: .08em;
        padding: 3px 10px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Category badge top-left */
    .galeri-video-cat-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0,0,0,.45);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        color: #fff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 999px;
        border: 1px solid rgba(255,255,255,.15);
    }

    /* Card body */
    .galeri-video-body {
        padding: 14px 16px 18px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .galeri-video-category {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #b86200;
        margin: 0 0 5px;
    }
    .galeri-video-judul {
        margin: 0 0 6px;
        font-size: .95rem;
        font-weight: 800;
        color: #0a1f44;
        line-height: 1.3;
    }
    .galeri-video-desc {
        margin: 0;
        font-size: .82rem;
        color: #666;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Empty state */
    .galeri-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
    }
    .galeri-empty h2 { font-size: 1.4rem; color: #0a1f44; margin-bottom: 8px; }
    .galeri-empty p  { color: #666; font-size: .95rem; }

    /* Filter bar */
    .galeri-filter-bar {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 32px;
    }
    .galeri-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: 999px;
        border: 1.5px solid rgba(0,51,153,.18);
        background: #fff;
        color: #444;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: background .18s, border-color .18s, color .18s, transform .18s;
        white-space: nowrap;
    }
    .galeri-filter-btn:hover {
        background: #e8eeff;
        border-color: rgba(0,71,204,.35);
        color: #0047cc;
        transform: translateY(-1px);
        text-decoration: none;
    }
    .galeri-filter-btn.active {
        background: #0047cc;
        border-color: #0047cc;
        color: #fff;
    }
    .galeri-filter-btn.active:hover {
        background: #0039a8;
        border-color: #0039a8;
        transform: translateY(-1px);
    }

    /* Pagination */
    .galeri-pagination {
        margin-top: 48px;
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 900px) { .galeri-video-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px) {
        .galeri-video-grid { grid-template-columns: 1fr; gap: 16px; }
        .galeri-video-section { padding: 40px 0 64px; }
    }

    /* ══════════════════════════════════════
       VIDEO LIGHTBOX
    ══════════════════════════════════════ */
    .vlb-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 16px;
        background: rgba(4,12,32,.82);
        backdrop-filter: blur(10px) saturate(120%);
        -webkit-backdrop-filter: blur(10px) saturate(120%);
        opacity: 0;
        pointer-events: none;
        transition: opacity .28s ease;
    }
    .vlb-overlay.is-open {
        opacity: 1;
        pointer-events: all;
    }

    .vlb-dialog {
        position: relative;
        width: 100%;
        max-width: min(900px, 94vw);
        background: #0a1628;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 28px 80px rgba(0,0,0,.6);
        animation: vlb-in .28s ease;
    }
    @keyframes vlb-in {
        from { transform: scale(.93); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }

    /* Portrait wrapper */
    .vlb-dialog.is-portrait {
        max-width: min(420px, 94vw);
    }

    .vlb-video-wrap {
        position: relative;
        width: 100%;
        background: #000;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .vlb-video-wrap.landscape { aspect-ratio: 16/9; }
    .vlb-video-wrap.portrait  { min-height: 480px; }

    .vlb-video-wrap video {
        width: 100%;
        height: 100%;
        display: block;
    }
    .vlb-video-wrap.portrait video {
        height: min(72vh, 560px);
        width: auto;
        max-width: 100%;
    }

    .vlb-footer {
        padding: 16px 20px 18px;
        background: #0a1628;
    }
    .vlb-category {
        font-size: .65rem;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #f4b000;
        margin: 0 0 4px;
    }
    .vlb-title {
        font-size: 1rem;
        font-weight: 900;
        color: #fff;
        margin: 0 0 4px;
        line-height: 1.3;
    }
    .vlb-desc {
        font-size: .82rem;
        color: rgba(255,255,255,.6);
        margin: 0;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .vlb-close {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 10;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,.15);
        border: 1px solid rgba(255,255,255,.25);
        color: #fff;
        font-size: .9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background .2s;
    }
    .vlb-close:hover { background: rgba(255,255,255,.3); }
</style>
@endpush

@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Galeri Video'])

    <section class="galeri-video-section">
        <div class="container">

            {{-- Filter bar --}}
            <div class="galeri-filter-bar">
                <a href="{{ route('publikasi.galeri.video') }}"
                   class="galeri-filter-btn {{ is_null($kategori) ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group fa-xs"></i> Semua
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('publikasi.galeri.video', ['kategori' => $cat]) }}"
                       class="galeri-filter-btn {{ $kategori === $cat ? 'active' : '' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            @if ($videos->isEmpty())
                <div class="galeri-video-grid">
                    <div class="galeri-empty">
                        <h2>Belum ada video.</h2>
                        <p>Video akan tampil setelah ditambahkan dari halaman admin.</p>
                    </div>
                </div>
            @else
                <div class="galeri-video-grid">
                    @foreach ($videos as $video)
                        @php
                            $thumbUrl = $video->image_url ?: null;
                            $videoUrl = asset('storage/' . $video->video_path);
                        @endphp
                        <div class="galeri-video-card js-vlb-trigger"
                             data-video-url="{{ $videoUrl }}"
                             data-judul="{{ $video->judul }}"
                             data-deskripsi="{{ $video->deskripsi ?? '' }}"
                             data-kategori="{{ $video->kategori ?? '' }}">

                            <div class="galeri-video-thumb">
                                @if ($thumbUrl)
                                    <img src="{{ $thumbUrl }}" alt="{{ $video->judul }}" loading="lazy">
                                @endif
                                @if ($video->kategori)
                                    <span class="galeri-video-cat-badge">{{ $video->kategori }}</span>
                                @endif
                                <div class="galeri-video-play-overlay">
                                    <div class="galeri-video-play-btn">
                                        <i class="fa-solid fa-play"></i>
                                    </div>
                                </div>
                                <span class="galeri-video-badge">
                                    <i class="fa-solid fa-film fa-xs"></i> VIDEO
                                </span>
                            </div>

                            <div class="galeri-video-body">
                                <h2 class="galeri-video-judul">{{ $video->judul }}</h2>
                                @if ($video->deskripsi)
                                    <p class="galeri-video-desc">{{ $video->deskripsi }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($videos->hasPages())
                    <div class="galeri-pagination">
                        {{ $videos->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @endif

        </div>
    </section>

    {{-- Video Lightbox --}}
    <div class="vlb-overlay" id="vlbOverlay" role="dialog" aria-modal="true" aria-label="Putar video" aria-hidden="true">
        <div class="vlb-dialog" id="vlbDialog">
            <button type="button" class="vlb-close" id="vlbClose" aria-label="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="vlb-video-wrap landscape" id="vlbVideoWrap">
                <video id="vlbVideoEl" controls preload="metadata"></video>
            </div>
            <div class="vlb-footer">
                <p class="vlb-title" id="vlbTitle"></p>
                <p class="vlb-desc" id="vlbDesc"></p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function () {
    var overlay  = document.getElementById('vlbOverlay');
    var dialog   = document.getElementById('vlbDialog');
    var videoEl  = document.getElementById('vlbVideoEl');
    var videoWrap = document.getElementById('vlbVideoWrap');
    var closeBtn = document.getElementById('vlbClose');
    var titleEl  = document.getElementById('vlbTitle');
    var descEl   = document.getElementById('vlbDesc');

    if (!overlay) return;

    function openLightbox(data) {
        videoEl.src = data.videoUrl;
        titleEl.textContent  = data.judul || '';
        descEl.textContent   = data.deskripsi || '';
        descEl.style.display = data.deskripsi ? '' : 'none';

        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        videoEl.play().catch(function(){});
    }

    function closeLightbox() {
        videoEl.pause();
        videoEl.src = '';
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    document.querySelectorAll('.js-vlb-trigger').forEach(function (card) {
        card.addEventListener('click', function () {
            openLightbox({
                videoUrl  : card.dataset.videoUrl  || '',
                judul     : card.dataset.judul     || '',
                deskripsi : card.dataset.deskripsi || '',
                kategori  : card.dataset.kategori  || '',
            });
        });
    });

    closeBtn.addEventListener('click', closeLightbox);

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeLightbox();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeLightbox();
    });
})();
</script>
@endpush

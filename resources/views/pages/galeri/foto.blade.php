@extends('master.app')

@section('title', 'Galeri Foto - Balai Air Tanah')

@push('styles')
<style>
    /* ── section wrapper ── */
    .galeri-foto-section {
        padding: 64px 0 96px;
        background: #f4f7fb;
    }

    /* ── grid ── */
    .galeri-foto-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    /* ── card ── */
    .galeri-foto-card {
        position: relative;
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0,30,80,.08);
        cursor: pointer;
        transition: transform .25s ease, box-shadow .25s ease;
    }
    .galeri-foto-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 32px rgba(0,30,80,.16);
    }

    /* ── thumbnail ── */
    .galeri-foto-thumb {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: #0d2d5e;
    }
    .galeri-foto-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .45s ease;
    }
    .galeri-foto-card:hover .galeri-foto-thumb img {
        transform: scale(1.08);
    }

    /* ── hover overlay ── */
    .galeri-foto-hover {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(5,20,60,.72) 0%, rgba(5,20,60,.1) 55%, transparent 100%);
        opacity: 0;
        transition: opacity .3s ease;
        display: flex;
        align-items: flex-end;
        padding: 18px;
    }
    .galeri-foto-card:hover .galeri-foto-hover {
        opacity: 1;
    }
    .galeri-foto-hover-icon {
        width: 38px;
        height: 38px;
        background: rgba(255,255,255,.18);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 14px;
        margin-left: auto;
        border: 1px solid rgba(255,255,255,.3);
    }

    /* ── badge ── */
    .galeri-foto-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0,0,0,.42);
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

    /* ── card body ── */
    .galeri-foto-body {
        padding: 14px 16px 18px;
    }
    .galeri-foto-category {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #0047cc;
        margin: 0 0 5px;
    }
    .galeri-foto-judul {
        margin: 0 0 7px;
        font-size: .98rem;
        font-weight: 800;
        color: #0a1f44;
        line-height: 1.3;
    }
    .galeri-foto-desc {
        margin: 0;
        font-size: .82rem;
        color: #666;
        line-height: 1.55;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ── empty state ── */
    .galeri-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
    }
    .galeri-empty h2 { font-size: 1.4rem; color: #0a1f44; margin-bottom: 8px; }
    .galeri-empty p  { color: #666; font-size: .95rem; }

    /* ── pagination ── */
    .galeri-pagination {
        margin-top: 48px;
        display: flex;
        justify-content: center;
    }

    /* ── responsive ── */
    @media (max-width: 900px)  { .galeri-foto-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 900px)  { .galeri-foto-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px)  { .galeri-foto-grid { grid-template-columns: 1fr; gap: 14px; }
                                  .galeri-foto-section { padding: 40px 0 64px; } }

    /* ── filter bar ── */
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

    /* ══════════════════════════════════════
       LIGHTBOX
    ══════════════════════════════════════ */
    .lb-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 20px;
        background: rgba(9, 22, 48, .68);
        backdrop-filter: blur(9px) saturate(115%);
        -webkit-backdrop-filter: blur(9px) saturate(115%);
        opacity: 0;
        pointer-events: none;
        transition: opacity .28s ease;
    }
    .lb-overlay.is-open {
        opacity: 1;
        pointer-events: all;
    }

    .lb-dialog {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: min(980px, 92vw);
        width: 100%;
        padding: 10px;
        border: 1px solid rgba(255,255,255,.2);
        border-radius: 20px;
        background: linear-gradient(180deg, rgba(255,255,255,.98), rgba(241,246,255,.96));
        box-shadow: 0 28px 80px rgba(1, 13, 38, .34);
        animation: lb-in .3s ease;
    }
    @keyframes lb-in {
        from { transform: scale(.93); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }

    .lb-content {
        width: 100%;
        display: block;
        overflow: hidden;
        border-radius: 14px;
        background: #fff;
    }

    .lb-img-wrap {
        width: 100%;
        min-height: 360px;
        max-height: 62vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #e9eef8;
        cursor: grab;
        touch-action: pan-y;
        user-select: none;
    }
    .lb-img-wrap.is-dragging { cursor: grabbing; }
    .lb-img-wrap img {
        max-width: 100%;
        max-height: 62vh;
        object-fit: contain;
        display: block;
        pointer-events: none;
        user-select: none;
    }

    .lb-caption {
        width: 100%;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 16px;
        align-items: start;
        text-align: left;
        color: #0a1f44;
        padding: 16px 18px;
        background: #fff;
        border-top: 1px solid #e4eaf5;
    }
    .lb-caption-category {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #0047cc;
        margin-bottom: 4px;
    }
    .lb-caption-title {
        font-size: 1.18rem;
        font-weight: 800;
        color: #0a1f44;
        margin: 0 0 10px;
        line-height: 1.35;
    }
    .lb-caption-desc {
        font-size: .94rem;
        color: #344054;
        margin: 0;
        line-height: 1.65;
        max-height: 90px;
        overflow-y: auto;
        padding-right: 6px;
    }

    /* counter */
    .lb-counter {
        display: inline-flex;
        align-items: center;
        align-self: flex-start;
        min-height: 30px;
        padding: 7px 11px;
        border-radius: 999px;
        background: #eef4ff;
        font-size: .75rem;
        font-weight: 700;
        color: #0047cc;
        margin: 0;
        letter-spacing: .06em;
        white-space: nowrap;
        justify-self: start;
        align-self: start;
    }
    .lb-thumbs {
        width: 100%;
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding: 10px 4px 2px;
        scrollbar-width: thin;
    }
    .lb-thumb {
        width: 54px;
        height: 42px;
        flex: 0 0 auto;
        padding: 0;
        border: 2px solid transparent;
        border-radius: 8px;
        background: #dbe5f6;
        overflow: hidden;
        cursor: pointer;
        opacity: .68;
        transition: opacity .18s ease, border-color .18s ease, transform .18s ease;
    }
    .lb-thumb:hover,
    .lb-thumb.is-active {
        opacity: 1;
        border-color: #0047cc;
        transform: translateY(-1px);
    }
    .lb-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* close */
    .lb-close {
        position: absolute;
        top: -16px;
        right: -16px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        border: 2px solid #fff;
        background: #0a1f44;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s;
        z-index: 10000;
    }
    .lb-close:hover { background: #0047cc; }

    /* nav arrows */
    .lb-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 1px solid rgba(10,31,68,.14);
        background: rgba(255,255,255,.92);
        color: #0a1f44;
        font-size: 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background .2s;
        z-index: 10000;
        box-shadow: 0 10px 28px rgba(10, 31, 68, .18);
    }
    .lb-nav:hover { background: #fff; }
    .lb-prev { left: -20px; }
    .lb-next { right: -20px; }
    .lb-nav:disabled { opacity: .25; cursor: default; }

    @media (max-width: 600px) {
        .lb-nav { display: none; }
        .lb-overlay { padding: 18px 14px; }
        .lb-dialog { max-width: 94vw; padding: 8px; }
        .lb-img-wrap { min-height: 0; max-height: 44vh; border-radius: 12px 12px 0 0; }
        .lb-img-wrap img { max-height: 44vh; }
        .lb-caption { grid-template-columns: 1fr; gap: 10px; padding: 12px; text-align: left; }
        .lb-caption-desc { max-height: 120px; }
        .lb-counter { text-align: left; }
        .lb-thumbs { justify-content: flex-start; padding: 2px 10px 10px; }
        .lb-close { top: -12px; right: -10px; }
    }
</style>
@endpush

@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Galeri Foto'])

    <section class="galeri-foto-section">
        <div class="container">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <span class="bc-current">Galeri Foto</span>
            </nav>
                {{-- Filter bar --}}
            <div class="galeri-filter-bar">
                <a href="{{ route('publikasi.galeri.foto') }}"
                   class="galeri-filter-btn {{ is_null($kategori) ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group fa-xs"></i> Semua
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('publikasi.galeri.foto', ['kategori' => $cat]) }}"
                       class="galeri-filter-btn {{ $kategori === $cat ? 'active' : '' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

        <div class="galeri-foto-grid">
                @forelse ($fotos as $index => $foto)
                    @php
                        $allImages = collect([$foto->image_url])
                            ->merge($foto->images->map(fn($i) => $i->image_url))
                            ->filter()
                            ->values();
                    @endphp
                    <article class="galeri-foto-card"
                        data-lb-index="{{ $index }}"
                        data-lb-src="{{ $foto->image_url }}"
                        data-lb-images="{{ json_encode($allImages) }}"
                        data-lb-title="{{ $foto->judul }}"
                        data-lb-desc="{{ $foto->deskripsi ?? '' }}"
                        role="button"
                        tabindex="0"
                        aria-label="Lihat foto {{ $foto->judul }}">
                        <div class="galeri-foto-thumb"
                            @if($foto->background_color) style="background:{{ $foto->background_color }}" @endif>
                            <img src="{{ $foto->image_url }}" alt="{{ $foto->judul }}"
                                loading="lazy" decoding="async">
                            <span class="galeri-foto-badge">
                                <i class="fa-solid fa-camera fa-xs"></i>&nbsp;{{ $foto->kategori ?: 'Foto' }}
                                @if($allImages->count() > 1)
                                    &nbsp;· {{ $allImages->count() }}
                                @endif
                            </span>
                            <div class="galeri-foto-hover">
                                <span class="galeri-foto-hover-icon">
                                    <i class="fa-solid fa-expand"></i>
                                </span>
                            </div>
                        </div>
                        <div class="galeri-foto-body">
                            <h2 class="galeri-foto-judul">{{ $foto->judul }}</h2>
                            @if ($foto->deskripsi)
                                <p class="galeri-foto-desc">{{ $foto->deskripsi }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="galeri-empty">
                        <h2>Belum ada foto.</h2>
                        <p>Foto akan tampil setelah ditambahkan dari halaman admin.</p>
                    </div>
                @endforelse
            </div>

            @if ($fotos->hasPages())
                <div class="galeri-pagination">
                    {{ $fotos->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>

    {{-- Lightbox --}}
    <div class="lb-overlay" id="lbOverlay" role="dialog" aria-modal="true" aria-label="Lihat foto">
        <div class="lb-dialog">
            <button class="lb-close" id="lbClose" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
            <button class="lb-nav lb-prev" id="lbPrev" aria-label="Foto sebelumnya"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="lb-nav lb-next" id="lbNext" aria-label="Foto berikutnya"><i class="fa-solid fa-chevron-right"></i></button>
            <div class="lb-content">
                <div class="lb-img-wrap">
                    <img id="lbImg" src="" alt="">
                </div>
                <div class="lb-caption">
                    <div>
                        <p class="lb-caption-title" id="lbTitle"></p>
                        <p class="lb-caption-desc" id="lbDesc"></p>
                    </div>
                    <p class="lb-counter" id="lbCounter"></p>
                </div>
            </div>
            <div class="lb-thumbs" id="lbThumbs" aria-label="Daftar foto"></div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function () {
    var cards = Array.from(document.querySelectorAll('.galeri-foto-card[data-lb-src]'));
    if (!cards.length) return;

    var overlay  = document.getElementById('lbOverlay');
    var lbImg    = document.getElementById('lbImg');
    var lbTitle  = document.getElementById('lbTitle');
    var lbDesc   = document.getElementById('lbDesc');
    var lbCounter= document.getElementById('lbCounter');
    var lbClose  = document.getElementById('lbClose');
    var lbPrev   = document.getElementById('lbPrev');
    var lbNext   = document.getElementById('lbNext');
    var lbImgWrap= document.querySelector('.lb-img-wrap');
    var lbThumbs = document.getElementById('lbThumbs');

    var images  = [];   /* array of URLs for current entry */
    var imgIdx  = 0;    /* current photo index within entry */
    var title   = '';
    var desc    = '';

    function open(card) {
        try { images = JSON.parse(card.dataset.lbImages || '[]'); } catch(e) { images = []; }
        if (!images.length) images = [card.dataset.lbSrc];
        imgIdx = 0;
        title  = card.dataset.lbTitle || '';
        desc   = card.dataset.lbDesc  || '';
        renderThumbs();
        render();
        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        lbClose.focus();
    }

    function close() {
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    function render() {
        lbImg.src = images[imgIdx] || '';
        lbImg.alt = title;
        lbTitle.textContent  = title;
        lbDesc.textContent   = desc;
        lbDesc.style.display = desc ? '' : 'none';
        if (images.length > 1) {
            lbCounter.textContent = 'Foto ' + (imgIdx + 1) + ' dari ' + images.length;
            lbCounter.style.display = '';
        } else {
            lbCounter.style.display = 'none';
        }
        lbPrev.disabled = imgIdx === 0;
        lbNext.disabled = imgIdx === images.length - 1;
        lbPrev.style.display = images.length > 1 ? '' : 'none';
        lbNext.style.display = images.length > 1 ? '' : 'none';
        if (lbThumbs) {
            Array.from(lbThumbs.querySelectorAll('.lb-thumb')).forEach(function (thumb, index) {
                thumb.classList.toggle('is-active', index === imgIdx);
            });
            var activeThumb = lbThumbs.querySelector('.lb-thumb.is-active');
            if (activeThumb) activeThumb.scrollIntoView({ inline: 'center', block: 'nearest' });
        }
    }

    function renderThumbs() {
        if (!lbThumbs) return;
        lbThumbs.innerHTML = '';
        lbThumbs.style.display = images.length > 1 ? '' : 'none';
        images.forEach(function (src, index) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'lb-thumb';
            btn.setAttribute('aria-label', 'Lihat foto ' + (index + 1));
            var img = document.createElement('img');
            img.src = src;
            img.alt = '';
            btn.addEventListener('click', function () {
                imgIdx = index;
                render();
            });
            btn.appendChild(img);
            lbThumbs.appendChild(btn);
        });
    }

    function prev() { if (imgIdx > 0) { imgIdx--; render(); } }
    function next() { if (imgIdx < images.length - 1) { imgIdx++; render(); } }

    cards.forEach(function (card) {
        card.addEventListener('click', function () { open(card); });
        card.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(card); }
        });
    });

    lbClose.addEventListener('click', close);
    lbPrev.addEventListener('click', prev);
    lbNext.addEventListener('click', next);

    overlay.addEventListener('click', function (e) { if (e.target === overlay) close(); });

    document.addEventListener('keydown', function (e) {
        if (!overlay.classList.contains('is-open')) return;
        if (e.key === 'Escape')      close();
        if (e.key === 'ArrowLeft')   prev();
        if (e.key === 'ArrowRight')  next();
    });

    var touchStartX = 0;
    overlay.addEventListener('touchstart', function (e) { touchStartX = e.changedTouches[0].clientX; }, { passive: true });
    overlay.addEventListener('touchend', function (e) {
        var dx = e.changedTouches[0].clientX - touchStartX;
        if (Math.abs(dx) > 50) { dx < 0 ? next() : prev(); }
    }, { passive: true });

    var dragStartX = 0;
    var isDragging = false;

    if (lbImgWrap) {
        lbImgWrap.addEventListener('pointerdown', function (e) {
            if (!overlay.classList.contains('is-open') || images.length < 2) return;
            if (e.pointerType === 'touch') return;
            isDragging = true;
            dragStartX = e.clientX;
            lbImgWrap.classList.add('is-dragging');
            lbImgWrap.setPointerCapture(e.pointerId);
        });

        lbImgWrap.addEventListener('pointerup', function (e) {
            if (!isDragging) return;
            var dx = e.clientX - dragStartX;
            isDragging = false;
            lbImgWrap.classList.remove('is-dragging');
            if (Math.abs(dx) > 50) { dx < 0 ? next() : prev(); }
        });

        lbImgWrap.addEventListener('pointercancel', function () {
            isDragging = false;
            lbImgWrap.classList.remove('is-dragging');
        });
    }
})();
</script>
@endpush

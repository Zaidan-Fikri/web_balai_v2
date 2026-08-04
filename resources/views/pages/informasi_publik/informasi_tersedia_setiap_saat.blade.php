@extends('master.app')

@section('title', 'Informasi Tersedia Setiap Saat - Balai Air Tanah')

@push('styles')
<style>
.ib-section { padding: 56px 0 80px; background: #f4f6f9; }
.ib-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(10,38,71,.08);
    overflow: hidden;
    border-top: 4px solid;
    border-image: linear-gradient(90deg,#1a6bcc,#27a69a,#8bc34a,#f0b429) 1;
}
.ib-card-title {
    padding: 20px 28px 16px;
    font-size: 1.05rem;
    font-weight: 700;
    color: #1e2d4e;
    border-bottom: 2px solid #e8edf4;
    background: #f8fafc;
}
.ib-card-body { padding: 24px 28px 28px; }
.ib-accordion { border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 12px; overflow: hidden; }
.ib-accordion-header { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; font-size: 1rem; font-weight: 700; color: #1e2d4e; cursor: pointer; background: #f8fafc; user-select: none; list-style: none; transition: background .15s; }
.ib-accordion-header::-webkit-details-marker { display: none; }
.ib-accordion-header:hover { background: #eef4ff; }
.ib-accordion[open] .ib-accordion-header { background: #e9f0fd; color: var(--bat-primary); }
.ib-accordion-caret { width: 20px; height: 20px; transition: transform .25s; color: var(--bat-primary); flex-shrink: 0; }
.ib-accordion[open] .ib-accordion-caret { transform: rotate(180deg); }
.ib-accordion-body { padding: 0 20px 16px; }
.ib-file-list { list-style: none; margin: 0; padding: 0; }
.ib-file-item { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border-radius: 6px; transition: background .15s; }
.ib-file-item:hover { background: #f4f7fe; }
.ib-file-icon { font-size: 1.25rem; color: #e53e3e; flex-shrink: 0; }
.ib-file-name { flex: 1; font-size: .92rem; color: #2d3748; font-weight: 500; }
.ib-file-actions { display: flex; gap: 8px; flex-shrink: 0; }
.ib-btn { display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px; border-radius: 6px; font-size: .82rem; font-weight: 600; cursor: pointer; border: none; transition: opacity .15s, transform .1s; text-decoration: none; }
.ib-btn:hover { opacity: .85; transform: translateY(-1px); }
.ib-btn-view { background: var(--bat-primary); color: #fff; }
.ib-empty { padding: 40px 0; text-align: center; color: #8a97b0; font-size: .95rem; }

/* FLIPBOOK MODAL */
.fb-modal { position: fixed; inset: 0; z-index: 9000; display: none; align-items: center; justify-content: center; padding: 16px; }
.fb-modal.is-open { display: flex; }
.fb-backdrop { position: absolute; inset: 0; background: rgba(4,10,24,.92); backdrop-filter: blur(8px); }
.fb-dialog { position: relative; z-index: 1; background: #111827; border: 1px solid rgba(255,255,255,.08); border-radius: 18px; display: flex; flex-direction: column; width: fit-content; max-width: 97vw; max-height: 97vh; box-shadow: 0 40px 120px rgba(0,0,0,.8); overflow: hidden; }
.fb-header { display: flex; align-items: center; gap: 12px; padding: 12px 18px; background: #0d1424; border-bottom: 1px solid rgba(255,255,255,.07); flex-shrink: 0; }
.fb-header-icon { color: #60a5fa; font-size: .95rem; flex-shrink: 0; }
.fb-header h5 { margin: 0; flex: 1; color: #e2e8f0; font-size: .9rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.fb-close-btn { width: 30px; height: 30px; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.12); border-radius: 50%; color: #94a3b8; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background .15s, color .15s; flex-shrink: 0; }
.fb-close-btn:hover { background: rgba(239,68,68,.2); color: #fca5a5; border-color: rgba(239,68,68,.3); }
.fb-body { flex: 1; display: flex; flex-direction: column; align-items: center; background: radial-gradient(ellipse at top,#1a2540 0%,#0d1220 100%); padding: 16px 16px 0; overflow-y: auto; overflow-x: auto; min-height: 200px; }
.fb-book-scroll { overflow: auto; max-height: calc(97vh - 160px); max-width: calc(97vw - 48px); flex-shrink: 0; border-radius: 6px; }
.fb-book-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
.fb-book-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.18); border-radius: 3px; }
#fb-book-zoom { display: inline-block; transform-origin: top left; transition: transform .2s; border-radius: 4px; box-shadow: 0 12px 40px rgba(0,0,0,.6); }
#fb-container { position: relative; }
.fb-loading { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 16px; padding: 48px 24px; color: #94a3b8; font-size: .92rem; min-width: 280px; }
.fb-spinner { width: 40px; height: 40px; border: 3px solid rgba(255,255,255,.1); border-top-color: #60a5fa; border-radius: 50%; animation: fb-spin .7s linear infinite; }
@keyframes fb-spin { to { transform: rotate(360deg); } }
.fb-error { color: #f87171; text-align: center; padding: 8px; }
.fb-viewer { display: none; flex-direction: column; align-items: center; gap: 12px; }
.fb-controls-wrap { padding: 10px 0 14px; flex-shrink: 0; }
.fb-controls { display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1); border-radius: 999px; padding: 6px 16px; }
.fb-nav-btn, .fb-zoom-btn { background: none; border: none; color: #94a3b8; font-size: .9rem; cursor: pointer; padding: 2px 6px; border-radius: 4px; transition: color .15s, background .15s; }
.fb-nav-btn:hover, .fb-zoom-btn:hover { color: #e2e8f0; background: rgba(255,255,255,.08); }
.fb-page-info, .fb-zoom-label { color: #cbd5e1; font-size: .82rem; min-width: 52px; text-align: center; }
.fb-ctrl-sep { width: 1px; height: 18px; background: rgba(255,255,255,.12); margin: 0 2px; }
</style>
@endpush

@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Informasi Publik', 'pageTitle' => 'Informasi Tersedia Setiap Saat'])

    <section class="ib-section">
        <div class="container">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <a href="#">Informasi Publik</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <span class="bc-current">Informasi Tersedia Setiap Saat</span>
            </nav>
            <div class="ip-layout">
                @include('pages.partials.sidebar_informasi_publik')
                <div class="ip-content">
                    <div class="ib-card">
                        <div class="ib-card-title">
                            <i class="fa-regular fa-file-pdf" style="color:#e53e3e;margin-right:8px;"></i>
                            Informasi Tersedia Setiap Saat
                        </div>
                        <div class="ib-card-body">
                            @forelse ($items as $tahun => $files)
                                <details class="ib-accordion" {{ $loop->first ? 'open' : '' }}>
                                    <summary class="ib-accordion-header">
                                        <span>{{ $tahun }}</span>
                                        <svg class="ib-accordion-caret" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </summary>
                                    <div class="ib-accordion-body">
                                        <ul class="ib-file-list">
                                            @foreach ($files as $file)
                                                <li class="ib-file-item">
                                                    <i class="fa-regular fa-file-pdf ib-file-icon" aria-hidden="true"></i>
                                                    <span class="ib-file-name">{{ $file->judul }}</span>
                                                    <div class="ib-file-actions">
                                                        <button type="button" class="ib-btn ib-btn-view js-open-flipbook"
                                                            data-url="{{ asset('storage/' . $file->pdf_path) }}"
                                                            data-title="{{ $file->judul }}">
                                                            <i class="fa-regular fa-book-open" aria-hidden="true"></i> Lihat
                                                        </button>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </details>
                            @empty
                                <div class="ib-empty">
                                    <i class="fa-regular fa-folder-open" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
                                    Belum ada dokumen informasi tersedia setiap saat.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>{{-- ip-content --}}
            </div>{{-- ip-layout --}}
        </div>
    </section>

    {{-- FLIPBOOK MODAL --}}
    <div id="fb-modal" class="fb-modal" role="dialog" aria-modal="true" aria-labelledby="fb-title">
        <div class="fb-backdrop" id="fb-backdrop"></div>
        <div class="fb-dialog">
            <div class="fb-header">
                <i class="fa-regular fa-file-pdf fb-header-icon" aria-hidden="true"></i>
                <h5 id="fb-title"></h5>
                <button class="fb-close-btn" id="fb-close" aria-label="Tutup">&times;</button>
            </div>
            <div class="fb-body">
                <div id="fb-loading" class="fb-loading">
                    <div class="fb-spinner"></div>
                    <p>Memuat dokumen, harap tunggu…</p>
                </div>
                <div id="fb-viewer" class="fb-viewer">
                    <div class="fb-book-scroll">
                        <div id="fb-book-zoom">
                            <div id="fb-container"></div>
                        </div>
                    </div>
                    <div class="fb-controls-wrap">
                        <div class="fb-controls">
                            <button class="fb-nav-btn" id="fb-prev" aria-label="Halaman sebelumnya">&#9664;</button>
                            <span class="fb-page-info" id="fb-page-info">1 / 1</span>
                            <button class="fb-nav-btn" id="fb-next" aria-label="Halaman berikutnya">&#9654;</button>
                            <div class="fb-ctrl-sep"></div>
                            <button class="fb-zoom-btn" id="fb-zoom-out" title="Perkecil">&#8722;</button>
                            <span class="fb-zoom-label" id="fb-zoom-label">100%</span>
                            <button class="fb-zoom-btn" id="fb-zoom-in" title="Perbesar">&#43;</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/page-flip/dist/js/page-flip.browser.js" crossorigin="anonymous"></script>
<script>
(function () {
    if (typeof pdfjsLib === 'undefined') {
        document.querySelectorAll('.js-open-flipbook').forEach(function (btn) {
            btn.addEventListener('click', function () { alert('Library PDF gagal dimuat. Periksa koneksi internet Anda.'); });
        });
        return;
    }
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    function addWatermark(canvas) {
        var ctx = canvas.getContext('2d'), w = canvas.width, h = canvas.height;
        var fontSize = Math.max(Math.floor(w / 14), 20);
        ctx.save();
        ctx.font = 'bold ' + fontSize + 'px Arial, sans-serif';
        ctx.fillStyle = '#1a3a6e'; ctx.globalAlpha = 0.10; ctx.textAlign = 'center';
        var stepX = w / 2, stepY = h / 3;
        for (var xi = 0; xi <= 2; xi++) {
            for (var yi = 0; yi <= 3; yi++) {
                ctx.save(); ctx.translate(stepX * (xi + 0.5), stepY * (yi + 0.5));
                ctx.rotate(-Math.PI / 6); ctx.fillText('BALAI AIR TANAH', 0, 0); ctx.restore();
            }
        }
        ctx.restore();
    }

    function loadJsPDF(cb) {
        if (window.jspdf) { cb(); return; }
        var s = document.createElement('script');
        s.src = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
        s.onload = cb; document.head.appendChild(s);
    }


    var currentPageFlip = null, currentRenderTask = null, openToken = 0, currentZoom = 1, zoomStep = 0.25;
    var modal = document.getElementById('fb-modal');
    var loadingEl = document.getElementById('fb-loading'), viewerEl = document.getElementById('fb-viewer');
    var titleEl = document.getElementById('fb-title'), containerEl = document.getElementById('fb-container');
    var bookZoomEl = document.getElementById('fb-book-zoom');
    var pageInfoEl = document.getElementById('fb-page-info'), zoomLabelEl = document.getElementById('fb-zoom-label');

    function applyZoom(z) {
        currentZoom = Math.max(0.5, Math.min(4, z));
        bookZoomEl.style.transform = 'scale(' + currentZoom + ')';
        bookZoomEl.style.transformOrigin = 'top left';
        var raw = bookZoomEl.firstElementChild;
        if (raw) {
            bookZoomEl.style.width  = parseFloat(raw.style.width  || 0) * currentZoom + 'px';
            bookZoomEl.style.height = parseFloat(raw.style.height || 0) * currentZoom + 'px';
        }
        zoomLabelEl.textContent = Math.round(currentZoom * 100) + '%';
    }
    function resetZoom() { applyZoom(1); }
    function updatePageInfo() {
        if (!currentPageFlip) return;
        pageInfoEl.textContent = (currentPageFlip.getCurrentPageIndex() + 1) + ' / ' + currentPageFlip.getPageCount();
    }
    function showLoading() { loadingEl.style.display = 'flex'; loadingEl.innerHTML = '<div class="fb-spinner"></div><p>Memuat dokumen, harap tunggu…</p>'; viewerEl.style.display = 'none'; }
    function showError(msg) { loadingEl.style.display = 'flex'; loadingEl.innerHTML = '<p class="fb-error">' + (msg || 'Gagal memuat dokumen PDF.') + '</p>'; viewerEl.style.display = 'none'; }

    function destroyFlipbook() {
        openToken++;
        if (currentRenderTask) { try { currentRenderTask.cancel(); } catch (e) {} currentRenderTask = null; }
        if (currentPageFlip) { try { currentPageFlip.destroy(); } catch (e) {} currentPageFlip = null; }
        var fresh = document.createElement('div'); fresh.id = 'fb-container';
        bookZoomEl.innerHTML = ''; bookZoomEl.appendChild(fresh); bookZoomEl.removeAttribute('style');
        containerEl = fresh;
    }

    async function openFlipbook(pdfUrl, title) {
        titleEl.textContent = title; showLoading();
        modal.classList.add('is-open'); document.body.style.overflow = 'hidden';
        destroyFlipbook(); resetZoom();
        var myToken = openToken;
        try {
            if (typeof St === 'undefined' || !St.PageFlip) { showError('Library flipbook gagal dimuat. Silakan muat ulang halaman.'); return; }
            var pdf;
            try { pdf = await pdfjsLib.getDocument({ url: pdfUrl, withCredentials: false }).promise; } catch (le) { if (myToken !== openToken) return; throw le; }
            if (myToken !== openToken) return;
            var numPages = pdf.numPages;
            var firstPage = await pdf.getPage(1);
            if (myToken !== openToken) return;
            var nativeVP = firstPage.getViewport({ scale: 1 });
            var availW = window.innerWidth - 48, availH = window.innerHeight - 160;
            var fitScale = Math.min(availW / nativeVP.width, availH / nativeVP.height);
            var pageW = Math.floor(nativeVP.width * fitScale), pageH = Math.floor(nativeVP.height * fitScale);
            var dpr = Math.min(Math.max(window.devicePixelRatio || 1, 2), 3);
            var renderScale = fitScale * dpr;
            var images = [];
            for (var i = 1; i <= numPages; i++) {
                if (myToken !== openToken) return;
                loadingEl.innerHTML = '<div class="fb-spinner"></div><p>Memuat halaman ' + i + ' / ' + numPages + '…</p>';
                var page;
                try { page = await pdf.getPage(i); } catch (e) { if (myToken !== openToken) return; throw e; }
                if (myToken !== openToken) return;
                var vp = page.getViewport({ scale: renderScale });
                var canvas = document.createElement('canvas');
                canvas.width = Math.round(vp.width); canvas.height = Math.round(vp.height);
                var renderTask = page.render({ canvasContext: canvas.getContext('2d'), viewport: vp });
                currentRenderTask = renderTask;
                try { await renderTask.promise; } catch (re) { if (myToken !== openToken) return; throw re; }
                currentRenderTask = null;
                if (myToken !== openToken) return;
                var ctx2 = canvas.getContext('2d');
                ctx2.globalCompositeOperation = 'destination-over';
                ctx2.fillStyle = '#ffffff'; ctx2.fillRect(0, 0, canvas.width, canvas.height);
                ctx2.globalCompositeOperation = 'source-over';
                addWatermark(canvas);
                images.push(canvas.toDataURL('image/jpeg', 0.92));
            }
            if (myToken !== openToken) return;
            containerEl.style.width = pageW + 'px'; containerEl.style.height = pageH + 'px'; containerEl.style.position = 'relative';
            bookZoomEl.style.width = pageW + 'px'; bookZoomEl.style.height = pageH + 'px'; bookZoomEl.style.transform = 'scale(1)';
            loadingEl.style.display = 'none'; viewerEl.style.display = 'flex';
            await new Promise(function (r) { requestAnimationFrame(r); });
            if (myToken !== openToken) return;
            currentPageFlip = new St.PageFlip(containerEl, { width: pageW, height: pageH, size: 'fixed', drawShadow: true, flippingTime: 700, usePortrait: true, showCover: false, mobileScrollSupport: false, autoSize: false });
            currentPageFlip.loadFromImages(images);
            currentPageFlip.on('flip', updatePageInfo);
            updatePageInfo();
        } catch (err) {
            if (myToken !== openToken) return;
            showError('Gagal memuat dokumen PDF. Pastikan file tersedia.');
        }
    }

    function closeFlipbook() {
        modal.classList.remove('is-open'); document.body.style.overflow = '';
        destroyFlipbook(); loadingEl.style.display = 'none'; viewerEl.style.display = 'none'; resetZoom();
    }

    document.getElementById('fb-prev').addEventListener('click', function () { if (currentPageFlip) currentPageFlip.flipPrev(); });
    document.getElementById('fb-next').addEventListener('click', function () { if (currentPageFlip) currentPageFlip.flipNext(); });
    document.getElementById('fb-zoom-in').addEventListener('click', function () { applyZoom(currentZoom + zoomStep); });
    document.getElementById('fb-zoom-out').addEventListener('click', function () { applyZoom(currentZoom - zoomStep); });
    document.getElementById('fb-close').addEventListener('click', closeFlipbook);
    document.getElementById('fb-backdrop').addEventListener('click', closeFlipbook);
    document.addEventListener('keydown', function (e) {
        if (!modal.classList.contains('is-open')) return;
        if (e.key === 'Escape') closeFlipbook();
        if (e.key === 'ArrowLeft'  && currentPageFlip) currentPageFlip.flipPrev();
        if (e.key === 'ArrowRight' && currentPageFlip) currentPageFlip.flipNext();
        if (e.key === '+' || e.key === '=') applyZoom(currentZoom + zoomStep);
        if (e.key === '-') applyZoom(currentZoom - zoomStep);
    });
    document.querySelectorAll('.js-open-flipbook').forEach(function (btn) {
        btn.addEventListener('click', function () { openFlipbook(btn.dataset.url, btn.dataset.title); });
    });
}());
</script>
@endpush

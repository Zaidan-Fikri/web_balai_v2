@extends('master.app')

@section('title', 'Informasi Berkala - Balai Air Tanah')

@push('styles')
<style>
/* ── Layout ─────────────────────────────────────────── */
.ib-section { padding: 56px 0 80px; background: #f4f6f9; }
.ib-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(10,38,71,.08);
    overflow: hidden;
    border-top: 4px solid;
    border-image: linear-gradient(90deg,#1a6bcc,#27a69a,#8bc34a,#f0b429) 1;
}

/* ── Tabs ────────────────────────────────────────────── */
.ib-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 0;
    border-bottom: 2px solid #e8edf4;
    background: #f8fafc;
}
.ib-tab {
    flex: 1 1 auto;
    padding: 14px 20px;
    font-size: .93rem;
    font-weight: 600;
    color: #6b7a99;
    background: none;
    border: none;
    border-bottom: 3px solid transparent;
    cursor: pointer;
    transition: color .2s, border-color .2s, background .2s;
    text-align: center;
    white-space: nowrap;
}
.ib-tab:hover { color: var(--bat-primary); background: #eef4ff; }
.ib-tab.active { color: var(--bat-primary); border-bottom-color: var(--bat-primary); background: #fff; }

/* ── Tab Content ─────────────────────────────────────── */
.ib-tab-content { display: none; padding: 28px 32px 32px; }
.ib-tab-content.active { display: block; }

/* ── Accordion ───────────────────────────────────────── */
.ib-accordion {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    margin-bottom: 12px;
    overflow: hidden;
}
.ib-accordion-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    font-size: 1rem;
    font-weight: 700;
    color: #1e2d4e;
    cursor: pointer;
    background: #f8fafc;
    user-select: none;
    list-style: none;
    transition: background .15s;
}
.ib-accordion-header::-webkit-details-marker { display: none; }
.ib-accordion-header:hover { background: #eef4ff; }
.ib-accordion[open] .ib-accordion-header { background: #e9f0fd; color: var(--bat-primary); }
.ib-accordion-caret {
    width: 20px; height: 20px;
    transition: transform .25s;
    color: var(--bat-primary);
    flex-shrink: 0;
}
.ib-accordion[open] .ib-accordion-caret { transform: rotate(180deg); }

/* ── File List ───────────────────────────────────────── */
.ib-accordion-body { padding: 0 20px 16px; }
.ib-file-list { list-style: none; margin: 0; padding: 0; }
.ib-file-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 6px;
    transition: background .15s;
}
.ib-file-item:hover { background: #f4f7fe; }
.ib-file-icon { font-size: 1.25rem; color: #e53e3e; flex-shrink: 0; }
.ib-file-name { flex: 1; font-size: .92rem; color: #2d3748; font-weight: 500; }
.ib-file-actions { display: flex; gap: 8px; flex-shrink: 0; }
.ib-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    border: none;
    transition: opacity .15s, transform .1s;
    text-decoration: none;
}
.ib-btn:hover { opacity: .85; transform: translateY(-1px); }
.ib-btn-view { background: var(--bat-primary); color: #fff; }

/* ── Empty State ─────────────────────────────────────── */
.ib-empty { padding: 40px 0; text-align: center; color: #8a97b0; font-size: .95rem; }

/* ══════════════════════════════════════════════════════
   FLIPBOOK MODAL
══════════════════════════════════════════════════════ */
.fb-modal {
    position: fixed; inset: 0; z-index: 9000;
    display: none;
    align-items: center; justify-content: center;
    padding: 16px;
}
.fb-modal.is-open { display: flex; }
.fb-backdrop {
    position: absolute; inset: 0;
    background: rgba(4, 10, 24, 0.92);
    backdrop-filter: blur(8px);
}

/* Dialog */
.fb-dialog {
    position: relative; z-index: 1;
    background: #111827;
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 18px;
    display: flex; flex-direction: column;
    width: fit-content;
    max-width: 97vw; max-height: 97vh;
    box-shadow: 0 40px 120px rgba(0,0,0,.8), 0 0 0 1px rgba(99,179,237,.06);
    overflow: hidden;
}

/* Header */
.fb-header {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 18px;
    background: #0d1424;
    border-bottom: 1px solid rgba(255,255,255,.07);
    flex-shrink: 0;
}
.fb-header-icon { color: #60a5fa; font-size: .95rem; flex-shrink: 0; }
.fb-header h5 {
    margin: 0; flex: 1;
    color: #e2e8f0; font-size: .9rem; font-weight: 600;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.fb-close-btn {
    width: 30px; height: 30px;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 50%;
    color: #94a3b8; font-size: 1rem;
    cursor: pointer; line-height: 1;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s, color .15s;
    flex-shrink: 0;
}
.fb-close-btn:hover { background: rgba(239,68,68,.2); color: #fca5a5; border-color: rgba(239,68,68,.3); }

/* Reading area */
.fb-body {
    flex: 1;
    display: flex; flex-direction: column;
    align-items: center;
    gap: 0;
    background: radial-gradient(ellipse at top, #1a2540 0%, #0d1220 100%);
    padding: 16px 16px 0;
    overflow-y: auto;
    overflow-x: auto;
    min-height: 200px;
}

/* Book scroll area */
.fb-book-scroll {
    overflow: auto;
    max-height: calc(97vh - 160px);
    max-width: calc(97vw - 48px);
    flex-shrink: 0;
    border-radius: 6px;
}
.fb-book-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
.fb-book-scroll::-webkit-scrollbar-track { background: rgba(255,255,255,.04); border-radius: 3px; }
.fb-book-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.18); border-radius: 3px; }

/* Zoom wrapper — provides the page shadow */
#fb-book-zoom {
    display: inline-block;
    transform-origin: top left;
    transition: transform .2s cubic-bezier(.4,0,.2,1);
    border-radius: 4px;
    box-shadow:
        0 2px 6px rgba(0,0,0,.4),
        0 12px 40px rgba(0,0,0,.6),
        0 0 0 1px rgba(255,255,255,.04);
}
#fb-container { position: relative; }

/* Loading */
.fb-loading {
    display: flex; flex-direction: column;
    align-items: center; gap: 16px;
    color: #94a3b8; font-size: .88rem;
    padding: 48px 0;
}
.fb-spinner {
    width: 44px; height: 44px;
    border: 3px solid rgba(99,179,237,.15);
    border-top-color: #60a5fa;
    border-radius: 50%;
    animation: fb-spin .75s linear infinite;
}
@keyframes fb-spin { to { transform: rotate(360deg); } }
.fb-error { color: #f87171; font-size: .9rem; }

/* Viewer */
.fb-viewer {
    display: none;
    flex-direction: column;
    align-items: center;
    position: relative;
}

/* Controls floating bar — overlay di atas buku */
.fb-controls-wrap {
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    justify-content: center;
    z-index: 9100;
    pointer-events: none;
}
.fb-controls-wrap .fb-controls {
    pointer-events: all;
}
.fb-controls {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 50px;
    padding: 6px 12px;
    backdrop-filter: blur(16px);
    box-shadow: 0 4px 24px rgba(0,0,0,.4);
}
.fb-nav-btn {
    background: none; border: none;
    color: #cbd5e1;
    width: 34px; height: 34px;
    border-radius: 50%;
    font-size: .9rem;
    cursor: pointer;
    transition: background .15s, color .15s;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.fb-nav-btn:hover { background: rgba(255,255,255,.12); color: #fff; }
.fb-page-info {
    color: #94a3b8; font-size: .82rem; font-weight: 600;
    min-width: 52px; text-align: center;
    padding: 0 4px;
}
.fb-ctrl-sep {
    width: 1px; height: 20px;
    background: rgba(255,255,255,.13);
    margin: 0 4px;
    flex-shrink: 0;
}
.fb-zoom-btn {
    background: none; border: none;
    color: #94a3b8;
    width: 30px; height: 30px;
    border-radius: 50%;
    font-size: 1rem; font-weight: 700;
    cursor: pointer;
    transition: background .15s, color .15s;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    line-height: 1;
}
.fb-zoom-btn:hover { background: rgba(255,255,255,.12); color: #fff; }
.fb-zoom-label {
    color: #64748b; font-size: .78rem; font-weight: 700;
    min-width: 38px; text-align: center;
    letter-spacing: .02em;
}

@media (max-width: 600px) {
    .ib-tab-content { padding: 18px 16px 24px; }
    .ib-tab { font-size: .82rem; padding: 11px 12px; }
    .ib-file-item { flex-wrap: wrap; }
    .ib-file-name { width: 100%; }
    .ib-file-actions { width: 100%; }
    .fb-dialog { border-radius: 10px; }
    .fb-body { padding: 16px 12px 0; }
}
</style>
@endpush

@section('content')
    @include('pages.partials.menu_detail_hero', ['menuGroup' => 'Informasi Publik', 'pageTitle' => 'Informasi Berkala'])

    <section class="ib-section">
        <div class="container">
            <nav class="page-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}"><i class="fa-solid fa-house fa-xs"></i> Beranda</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <a href="#">Informasi Publik</a>
                <span class="bc-sep"><i class="fa-solid fa-chevron-right fa-xs"></i></span>
                <span class="bc-current">Informasi Berkala</span>
            </nav>
            <div class="ip-layout">
            @include('pages.partials.sidebar_informasi_publik')
            <div class="ip-content">
            <div class="ib-card">

                {{-- Tabs --}}
                <div class="ib-tabs" role="tablist">
                    @foreach ($kategoriList as $key => $label)
                        <button
                            role="tab"
                            class="ib-tab {{ $loop->first ? 'active' : '' }}"
                            data-tab="{{ $key }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        >{{ $label }}</button>
                    @endforeach
                </div>

                {{-- Tab Contents --}}
                @foreach ($kategoriList as $key => $label)
                    <div class="ib-tab-content {{ $loop->first ? 'active' : '' }}" id="tab-{{ $key }}">
                        @if (isset($data[$key]) && $data[$key]->isNotEmpty())
                            @php $byYear = $data[$key]->groupBy('tahun'); @endphp
                            @foreach ($byYear as $year => $files)
                                <details class="ib-accordion" {{ $loop->first ? 'open' : '' }}>
                                    <summary class="ib-accordion-header">
                                        <span>{{ $year }}</span>
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
                                                        <button
                                                            type="button"
                                                            class="ib-btn ib-btn-view js-open-flipbook"
                                                            data-url="{{ asset('storage/' . $file->pdf_path) }}"
                                                            data-title="{{ $file->judul }}"
                                                        >
                                                            <i class="fa-regular fa-book-open" aria-hidden="true"></i>
                                                            Lihat
                                                        </button>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </details>
                            @endforeach
                        @else
                            <div class="ib-empty">
                                <i class="fa-regular fa-folder-open" style="font-size:2rem;display:block;margin-bottom:10px;"></i>
                                Belum ada dokumen tersedia untuk kategori ini.
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>
            </div>{{-- ip-content --}}
            </div>{{-- ip-layout --}}
        </div>
    </section>

    {{-- ══════════ FLIPBOOK MODAL ══════════ --}}
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
{{-- PDF.js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- StPageFlip --}}
<script src="https://unpkg.com/page-flip/dist/js/page-flip.browser.js" crossorigin="anonymous"></script>

<script>
(function () {
    /* ── Tab switching ─────────────────────────── */
    document.querySelectorAll('.ib-tab').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.ib-tab').forEach(function (t) {
                t.classList.remove('active');
                t.setAttribute('aria-selected', 'false');
            });
            document.querySelectorAll('.ib-tab-content').forEach(function (c) {
                c.classList.remove('active');
            });
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');
            var target = document.getElementById('tab-' + btn.dataset.tab);
            if (target) target.classList.add('active');
        });
    });

    /* ── Flipbook ──────────────────────────────── */
    if (typeof pdfjsLib === 'undefined') {
        document.querySelectorAll('.js-open-flipbook').forEach(function (btn) {
            btn.addEventListener('click', function () { alert('Library PDF gagal dimuat. Periksa koneksi internet Anda.'); });
        });
        return;
    }
    pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    /* ── Watermark ───────────────────────────── */
    function addWatermark(canvas) {
        var ctx  = canvas.getContext('2d');
        var w    = canvas.width;
        var h    = canvas.height;
        var text = 'BALAI AIR TANAH';
        var fontSize = Math.max(Math.floor(w / 14), 20);

        ctx.save();
        ctx.font        = 'bold ' + fontSize + 'px Arial, sans-serif';
        ctx.fillStyle   = '#1a3a6e';
        ctx.globalAlpha = 0.10;
        ctx.textAlign   = 'center';

        var stepX = w  / 2;
        var stepY = h  / 3;
        for (var xi = 0; xi <= 2; xi++) {
            for (var yi = 0; yi <= 3; yi++) {
                ctx.save();
                ctx.translate(stepX * (xi + 0.5), stepY * (yi + 0.5));
                ctx.rotate(-Math.PI / 6);
                ctx.fillText(text, 0, 0);
                ctx.restore();
            }
        }
        ctx.restore();
    }

    /* ── Watermark download via jsPDF ───────── */
    function loadJsPDF(cb) {
        if (window.jspdf) { cb(); return; }
        var s    = document.createElement('script');
        s.src    = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
        s.onload = cb;
        document.head.appendChild(s);
    }


    var currentPageFlip   = null;
    var currentRenderTask = null;
    var openToken         = 0;
    var currentZoom       = 1;
    var zoomStep          = 0.25;

    var modal        = document.getElementById('fb-modal');
    var loadingEl    = document.getElementById('fb-loading');
    var viewerEl     = document.getElementById('fb-viewer');
    var titleEl      = document.getElementById('fb-title');
    var containerEl  = document.getElementById('fb-container');
    var bookZoomEl   = document.getElementById('fb-book-zoom');
    var pageInfoEl   = document.getElementById('fb-page-info');
    var zoomLabelEl  = document.getElementById('fb-zoom-label');

    /* ── Zoom ────────────────────────────────── */
    function applyZoom(z) {
        currentZoom    = Math.max(0.5, Math.min(4, z));
        bookZoomEl.style.transform       = 'scale(' + currentZoom + ')';
        bookZoomEl.style.transformOrigin = 'top left';
        /* Paksa scroll wrapper mengikuti ukuran yang sudah di-scale */
        var raw = bookZoomEl.firstElementChild;
        if (raw) {
            var w = parseFloat(raw.style.width  || 0) * currentZoom;
            var h = parseFloat(raw.style.height || 0) * currentZoom;
            bookZoomEl.style.width  = w + 'px';
            bookZoomEl.style.height = h + 'px';
        }
        zoomLabelEl.textContent = Math.round(currentZoom * 100) + '%';
    }

    function resetZoom() { applyZoom(1); }

    function preloadFlipbookImages(images) {
        return Promise.all(images.map(function (src) {
            return new Promise(function (resolve, reject) {
                var img = new Image();
                img.onload = resolve;
                img.onerror = reject;
                img.src = src;
            });
        }));
    }

    /* ── Page info ───────────────────────────── */
    function updatePageInfo() {
        if (!currentPageFlip) return;
        var current = currentPageFlip.getCurrentPageIndex() + 1;
        var total   = currentPageFlip.getPageCount();
        pageInfoEl.textContent = current + ' / ' + total;
    }

    function showLoading() {
        loadingEl.style.display = 'flex';
        loadingEl.innerHTML     = '<div class="fb-spinner"></div><p>Memuat dokumen, harap tunggu…</p>';
        viewerEl.style.display  = 'none';
    }

    function showError(msg) {
        loadingEl.style.display = 'flex';
        loadingEl.innerHTML     = '<p class="fb-error">' + (msg || 'Gagal memuat dokumen PDF.') + '</p>';
        viewerEl.style.display  = 'none';
    }

    function destroyFlipbook() {
        openToken++;
        if (currentRenderTask) {
            try { currentRenderTask.cancel(); } catch (e) {}
            currentRenderTask = null;
        }
        if (currentPageFlip) {
            try { currentPageFlip.destroy(); } catch (e) {}
            currentPageFlip = null;
        }
        var fresh = document.createElement('div');
        fresh.id = 'fb-container';
        bookZoomEl.innerHTML = '';
        bookZoomEl.appendChild(fresh);
        bookZoomEl.removeAttribute('style');
        containerEl = fresh;
    }

    async function openFlipbook(pdfUrl, title) {
        titleEl.textContent = title;
        showLoading();
        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        destroyFlipbook(); /* juga menaikkan openToken */
        resetZoom();
        var myToken = openToken; /* token sesi ini */

        try {
            if (typeof St === 'undefined' || !St.PageFlip) {
                showError('Library flipbook gagal dimuat. Silakan muat ulang halaman.');
                return;
            }

            var pdf;
            try { pdf = await pdfjsLib.getDocument({ url: pdfUrl, withCredentials: false }).promise; } catch (le) {
                if (myToken !== openToken) return;
                throw le;
            }
            if (myToken !== openToken) return;
            var numPages = pdf.numPages;

            /* Ukuran slot dari halaman pertama */
            var firstPage   = await pdf.getPage(1);
            if (myToken !== openToken) return;
            var nativeVP    = firstPage.getViewport({ scale: 1 });
            var availW      = window.innerWidth  - 48;
            var availH      = window.innerHeight - 160;
            var fitScale    = Math.min(availW / nativeVP.width, availH / nativeVP.height);
            var pageW       = Math.floor(nativeVP.width  * fitScale);
            var pageH       = Math.floor(nativeVP.height * fitScale);
            var dpr         = Math.min(Math.max(window.devicePixelRatio || 1, 2), 3);
            var renderScale = fitScale * dpr;

            /* Render semua halaman — satu canvas per halaman */
            var images = [];
            for (var i = 1; i <= numPages; i++) {
                if (myToken !== openToken) return;
                loadingEl.innerHTML = '<div class="fb-spinner"></div><p>Memuat halaman ' + i + ' / ' + numPages + '…</p>';

                var page;
                try { page = await pdf.getPage(i); } catch (e) {
                    if (myToken !== openToken) return;
                    throw e;
                }
                if (myToken !== openToken) return;

                var vp     = page.getViewport({ scale: renderScale });
                var canvas = document.createElement('canvas');
                canvas.width  = Math.round(vp.width);
                canvas.height = Math.round(vp.height);

                var renderTask    = page.render({ canvasContext: canvas.getContext('2d'), viewport: vp });
                currentRenderTask = renderTask;
                try {
                    await renderTask.promise;
                } catch (re) {
                    if (myToken !== openToken) return;
                    throw re;
                }
                currentRenderTask = null;
                if (myToken !== openToken) return;

                /* isi latar putih di balik konten (destination-over) agar JPEG tidak hitam */
                var ctx2 = canvas.getContext('2d');
                ctx2.globalCompositeOperation = 'destination-over';
                ctx2.fillStyle = '#ffffff';
                ctx2.fillRect(0, 0, canvas.width, canvas.height);
                ctx2.globalCompositeOperation = 'source-over';

                addWatermark(canvas);
                images.push(canvas.toDataURL('image/jpeg', 0.92));
            }

            if (myToken !== openToken) return;
            await preloadFlipbookImages(images);
            if (myToken !== openToken) return;

            var bookW = pageW;
            containerEl.style.width    = bookW + 'px';
            containerEl.style.height   = pageH + 'px';
            containerEl.style.position = 'relative';

            bookZoomEl.style.width     = bookW + 'px';
            bookZoomEl.style.height    = pageH + 'px';
            bookZoomEl.style.transform = 'scale(1)';

            loadingEl.style.display = 'none';
            viewerEl.style.display  = 'flex';
            await new Promise(function (resolve) { requestAnimationFrame(resolve); });

            if (myToken !== openToken) return;

            currentPageFlip = new St.PageFlip(containerEl, {
                width:               pageW,
                height:              pageH,
                size:                'fixed',
                drawShadow:          true,
                flippingTime:        700,
                usePortrait:         true,
                showCover:           false,
                mobileScrollSupport: false,
                autoSize:            false,
            });

            currentPageFlip.loadFromImages(images);
            currentPageFlip.on('flip', updatePageInfo);
            updatePageInfo();

        } catch (err) {
            if (myToken !== openToken) return;
            showError('Gagal memuat dokumen PDF. Pastikan file tersedia.');
        }
    }

    function closeFlipbook() {
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
        destroyFlipbook();
        loadingEl.style.display = 'none';
        viewerEl.style.display  = 'none';
        resetZoom();
    }

    /* ── Event listeners ─────────────────────── */
    document.getElementById('fb-prev').addEventListener('click', function () {
        if (currentPageFlip) currentPageFlip.flipPrev();
    });
    document.getElementById('fb-next').addEventListener('click', function () {
        if (currentPageFlip) currentPageFlip.flipNext();
    });
    document.getElementById('fb-zoom-in').addEventListener('click', function () {
        applyZoom(currentZoom + zoomStep);
    });
    document.getElementById('fb-zoom-out').addEventListener('click', function () {
        applyZoom(currentZoom - zoomStep);
    });
    document.getElementById('fb-close').addEventListener('click', closeFlipbook);
    document.getElementById('fb-backdrop').addEventListener('click', closeFlipbook);
    document.addEventListener('keydown', function (e) {
        if (!modal.classList.contains('is-open')) return;
        if (e.key === 'Escape')      closeFlipbook();
        if (e.key === 'ArrowLeft'  && currentPageFlip) currentPageFlip.flipPrev();
        if (e.key === 'ArrowRight' && currentPageFlip) currentPageFlip.flipNext();
        if (e.key === '+' || e.key === '=') applyZoom(currentZoom + zoomStep);
        if (e.key === '-')                  applyZoom(currentZoom - zoomStep);
    });

    document.querySelectorAll('.js-open-flipbook').forEach(function (btn) {
        btn.addEventListener('click', function () {
            openFlipbook(btn.dataset.url, btn.dataset.title);
        });
    });

}());
</script>
@endpush

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Indonesia - Balai Air Tanah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Manrope:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}">
    @vite(['resources/css/map.css'])
</head>
<body>
    <div class="map-shell">

        {{-- Scrim (mobile backdrop) --}}
        <div class="map-filter-scrim" id="mapFilterScrim" aria-hidden="true"></div>

        {{-- Filter Sidebar --}}
        <aside class="map-filter-sidebar" id="mapFilterSidebar" aria-label="Filter Peta">
            <div class="map-filter-header">
                <span><i class="fa-solid fa-layer-group" aria-hidden="true"></i> Filter</span>
                <button type="button" class="map-filter-close" id="mapFilterClose" aria-label="Tutup sidebar">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            {{-- Tab bar --}}
            <div class="map-filter-tabs">
                <button type="button" class="map-filter-tab is-active" data-tab="tipe">
                    <i class="fa-solid fa-database" aria-hidden="true"></i> Tipe Data
                </button>
                <button type="button" class="map-filter-tab" data-tab="wilayah">
                    <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i> Wilayah
                </button>
            </div>

            {{-- Panel: Tipe Data --}}
            <div class="map-filter-panel is-active" id="mapPanelTipe">
                <div class="map-type-actions">
                    <button type="button" class="map-type-action-btn" id="mapTypeSelectAll">Pilih Semua</button>
                    <button type="button" class="map-type-action-btn" id="mapTypeClearAll">Hapus Semua</button>
                </div>
                <div class="map-type-list">
                    <label class="map-type-item is-checked">
                        <input type="checkbox" class="map-type-filter" value="geolistrik1d" checked>
                        <span class="map-type-dot" style="background:#0047cc"></span>
                        <span class="map-type-label">Geolistrik 1D</span>
                        <span class="map-type-toggle"></span>
                    </label>
                    <label class="map-type-item is-checked">
                        <input type="checkbox" class="map-type-filter" value="geolistrik2d" checked>
                        <span class="map-type-dot" style="background:#e74c3c"></span>
                        <span class="map-type-label">Geolistrik 2D</span>
                        <span class="map-type-toggle"></span>
                    </label>
                    <label class="map-type-item is-checked">
                        <input type="checkbox" class="map-type-filter" value="pumpingTest" checked>
                        <span class="map-type-dot" style="background:#27ae60"></span>
                        <span class="map-type-label">Pumping Test</span>
                        <span class="map-type-toggle"></span>
                    </label>
                    <label class="map-type-item is-checked">
                        <input type="checkbox" class="map-type-filter" value="boreholeCamera" checked>
                        <span class="map-type-dot" style="background:#f39c12"></span>
                        <span class="map-type-label">Borehole Camera</span>
                        <span class="map-type-toggle"></span>
                    </label>
                    <label class="map-type-item is-checked">
                        <input type="checkbox" class="map-type-filter" value="logging" checked>
                        <span class="map-type-dot" style="background:#9b59b6"></span>
                        <span class="map-type-label">Logging</span>
                        <span class="map-type-toggle"></span>
                    </label>
                </div>
                {{-- Basemap langsung di bawah Logging --}}
                <div class="map-basemap-list" id="mapBasemapList"></div>
            </div>

            {{-- Panel: Wilayah --}}
            <div class="map-filter-panel" id="mapPanelWilayah">
                {{-- Search --}}
                <div class="map-search-wrap">
                    <i class="fa-solid fa-magnifying-glass map-search-icon" aria-hidden="true"></i>
                    <input type="search" class="map-search-input" id="mapSearchInput"
                           placeholder="Cari kode, lokasi..." autocomplete="off" spellcheck="false">
                    <ul class="map-search-results" id="mapSearchResults" hidden></ul>
                </div>

                <div class="map-filter-actions">
                    <button type="button" class="map-filter-action-btn" id="mapFilterSelectAll">Pilih Semua</button>
                    <button type="button" class="map-filter-action-btn" id="mapFilterClearAll">Hapus Semua</button>
                </div>
                <div class="map-filter-groups">
                    @foreach ($allBalai as $group)
                        <details class="map-filter-group">
                            <summary class="map-filter-group-label">
                                <i class="fa-solid fa-chevron-right map-filter-caret" aria-hidden="true"></i>
                                <i class="fa-solid {{ $group['icon'] }} map-filter-region-icon" aria-hidden="true"></i>
                                <span>{{ $group['label'] }}</span>
                            </summary>
                            @foreach ($group['items'] as $balai)
                                <label class="map-filter-item">
                                    <input type="checkbox" class="map-upt-filter" value="{{ $balai['name'] }}" checked>
                                    <span>{{ $balai['short'] }}</span>
                                </label>
                            @endforeach
                        </details>
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- Detail panel --}}
        <aside class="map-info-panel" id="geolistrikInfoPanel" aria-live="polite">

            {{-- Header --}}
            <div class="map-detail-header">
                <div class="map-detail-header-top">
                    <span class="map-detail-badge" id="mapDetailBadge">
                        <i class="fa-solid fa-wave-square" aria-hidden="true"></i>
                        Geolistrik 1D
                    </span>
                    <button type="button" class="map-info-close" id="geolistrikInfoClose" aria-label="Tutup detail">
                        <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                    </button>
                </div>
                <h2 class="map-detail-title" id="mapDetailTitle">—</h2>
            </div>

            {{-- Scrollable body --}}
            <div class="map-detail-body">

                {{-- PDF preview --}}
                <div class="map-info-preview" id="geolistrikPdfPreview"></div>

                {{-- Lokasi --}}
                <div class="map-detail-section">
                    <div class="map-detail-section-head">
                        <i class="fa-solid fa-location-dot" aria-hidden="true"></i> Lokasi
                    </div>
                    <div class="map-detail-table">
                        <div><span>Kab/Kota</span><strong data-field="kabKota">—</strong></div>
                        <div><span>Kecamatan</span><strong data-field="kecamatan">—</strong></div>
                        <div><span>Desa/Kelurahan</span><strong data-field="desaKelurahan">—</strong></div>
                        <div><span>Koordinat</span><strong id="mapDetailCoords">—</strong></div>
                        <div><span>Elevasi</span><strong data-field="elevasi">—</strong></div>
                    </div>
                </div>

                {{-- UPT --}}
                <div class="map-detail-section">
                    <div class="map-detail-section-head">
                        <i class="fa-solid fa-building-columns" aria-hidden="true"></i> UPT
                    </div>
                    <div class="map-detail-table">
                        <div><span>Balai</span><strong data-field="upt">—</strong></div>
                    </div>
                </div>

                {{-- Data Teknis --}}
                <div class="map-detail-section">
                    <div class="map-detail-section-head">
                        <i class="fa-solid fa-chart-line" aria-hidden="true"></i> Data Teknis
                    </div>
                    <div class="map-detail-table">
                        <div><span>Tanggal Akuisisi</span><strong data-field="tanggalAkusisiData">—</strong></div>
                        <div><span>Geologi</span><strong data-field="geologi">—</strong></div>
                        <div><span>Cekungan Air Tanah</span><strong data-field="cekunganAirTanah">—</strong></div>
                        <div><span>Hidrogeologi</span><strong data-field="hidrogeologi">—</strong></div>
                        <div><span>Lapisan Pembawa Air</span><strong data-field="lapisanPembawaAir">—</strong></div>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="map-detail-actions">
                    <button type="button" class="map-detail-action-btn is-primary" id="mapDetailCenter">
                        <i class="fa-solid fa-crosshairs" aria-hidden="true"></i>
                        <span>Pusatkan Peta</span>
                    </button>
                    <a class="map-detail-action-btn" id="mapDetailGmaps" href="#" target="_blank" rel="noopener noreferrer">
                        <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
                        <span>Buka di Google Maps</span>
                    </a>
                </div>

            </div>
        </aside>

        {{-- Sidebar toggle (floating circle) --}}
        <button type="button" class="map-sidebar-toggle" id="mapFilterToggle"
                aria-expanded="false" aria-controls="mapFilterSidebar" aria-label="Buka filter">
            <i class="fa-solid fa-chevron-right map-sidebar-toggle-icon" aria-hidden="true"></i>
            <span class="map-filter-badge" id="mapFilterBadge" hidden>0</span>
        </button>

        <div class="map-topbar">
            <div class="map-heading-group">
                <div class="map-title-row">
                    <h1 class="map-title">Peta Indonesia</h1>
                </div>
            </div>
            <div class="map-actions">
                <a href="{{ route('admin.geolistrik-1d.index') }}" class="map-back-btn">
                    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <div id="indonesiaMap" aria-label="Peta Indonesia dari OpenStreetMap"></div>
    </div>
    <div class="pdf-fullscreen-overlay" id="pdfFullscreenOverlay" aria-hidden="true">
        <div class="pdf-fullscreen-card" id="pdfFullscreenCard">
            <button type="button" class="pdf-fullscreen-close" id="pdfFullscreenClose" aria-label="Tutup preview PDF">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
            <div class="pdf-viewport" id="pdfViewport">
                <div class="pdf-frame-wrap" id="pdfFrameWrap">
                    <iframe id="pdfFullscreenFrame" title="Preview PDF fullscreen"></iframe>
                </div>
                <div class="pdf-drag-overlay" id="pdfDragOverlay"></div>
            </div>
            <div class="pdf-zoom-bar">
                <button type="button" class="pdf-zoom-btn" id="pdfZoomOut" aria-label="Zoom out">
                    <i class="fa-solid fa-minus" aria-hidden="true"></i>
                </button>
                <span class="pdf-zoom-label" id="pdfZoomLabel">100%</span>
                <button type="button" class="pdf-zoom-btn" id="pdfZoomIn" aria-label="Zoom in">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i>
                </button>
                <button type="button" class="pdf-zoom-btn pdf-zoom-reset" id="pdfZoomReset" aria-label="Reset zoom">
                    <i class="fa-solid fa-arrows-rotate" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </div>

    <script type="application/json" id="indonesia-map-config">@json($mapConfig)</script>
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
    @vite(['resources/js/map.js'])
</body>
</html>

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
        <div class="map-topbar">
            <div class="map-heading-group">
                <h1 class="map-title">Peta Indonesia</h1>
                <aside class="map-info-panel" id="geolistrikInfoPanel" aria-live="polite">
                    <div class="map-info-preview" id="geolistrikPdfPreview"></div>
                    <div class="map-info-body">
                        <div class="map-info-empty" id="geolistrikInfoEmpty">Klik marker untuk melihat detail.</div>
                        <div class="map-info-list" id="geolistrikInfoList" hidden>
                            <div><span>Kode</span><strong data-field="kode">-</strong></div>
                            <div><span>Kab/Kota</span><strong data-field="kabKota">-</strong></div>
                            <div><span>Kecamatan</span><strong data-field="kecamatan">-</strong></div>
                            <div><span>Desa/Kelurahan</span><strong data-field="desaKelurahan">-</strong></div>
                            <div><span>UPT</span><strong data-field="upt">-</strong></div>
                            <div><span>Latitude</span><strong data-field="latitude">-</strong></div>
                            <div><span>Longitude</span><strong data-field="longitude">-</strong></div>
                            <div><span>Elevasi</span><strong data-field="elevasi">-</strong></div>
                            <div><span>Tanggal Akusisi Data</span><strong data-field="tanggalAkusisiData">-</strong></div>
                            <div><span>Geologi</span><strong data-field="geologi">-</strong></div>
                            <div><span>Cekungan Air Tanah</span><strong data-field="cekunganAirTanah">-</strong></div>
                            <div><span>Hidrogeologi</span><strong data-field="hidrogeologi">-</strong></div>
                            <div><span>Lapisan Pembawa Air</span><strong data-field="lapisanPembawaAir">-</strong></div>
                        </div>
                    </div>
                </aside>
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
        <div class="pdf-fullscreen-card">
            <button type="button" class="pdf-fullscreen-close" id="pdfFullscreenClose" aria-label="Tutup preview PDF">
                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
            </button>
            <iframe id="pdfFullscreenFrame" title="Preview PDF fullscreen"></iframe>
        </div>
    </div>

    <script type="application/json" id="indonesia-map-config">@json($mapConfig)</script>
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
    @vite(['resources/js/map.js'])
</body>
</html>

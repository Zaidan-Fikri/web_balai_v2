<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Indonesia - Balai Air Tanah</title>
    <!-- Font memakai fallback lokal/sistem agar tidak bergantung Google Fonts saat local development. -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/leaflet/leaflet.css') }}">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    @vite(['resources/css/pages.css'])
</head>
<body>
    <div class="map-shell">
        <div class="map-topbar">
            <h1 class="map-title">Peta Indonesia</h1>
            <div class="map-actions">
                <a href="{{ route('home') }}" class="map-back-btn">
                    <ion-icon name="arrow-back-outline" aria-hidden="true"></ion-icon>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <div id="indonesiaMap" aria-label="Peta Indonesia dari OpenStreetMap"></div>
    </div>

    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
    @vite(['resources/js/pages.js'])
</body>
</html>

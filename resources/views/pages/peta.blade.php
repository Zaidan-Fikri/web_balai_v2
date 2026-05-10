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
            <h1 class="map-title">Peta Indonesia</h1>
            <div class="map-actions">
                <a href="{{ route('home') }}" class="map-back-btn">
                    <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
        <div id="indonesiaMap" aria-label="Peta Indonesia dari OpenStreetMap"></div>
    </div>

    <script type="application/json" id="indonesia-map-config">@json($mapConfig)</script>
    <script src="{{ asset('assets/vendor/leaflet/leaflet.js') }}"></script>
    @vite(['resources/js/map.js'])
</body>
</html>

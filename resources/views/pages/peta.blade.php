<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Indonesia - Balai Air Tanah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        html, body {
            margin: 0;
            width: 100%;
            height: 100%;
            font-family: "DM Sans", sans-serif;
            background: #eef3f8;
        }

        .map-shell {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            background: #eef3f8;
        }

        #indonesiaMap {
            width: 100%;
            height: 100%;
        }

        .map-topbar {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            z-index: 500;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            pointer-events: none;
        }

        .map-title,
        .map-back-btn {
            pointer-events: auto;
        }

        .map-title {
            margin: 0;
            padding: 14px 18px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.92);
            color: #0b2b5c;
            font-size: 18px;
            font-weight: 900;
            box-shadow: 0 12px 28px rgba(11, 43, 92, 0.12);
        }

        .map-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 12px;
        }

        .map-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 18px;
            border-radius: 999px;
            border: 0;
            background: linear-gradient(135deg, #f4b000 0%, #e7a300 100%);
            color: #fff;
            text-decoration: none;
            font-weight: 800;
            box-shadow: 0 12px 24px rgba(244, 176, 0, 0.22);
            transition: background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .map-back-btn:hover {
            color: #fff;
            background: linear-gradient(135deg, #0b2b5c 0%, #001f45 100%);
            transform: translateY(-2px);
            box-shadow: 0 18px 34px rgba(0, 31, 69, 0.24);
        }

        .leaflet-bottom.leaflet-right {
            right: 20px;
            bottom: 20px;
        }

        .leaflet-control-layers {
            border: 0;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(11, 43, 92, 0.18);
        }

        .leaflet-control-layers-expanded {
            padding: 10px 12px;
            font-size: 14px;
        }

        .leaflet-control-layers-toggle {
            width: 36px;
            height: 36px;
        }

        .leaflet-control-zoom {
            margin-left: 20px;
            margin-bottom: 20px;
        }

        .leaflet-control-zoom a {
            border-radius: 10px !important;
        }

        @media (max-width: 576px) {
            .map-topbar {
                top: 12px;
                left: 12px;
                right: 12px;
                flex-direction: column;
                align-items: stretch;
            }

            .map-actions {
                align-items: stretch;
            }

            .map-title {
                width: 100%;
                box-sizing: border-box;
            }

            .leaflet-bottom.leaflet-right {
                right: 12px;
                bottom: 12px;
            }

            .leaflet-control-zoom {
                margin-left: 12px;
                margin-bottom: 12px;
            }
        }
    </style>
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

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof L === 'undefined') {
                return;
            }

            var map = L.map('indonesiaMap', {
                zoomControl: false,
                scrollWheelZoom: true
            });

            var osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            });

            var satelliteLayer = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                {
                    maxZoom: 19,
                    attribution: 'Tiles &copy; Esri'
                }
            );

            osmLayer.addTo(map);

            L.control.zoom({
                position: 'bottomleft'
            }).addTo(map);

            var baseLayers = {
                'OpenStreetMap': osmLayer,
                'Satellite': satelliteLayer
            };

            L.control.layers(baseLayers, null, {
                position: 'bottomright',
                collapsed: true
            }).addTo(map);

            var indonesiaBounds = L.latLngBounds(
                L.latLng(-11.2, 94.6),
                L.latLng(6.2, 141.1)
            );

            map.fitBounds(indonesiaBounds, {
                padding: [24, 24]
            });

        });
    </script>
</body>
</html>

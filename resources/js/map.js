import { readIndonesiaMapConfig } from './map/indonesia-map-model';

function createTileLayers(leaflet, layers) {
    return layers
        .filter((layer) => layer && layer.label && layer.url)
        .map((layer) => ({
            key: layer.key || layer.label,
            label: layer.label,
            active: Boolean(layer.active),
            instance: leaflet.tileLayer(layer.url, layer.options || {}),
        }));
}

function createBounds(leaflet, bounds) {
    return leaflet.latLngBounds(
        leaflet.latLng(bounds.southWest.lat, bounds.southWest.lng),
        leaflet.latLng(bounds.northEast.lat, bounds.northEast.lng),
    );
}

function addLocateControl(leaflet, map) {
    let locationMarker = null;
    let accuracyCircle = null;
    const locationIcon = leaflet.divIcon({
        className: 'my-location-marker',
        html: '<span></span>',
        iconSize: [28, 28],
        iconAnchor: [14, 14],
        popupAnchor: [0, -14],
    });

    const LocateControl = leaflet.Control.extend({
        options: {
            position: 'bottomright',
        },

        onAdd() {
            const container = leaflet.DomUtil.create('div', 'leaflet-bar leaflet-control map-locate-control');
            const button = leaflet.DomUtil.create('button', 'map-locate-button', container);
            button.type = 'button';
            button.title = 'Lokasi saya';
            button.setAttribute('aria-label', 'Lokasi saya');
            button.innerHTML = '<i class="fa-solid fa-location-crosshairs" aria-hidden="true"></i>';

            leaflet.DomEvent.disableClickPropagation(container);
            leaflet.DomEvent.on(button, 'click', (event) => {
                leaflet.DomEvent.preventDefault(event);

                if (!navigator.geolocation) {
                    button.classList.add('is-error');
                    return;
                }

                button.classList.add('is-loading');
                button.classList.remove('is-error');

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const accuracy = position.coords.accuracy || 0;

                        if (locationMarker) {
                            locationMarker.setLatLng([lat, lng]);
                        } else {
                            locationMarker = leaflet.marker([lat, lng], {
                                title: 'Lokasi saya',
                                icon: locationIcon,
                            }).addTo(map);
                        }

                        if (accuracyCircle) {
                            accuracyCircle.setLatLng([lat, lng]).setRadius(accuracy);
                        } else {
                            accuracyCircle = leaflet.circle([lat, lng], {
                                radius: accuracy,
                                color: '#0047cc',
                                weight: 1,
                                fillColor: '#0047cc',
                                fillOpacity: 0.12,
                            }).addTo(map);
                        }

                        map.setView([lat, lng], Math.max(map.getZoom(), 15), { animate: true });
                        locationMarker.bindPopup('Lokasi saya').openPopup();
                        button.classList.remove('is-loading');
                    },
                    () => {
                        button.classList.remove('is-loading');
                        button.classList.add('is-error');
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 60000,
                    },
                );
            });

            return container;
        },
    });

    map.addControl(new LocateControl());
}

function createDetailsPanelRenderer(config) {
    if (!config.detailsPanel || !config.detailsPanel.enabled) {
        return null;
    }

    const preview = document.getElementById('geolistrikPdfPreview');
    const empty = document.getElementById('geolistrikInfoEmpty');
    const list = document.getElementById('geolistrikInfoList');
    const panel = document.getElementById('geolistrikInfoPanel');
    const fullscreenOverlay = document.getElementById('pdfFullscreenOverlay');
    const fullscreenFrame = document.getElementById('pdfFullscreenFrame');
    const fullscreenClose = document.getElementById('pdfFullscreenClose');

    if (!panel || !preview || !empty || !list) {
        return null;
    }

    const fields = {
        kode: list.querySelector('[data-field="kode"]'),
        kabKota: list.querySelector('[data-field="kabKota"]'),
        kecamatan: list.querySelector('[data-field="kecamatan"]'),
        desaKelurahan: list.querySelector('[data-field="desaKelurahan"]'),
        upt: list.querySelector('[data-field="upt"]'),
        latitude: list.querySelector('[data-field="latitude"]'),
        longitude: list.querySelector('[data-field="longitude"]'),
        elevasi: list.querySelector('[data-field="elevasi"]'),
        tanggalAkusisiData: list.querySelector('[data-field="tanggalAkusisiData"]'),
        geologi: list.querySelector('[data-field="geologi"]'),
        cekunganAirTanah: list.querySelector('[data-field="cekunganAirTanah"]'),
        hidrogeologi: list.querySelector('[data-field="hidrogeologi"]'),
        lapisanPembawaAir: list.querySelector('[data-field="lapisanPembawaAir"]'),
    };

    function closeFullscreen() {
        if (!fullscreenOverlay || !fullscreenFrame) return;
        fullscreenOverlay.classList.remove('is-open');
        fullscreenOverlay.setAttribute('aria-hidden', 'true');
        fullscreenFrame.src = '';
    }

    if (fullscreenClose) {
        fullscreenClose.addEventListener('click', closeFullscreen);
    }

    if (fullscreenOverlay) {
        fullscreenOverlay.addEventListener('click', (event) => {
            if (event.target === fullscreenOverlay) {
                closeFullscreen();
            }
        });
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeFullscreen();
        }
    });

    function closeDetails() {
        panel.classList.remove('is-visible');
        preview.innerHTML = '';
        empty.hidden = false;
        list.hidden = true;
    }

    function renderDetails(data) {
        panel.classList.add('is-visible');
        preview.innerHTML = '';

        if (data.pdfUrl) {
            const iframe = document.createElement('iframe');
            iframe.src = data.pdfUrl;
            iframe.title = data.pdfName || data.title || 'Preview PDF';
            iframe.loading = 'lazy';
            preview.appendChild(iframe);

            const fullscreenButton = document.createElement('button');
            fullscreenButton.type = 'button';
            fullscreenButton.className = 'map-pdf-fullscreen-btn';
            fullscreenButton.setAttribute('aria-label', 'Perbesar preview PDF');
            fullscreenButton.innerHTML = '<i class="fa-solid fa-up-right-and-down-left-from-center" aria-hidden="true"></i>';
            fullscreenButton.addEventListener('click', () => {
                if (!fullscreenOverlay || !fullscreenFrame) return;
                fullscreenFrame.src = data.pdfUrl;
                fullscreenOverlay.classList.add('is-open');
                fullscreenOverlay.setAttribute('aria-hidden', 'false');
            });
            preview.appendChild(fullscreenButton);
        } else {
            const emptyPdf = document.createElement('div');
            emptyPdf.className = 'map-info-pdf-empty';
            emptyPdf.textContent = 'Tidak ada PDF.';
            preview.appendChild(emptyPdf);
        }

        Object.entries(fields).forEach(([key, element]) => {
            if (!element) return;
            element.textContent = data[key] ? String(data[key]) : '-';
        });

        if (fields.latitude) fields.latitude.textContent = Number(data.lat).toFixed(7);
        if (fields.longitude) fields.longitude.textContent = Number(data.lng).toFixed(7);

        empty.hidden = true;
        list.hidden = false;
    }

    return {
        close: closeDetails,
        render: renderDetails,
    };
}

function addGeolistrikMarkers(leaflet, map, markers, config) {
    const items = Array.isArray(markers) ? markers : [];

    if (!items.length) {
        return;
    }

    const markerLayer = leaflet.layerGroup();
    const detailsPanel = createDetailsPanelRenderer(config);

    if (detailsPanel) {
        map.on('click', () => {
            detailsPanel.close();
            map.closePopup();
        });
    }

    items.forEach((item) => {
        const lat = Number(item.lat);
        const lng = Number(item.lng);

        if (!Number.isFinite(lat) || !Number.isFinite(lng)) {
            return;
        }

        const title = item.title || 'Geolistrik 1D';
        const marker = leaflet.marker([lat, lng], { title });

        marker.bindPopup(
            '<strong>' + title + '</strong><br>' +
            'Latitude: ' + lat.toFixed(7) + '<br>' +
            'Longitude: ' + lng.toFixed(7),
        );

        marker.on('click', (event) => {
            if (event.originalEvent) {
                leaflet.DomEvent.stopPropagation(event.originalEvent);
            }

            if (config.detailsPanel && config.detailsPanel.enabled) {
                const zoom = Number(config.detailsPanel.zoom) || 14;
                map.setView([lat, lng], Math.max(map.getZoom(), zoom), { animate: true });
            }

            if (detailsPanel) {
                detailsPanel.render(item);
            }
        });

        marker.addTo(markerLayer);
    });

    markerLayer.addTo(map);
}

function initIndonesiaMap() {
    const config = readIndonesiaMapConfig();
    const mapElement = document.getElementById(config.elementId);

    if (!mapElement || typeof L === 'undefined') {
        return;
    }

    const map = L.map(mapElement, config.mapOptions);
    const tileLayers = createTileLayers(L, config.tileLayers);
    const activeLayer = tileLayers.find((layer) => layer.active) || tileLayers[0];

    if (activeLayer) {
        activeLayer.instance.addTo(map);
    }

    L.control.zoom(config.controls.zoom).addTo(map);

    const layerControlItems = tileLayers.reduce((items, layer) => {
        items[layer.label] = layer.instance;

        return items;
    }, {});

    L.control.layers(layerControlItems, null, config.controls.layers).addTo(map);
    addLocateControl(L, map);
    addGeolistrikMarkers(L, map, config.markers.geolistrik1d, config);

    map.fitBounds(createBounds(L, config.bounds), config.fitBoundsOptions);
}

document.addEventListener('DOMContentLoaded', initIndonesiaMap);

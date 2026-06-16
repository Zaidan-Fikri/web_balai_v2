import 'leaflet.markercluster';
import { readIndonesiaMapConfig } from './map/indonesia-map-model';

const REGION_COLORS = ['#e74c3c', '#0047cc', '#f39c12', '#27ae60', '#9b59b6', '#16a085'];

const DATA_TYPE_CONFIG = {
    geolistrik1d:   { color: '#0047cc', label: 'Geolistrik 1D',   icon: 'fa-wave-square' },
    geolistrik2d:   { color: '#e74c3c', label: 'Geolistrik 2D',   icon: 'fa-wave-square' },
    pumpingTest:    { color: '#27ae60', label: 'Pumping Test',     icon: 'fa-droplet' },
    boreholeCamera: { color: '#f39c12', label: 'Borehole Camera',  icon: 'fa-camera' },
    logging:        { color: '#9b59b6', label: 'Logging',           icon: 'fa-chart-bar' },
};

function getMarkerColor(dataType) {
    return (DATA_TYPE_CONFIG[dataType] || DATA_TYPE_CONFIG.geolistrik1d).color;
}

// ── Tile layers ──────────────────────────────────────────────────────────────
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

// ── Locate control ───────────────────────────────────────────────────────────
function addLocateControl(leaflet, map) {
    let locationMarker = null;
    let accuracyCircle = null;
    const locationIcon = leaflet.divIcon({
        className: 'my-location-marker',
        html: '<span></span>',
        iconSize: [28, 28],
        iconAnchor: [14, 14],
    });

    const LocateControl = leaflet.Control.extend({
        options: { position: 'bottomright' },
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
                if (!navigator.geolocation) { button.classList.add('is-error'); return; }
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
                            locationMarker = leaflet.marker([lat, lng], { title: 'Lokasi saya', icon: locationIcon }).addTo(map);
                        }
                        if (accuracyCircle) {
                            accuracyCircle.setLatLng([lat, lng]).setRadius(accuracy);
                        } else {
                            accuracyCircle = leaflet.circle([lat, lng], {
                                radius: accuracy, color: '#0047cc', weight: 1,
                                fillColor: '#0047cc', fillOpacity: 0.12,
                            }).addTo(map);
                        }
                        map.setView([lat, lng], Math.max(map.getZoom(), 15), { animate: true });
                        locationMarker.bindPopup('Lokasi saya').openPopup();
                        button.classList.remove('is-loading');
                    },
                    () => { button.classList.remove('is-loading'); button.classList.add('is-error'); },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 },
                );
            });
            return container;
        },
    });
    map.addControl(new LocateControl());
}

// ── Detail panel renderer ────────────────────────────────────────────────────
function createDetailsPanelRenderer(config, map) {
    if (!config.detailsPanel || !config.detailsPanel.enabled) return null;

    const panel          = document.getElementById('geolistrikInfoPanel');
    const closeBtn       = document.getElementById('geolistrikInfoClose');
    const titleEl        = document.getElementById('mapDetailTitle');
    const coordsEl       = document.getElementById('mapDetailCoords');
    const preview        = document.getElementById('geolistrikPdfPreview');
    const centerBtn      = document.getElementById('mapDetailCenter');
    const gmapsBtn       = document.getElementById('mapDetailGmaps');
    const fullscreenOverlay = document.getElementById('pdfFullscreenOverlay');
    const fullscreenFrame   = document.getElementById('pdfFullscreenFrame');
    const fullscreenCard    = document.getElementById('pdfFullscreenCard');
    const fullscreenClose   = document.getElementById('pdfFullscreenClose');
    const zoomInBtn         = document.getElementById('pdfZoomIn');
    const zoomOutBtn        = document.getElementById('pdfZoomOut');
    const zoomResetBtn      = document.getElementById('pdfZoomReset');
    const zoomLabel         = document.getElementById('pdfZoomLabel');

    if (!panel || !preview) return null;

    const fields = {
        kabKota:            panel.querySelector('[data-field="kabKota"]'),
        kecamatan:          panel.querySelector('[data-field="kecamatan"]'),
        desaKelurahan:      panel.querySelector('[data-field="desaKelurahan"]'),
        elevasi:            panel.querySelector('[data-field="elevasi"]'),
        upt:                panel.querySelector('[data-field="upt"]'),
        tanggalAkusisiData: panel.querySelector('[data-field="tanggalAkusisiData"]'),
        geologi:            panel.querySelector('[data-field="geologi"]'),
        cekunganAirTanah:   panel.querySelector('[data-field="cekunganAirTanah"]'),
        hidrogeologi:       panel.querySelector('[data-field="hidrogeologi"]'),
        lapisanPembawaAir:  panel.querySelector('[data-field="lapisanPembawaAir"]'),
    };

    let currentItem = null;
    let pdfZoom = 1;
    const ZOOM_MIN = 0.5, ZOOM_MAX = 4, ZOOM_STEP = 0.15;

    function applyZoom(ox = 50, oy = 50) {
        if (!fullscreenFrame) return;
        fullscreenFrame.style.transformOrigin = `${ox}% ${oy}%`;
        fullscreenFrame.style.transform = pdfZoom === 1 ? '' : `scale(${pdfZoom})`;
        if (zoomLabel) zoomLabel.textContent = Math.round(pdfZoom * 100) + '%';
    }

    function resetZoom() { pdfZoom = 1; applyZoom(); }

    if (fullscreenCard) {
        fullscreenCard.addEventListener('wheel', (e) => {
            if (!fullscreenOverlay?.classList.contains('is-open')) return;
            e.preventDefault(); e.stopPropagation();
            const rect = fullscreenFrame.getBoundingClientRect();
            pdfZoom = Math.min(ZOOM_MAX, Math.max(ZOOM_MIN,
                pdfZoom + (e.deltaY < 0 ? ZOOM_STEP : -ZOOM_STEP)));
            applyZoom(
                ((e.clientX - rect.left) / rect.width * 100).toFixed(2),
                ((e.clientY - rect.top) / rect.height * 100).toFixed(2),
            );
        }, { passive: false });
    }

    if (zoomInBtn)    zoomInBtn.addEventListener('click',    () => { pdfZoom = Math.min(ZOOM_MAX, pdfZoom + ZOOM_STEP); applyZoom(); });
    if (zoomOutBtn)   zoomOutBtn.addEventListener('click',   () => { pdfZoom = Math.max(ZOOM_MIN, pdfZoom - ZOOM_STEP); applyZoom(); });
    if (zoomResetBtn) zoomResetBtn.addEventListener('click', resetZoom);

    function closeFullscreen() {
        if (!fullscreenOverlay || !fullscreenFrame) return;
        fullscreenOverlay.classList.remove('is-open');
        fullscreenOverlay.setAttribute('aria-hidden', 'true');
        fullscreenFrame.src = '';
        resetZoom();
    }

    if (fullscreenClose) fullscreenClose.addEventListener('click', closeFullscreen);
    if (fullscreenOverlay) {
        fullscreenOverlay.addEventListener('click', (e) => { if (e.target === fullscreenOverlay) closeFullscreen(); });
    }
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeFullscreen(); });

    if (centerBtn && map) {
        centerBtn.addEventListener('click', () => {
            if (!currentItem) return;
            const zoom = Number(config.detailsPanel.zoom) || 14;
            map.setView([Number(currentItem.lat), Number(currentItem.lng)],
                Math.max(map.getZoom(), zoom), { animate: true });
        });
    }

    function closeDetails() {
        panel.classList.remove('is-visible');
        preview.innerHTML = '';
        currentItem = null;
    }

    if (closeBtn) closeBtn.addEventListener('click', closeDetails);

    function closeSidebar() {
        const sidebar = document.getElementById('mapFilterSidebar');
        const scrim   = document.getElementById('mapFilterScrim');
        const toggle  = document.getElementById('mapFilterToggle');
        if (sidebar) sidebar.classList.remove('is-open');
        if (scrim)   scrim.classList.remove('is-visible');
        if (toggle)  { toggle.setAttribute('aria-expanded', 'false'); toggle.classList.remove('is-open'); }
    }

    function renderDetails(data) {
        currentItem = data;
        panel.classList.add('is-visible');
        preview.innerHTML = '';
        closeSidebar();

        // Update type badge dynamically
        const badgeEl = document.getElementById('mapDetailBadge');
        if (badgeEl) {
            const tc = DATA_TYPE_CONFIG[data.dataType] || DATA_TYPE_CONFIG.geolistrik1d;
            badgeEl.innerHTML = `<i class="fa-solid ${tc.icon}" aria-hidden="true"></i> ${tc.label}`;
        }

        if (titleEl) titleEl.textContent = data.kode || '—';
        if (coordsEl) coordsEl.textContent = Number(data.lat).toFixed(7) + ', ' + Number(data.lng).toFixed(7);
        if (gmapsBtn) gmapsBtn.href = 'https://www.google.com/maps?q=' + Number(data.lat) + ',' + Number(data.lng);

        Object.entries(fields).forEach(([key, el]) => {
            if (el) el.textContent = data[key] ? String(data[key]) : '—';
        });

        if (data.pdfUrl) {
            const iframe = document.createElement('iframe');
            iframe.src = data.pdfUrl;
            iframe.title = data.pdfName || data.kode || 'Preview PDF';
            iframe.loading = 'lazy';
            preview.appendChild(iframe);

            const fsBtn = document.createElement('button');
            fsBtn.type = 'button';
            fsBtn.className = 'map-pdf-fullscreen-btn';
            fsBtn.setAttribute('aria-label', 'Perbesar preview PDF');
            fsBtn.innerHTML = '<i class="fa-solid fa-up-right-and-down-left-from-center" aria-hidden="true"></i>';
            fsBtn.addEventListener('click', () => {
                if (!fullscreenOverlay || !fullscreenFrame) return;
                fullscreenFrame.src = data.pdfUrl;
                fullscreenOverlay.classList.add('is-open');
                fullscreenOverlay.setAttribute('aria-hidden', 'false');
            });
            preview.appendChild(fsBtn);
        } else {
            const noPdf = document.createElement('div');
            noPdf.className = 'map-info-pdf-empty';
            noPdf.innerHTML = '<i class="fa-regular fa-file-pdf"></i> <span>Belum ada file PDF</span>';
            preview.appendChild(noPdf);
        }
    }

    return { close: closeDetails, render: renderDetails };
}

// ── Geolistrik markers (clustered, colored) ──────────────────────────────────
function addGeolistrikMarkers(leaflet, map, markers, config) {
    const items = Array.isArray(markers) ? markers : [];
    if (!items.length) return { uptMarkersMap: {}, clusterGroup: null, detailsPanel: null };

    const uptMarkersMap = {};
    const uptRegionMap  = config.uptRegionMap || {};
    const detailsPanel  = createDetailsPanelRenderer(config, map);

    if (detailsPanel) {
        map.on('click', () => detailsPanel.close());
    }

    const clusterGroup = leaflet.layerGroup();

    const markerItems = [];

    items.forEach((item) => {
        const lat = Number(item.lat);
        const lng = Number(item.lng);
        if (!Number.isFinite(lat) || !Number.isFinite(lng)) return;

        const upt      = item.upt || '';
        const dataType = item.dataType || 'geolistrik1d';
        const color    = getMarkerColor(dataType);

        const marker = leaflet.marker([lat, lng], {
            title: item.title || dataType || 'Geolistrik 1D',
            icon: leaflet.divIcon({
                className: '',
                html: `<div class="geo-marker" style="background:${color}"></div>`,
                iconSize:   [22, 22],
                iconAnchor: [11, 11],
            }),
        });

        if (!config.detailsPanel?.enabled) {
            marker.bindPopup(
                '<strong>' + (item.title || 'Geolistrik 1D') + '</strong><br>' +
                lat.toFixed(7) + ', ' + lng.toFixed(7),
            );
        }

        marker.on('click', (event) => {
            if (event.originalEvent) leaflet.DomEvent.stopPropagation(event.originalEvent);
            if (detailsPanel) detailsPanel.render(item);
        });

        if (!uptMarkersMap[upt]) uptMarkersMap[upt] = [];
        uptMarkersMap[upt].push(marker);
        markerItems.push({ marker, upt, dataType });
        clusterGroup.addLayer(marker);
    });

    clusterGroup.addTo(map);

    return { uptMarkersMap, clusterGroup, detailsPanel, markerItems };
}

// ── Filter sidebar ───────────────────────────────────────────────────────────
function initUptFilterSidebar(map, uptMarkersMap, clusterGroup, detailsPanel, markerItems) {
    const toggleBtn    = document.getElementById('mapFilterToggle');
    const sidebar      = document.getElementById('mapFilterSidebar');
    const scrim        = document.getElementById('mapFilterScrim');
    const closeBtn     = document.getElementById('mapFilterClose');
    const selectAll    = document.getElementById('mapFilterSelectAll');
    const clearAll     = document.getElementById('mapFilterClearAll');
    const badge        = document.getElementById('mapFilterBadge');
    const uptCheckboxes  = document.querySelectorAll('.map-upt-filter');
    const typeCheckboxes = document.querySelectorAll('.map-type-filter');

    if (!toggleBtn || !sidebar) return;

    const isMobile = () => window.innerWidth <= 640;

    // Color dots on UPT sidebar items
    const uptRegionMap = JSON.parse(
        document.getElementById('indonesia-map-config')?.textContent || '{}'
    ).uptRegionMap || {};


    // Tab switching
    const tabPanelMap = { tipe: 'mapPanelTipe', wilayah: 'mapPanelWilayah' };
    document.querySelectorAll('.map-filter-tab').forEach((tab) => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.map-filter-tab').forEach((t) => t.classList.remove('is-active'));
            document.querySelectorAll('.map-filter-panel').forEach((p) => p.classList.remove('is-active'));
            tab.classList.add('is-active');
            document.getElementById(tabPanelMap[tab.dataset.tab] || 'mapPanelTipe')?.classList.add('is-active');
        });
    });

    function updateBadge() {
        const hiddenUpts  = Array.from(uptCheckboxes).filter((cb) => !cb.checked).length;
        const hiddenTypes = Array.from(typeCheckboxes).filter((cb) => !cb.checked).length;
        const hidden = hiddenUpts + hiddenTypes;
        if (badge) { badge.textContent = hidden; badge.hidden = hidden === 0; }
    }

    function applyFilter() {
        if (!clusterGroup) return;
        const visibleUpts  = new Set(Array.from(uptCheckboxes).filter((cb) => cb.checked).map((cb) => cb.value));
        const visibleTypes = new Set(Array.from(typeCheckboxes).filter((cb) => cb.checked).map((cb) => cb.value));
        clusterGroup.clearLayers();
        markerItems.forEach(({ marker, upt, dataType }) => {
            if (visibleUpts.has(upt) && visibleTypes.has(dataType)) {
                clusterGroup.addLayer(marker);
            }
        });
        updateBadge();
    }

    uptCheckboxes.forEach((cb) => cb.addEventListener('change', applyFilter));
    // Sync toggle visual state with checkbox
    function syncTypeVisual(cb) {
        cb.closest('.map-type-item')?.classList.toggle('is-checked', cb.checked);
    }

    typeCheckboxes.forEach((cb) => {
        syncTypeVisual(cb);
        cb.addEventListener('change', () => { syncTypeVisual(cb); applyFilter(); });
    });

    const typeSelectAll = document.getElementById('mapTypeSelectAll');
    const typeClearAll  = document.getElementById('mapTypeClearAll');
    if (typeSelectAll) typeSelectAll.addEventListener('click', () => {
        typeCheckboxes.forEach((cb) => { cb.checked = true; syncTypeVisual(cb); }); applyFilter();
    });
    if (typeClearAll) typeClearAll.addEventListener('click', () => {
        typeCheckboxes.forEach((cb) => { cb.checked = false; syncTypeVisual(cb); }); applyFilter();
    });

    if (selectAll) selectAll.addEventListener('click', () => { uptCheckboxes.forEach((cb) => { cb.checked = true; }); applyFilter(); });
    if (clearAll)  clearAll.addEventListener('click',  () => { uptCheckboxes.forEach((cb) => { cb.checked = false; }); applyFilter(); });

    function openSidebar() {
        sidebar.classList.add('is-open');
        toggleBtn.setAttribute('aria-expanded', 'true');
        toggleBtn.classList.add('is-open');
        if (scrim && isMobile()) scrim.classList.add('is-visible');
        if (detailsPanel) detailsPanel.close();
    }

    function closeSidebar() {
        sidebar.classList.remove('is-open');
        toggleBtn.setAttribute('aria-expanded', 'false');
        toggleBtn.classList.remove('is-open');
        if (scrim) scrim.classList.remove('is-visible');
    }

    toggleBtn.addEventListener('click', () => sidebar.classList.contains('is-open') ? closeSidebar() : openSidebar());
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (scrim)    scrim.addEventListener('click', closeSidebar);
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && sidebar.classList.contains('is-open')) closeSidebar(); });

    updateBadge();
}

// ── Basemap sidebar ──────────────────────────────────────────────────────────
function initBasemapSidebar(map, tileLayers) {
    const container = document.getElementById('mapBasemapList');
    if (!container || !tileLayers.length) return;

    let activeLayer = tileLayers.find((l) => l.active) || tileLayers[0];

    const header = document.createElement('div');
    header.className = 'map-basemap-header';
    header.innerHTML = '<i class="fa-solid fa-globe" aria-hidden="true"></i> Base Map';

    const pills = document.createElement('div');
    pills.className = 'map-basemap-pills';

    tileLayers.forEach((layer) => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'map-basemap-pill' + (layer === activeLayer ? ' is-active' : '');
        btn.textContent = layer.label;

        btn.addEventListener('click', () => {
            if (activeLayer === layer) return;
            map.removeLayer(activeLayer.instance);
            map.addLayer(layer.instance);
            activeLayer = layer;
            pills.querySelectorAll('.map-basemap-pill').forEach((p) => p.classList.remove('is-active'));
            btn.classList.add('is-active');
        });

        pills.appendChild(btn);
    });

    container.append(header, pills);
}

// ── Search ───────────────────────────────────────────────────────────────────
function initSearch(map, markers, detailsPanel, config) {
    const input   = document.getElementById('mapSearchInput');
    const results = document.getElementById('mapSearchResults');
    if (!input || !results) return;

    const items = Array.isArray(markers) ? markers : [];
    const norm  = (s) => String(s || '').toLowerCase();

    function search(q) {
        if (!q.trim()) return [];
        const lq = norm(q);
        return items.filter((item) =>
            norm(item.kode).includes(lq) ||
            norm(item.kabKota).includes(lq) ||
            norm(item.kecamatan).includes(lq) ||
            norm(item.desaKelurahan).includes(lq) ||
            norm(item.upt).includes(lq),
        ).slice(0, 8);
    }

    function highlight(text, q) {
        const safe = String(text || '');
        if (!q) return safe;
        const regex = new RegExp('(' + q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
        return safe.replace(regex, '<mark>$1</mark>');
    }

    function showResults(matches, q) {
        results.innerHTML = '';
        if (!matches.length) { results.hidden = true; return; }
        matches.forEach((item) => {
            const li = document.createElement('li');
            li.className = 'map-search-result-item';
            li.innerHTML =
                `<span class="map-search-result-kode">${highlight(item.kode, q)}</span>` +
                `<span class="map-search-result-sub">${[item.kabKota, item.kecamatan].filter(Boolean).join(' · ')}</span>`;
            li.addEventListener('mousedown', (e) => {
                e.preventDefault();
                input.value = item.kode || '';
                results.hidden = true;
                const zoom = Number(config.detailsPanel?.zoom) || 14;
                map.flyTo([Number(item.lat), Number(item.lng)], Math.max(map.getZoom(), zoom), { duration: 0.8 });
                if (detailsPanel) detailsPanel.render(item);
            });
            results.appendChild(li);
        });
        results.hidden = false;
    }

    input.addEventListener('input', () => showResults(search(input.value), input.value));
    input.addEventListener('focus', () => { if (input.value) showResults(search(input.value), input.value); });
    document.addEventListener('click', (e) => {
        if (!input.contains(e.target) && !results.contains(e.target)) results.hidden = true;
    });
    input.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') { results.hidden = true; input.blur(); }
    });
}

// ── Init ─────────────────────────────────────────────────────────────────────
function initIndonesiaMap() {
    const config     = readIndonesiaMapConfig();
    const mapElement = document.getElementById(config.elementId);

    if (!mapElement || typeof L === 'undefined') return;

    const map        = L.map(mapElement, config.mapOptions);
    const tileLayers = createTileLayers(L, config.tileLayers);
    const active     = tileLayers.find((l) => l.active) || tileLayers[0];

    if (active) active.instance.addTo(map);

    L.control.zoom(config.controls.zoom).addTo(map);
    addLocateControl(L, map);

    const allMarkers = [
        ...(config.markers.geolistrik1d   || []),
        ...(config.markers.geolistrik2d   || []),
        ...(config.markers.pumpingTest    || []),
        ...(config.markers.boreholeCamera || []),
        ...(config.markers.logging        || []),
    ];

    const { uptMarkersMap, clusterGroup, detailsPanel, markerItems } =
        addGeolistrikMarkers(L, map, allMarkers, config);

    initUptFilterSidebar(map, uptMarkersMap, clusterGroup, detailsPanel, markerItems);
    initBasemapSidebar(map, tileLayers);
    initSearch(map, allMarkers, detailsPanel, config);

    map.fitBounds(createBounds(L, config.bounds), config.fitBoundsOptions);
}

document.addEventListener('DOMContentLoaded', initIndonesiaMap);

import 'leaflet.markercluster';
import { readIndonesiaMapConfig } from './map/indonesia-map-model';
import * as pdfjsLib from 'pdfjs-dist';
import PdfWorker from 'pdfjs-dist/build/pdf.worker.min.mjs?worker';

pdfjsLib.GlobalWorkerOptions.workerPort = new PdfWorker();

const REGION_COLORS = ['#e74c3c', '#0047cc', '#f39c12', '#27ae60', '#9b59b6', '#16a085'];

// Renders page 1 of a PDF onto a canvas at a fixed pixel resolution (unlike an
// <iframe>, which the browser rasterizes once and then blurs when our CSS
// zoom scales it up).
async function renderPdfFirstPage(url, canvas, scale) {
    const pdfDoc = await pdfjsLib.getDocument({ url }).promise;
    const page = await pdfDoc.getPage(1);
    const viewport = page.getViewport({ scale });
    canvas.width = viewport.width;
    canvas.height = viewport.height;
    await page.render({ canvasContext: canvas.getContext('2d'), viewport }).promise;
}

// Geolistrik1d::getPdfUrlAttribute() rewrites Google Drive links into a Drive
// "/preview" URL — an HTML page hosting Google's own viewer, not a PDF file,
// so it can't be fetched/parsed by pdf.js and must stay embedded as an iframe.
function isDriveEmbedUrl(url) {
    return /drive\.google\.com/.test(url);
}

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
    const potensiEl      = document.getElementById('mapDetailPotensi');
    const potensiTextEl  = document.getElementById('mapDetailPotensiText');
    const coordsEl       = document.getElementById('mapDetailCoords');
    const preview        = document.getElementById('geolistrikPdfPreview');
    const centerBtn      = document.getElementById('mapDetailCenter');
    const gmapsBtn       = document.getElementById('mapDetailGmaps');
    const sidebarToggle  = document.getElementById('mapFilterToggle');
    const fullscreenOverlay = document.getElementById('pdfFullscreenOverlay');
    const fullscreenFrame   = document.getElementById('pdfFullscreenFrame');
    const fullscreenCard    = document.getElementById('pdfFullscreenCard');
    const fullscreenClose   = document.getElementById('pdfFullscreenClose');
    const pdfFrameWrap      = document.getElementById('pdfFrameWrap');
    const pdfDragOverlay    = document.getElementById('pdfDragOverlay');
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
    let pdfZoom = 1, panX = 0, panY = 0;
    const ZOOM_MIN = 1, ZOOM_MAX = 4, ZOOM_STEP = 0.15;

    function clampPan() {
        if (!pdfDragOverlay) return;
        const vw = pdfDragOverlay.clientWidth;
        const vh = pdfDragOverlay.clientHeight;
        // Konten lebih besar dari viewport saat zoom > 1, batasi agar tidak keluar
        panX = Math.min(0, Math.max(vw * (1 - pdfZoom), panX));
        panY = Math.min(0, Math.max(vh * (1 - pdfZoom), panY));
    }

    function applyTransform() {
        if (!pdfFrameWrap) return;
        pdfFrameWrap.style.transform = `translate(${panX}px, ${panY}px) scale(${pdfZoom})`;
        if (zoomLabel) zoomLabel.textContent = Math.round(pdfZoom * 100) + '%';
        if (pdfDragOverlay) {
            pdfDragOverlay.classList.toggle('can-drag', pdfZoom > 1);
        }
    }

    function resetZoom() {
        pdfZoom = 1; panX = 0; panY = 0;
        applyTransform();
    }

    // Wheel zoom — zoom ke arah kursor
    if (pdfDragOverlay) {
        pdfDragOverlay.addEventListener('wheel', (e) => {
            if (!fullscreenOverlay?.classList.contains('is-open')) return;
            e.preventDefault(); e.stopPropagation();
            const rect = pdfDragOverlay.getBoundingClientRect();
            const mx = e.clientX - rect.left;
            const my = e.clientY - rect.top;
            const oldZoom = pdfZoom;
            pdfZoom = Math.min(ZOOM_MAX, Math.max(ZOOM_MIN, pdfZoom + (e.deltaY < 0 ? ZOOM_STEP : -ZOOM_STEP)));
            panX = mx - (mx - panX) * (pdfZoom / oldZoom);
            panY = my - (my - panY) * (pdfZoom / oldZoom);
            clampPan();
            applyTransform();
        }, { passive: false });

        // Mouse drag
        let isDragging = false, dragStartX = 0, dragStartY = 0, dragPanX = 0, dragPanY = 0;

        pdfDragOverlay.addEventListener('mousedown', (e) => {
            if (pdfZoom <= 1) return;
            isDragging = true;
            dragStartX = e.clientX; dragStartY = e.clientY;
            dragPanX = panX; dragPanY = panY;
            pdfDragOverlay.classList.add('is-dragging');
            e.preventDefault();
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            panX = dragPanX + (e.clientX - dragStartX);
            panY = dragPanY + (e.clientY - dragStartY);
            clampPan();
            applyTransform();
        });

        document.addEventListener('mouseup', () => {
            if (!isDragging) return;
            isDragging = false;
            pdfDragOverlay.classList.remove('is-dragging');
        });

        // Touch drag + pinch zoom
        let lastTouchX = 0, lastTouchY = 0, lastPinchDist = 0;

        pdfDragOverlay.addEventListener('touchstart', (e) => {
            if (e.touches.length === 1) {
                isDragging = true;
                lastTouchX = e.touches[0].clientX;
                lastTouchY = e.touches[0].clientY;
            } else if (e.touches.length === 2) {
                isDragging = false;
                lastPinchDist = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
            }
            e.preventDefault();
        }, { passive: false });

        pdfDragOverlay.addEventListener('touchmove', (e) => {
            if (e.touches.length === 1 && isDragging) {
                panX += e.touches[0].clientX - lastTouchX;
                panY += e.touches[0].clientY - lastTouchY;
                lastTouchX = e.touches[0].clientX;
                lastTouchY = e.touches[0].clientY;
                clampPan();
                applyTransform();
            } else if (e.touches.length === 2 && lastPinchDist > 0) {
                const dist = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
                const rect = pdfDragOverlay.getBoundingClientRect();
                const midX = ((e.touches[0].clientX + e.touches[1].clientX) / 2) - rect.left;
                const midY = ((e.touches[0].clientY + e.touches[1].clientY) / 2) - rect.top;
                const oldZoom = pdfZoom;
                pdfZoom = Math.min(ZOOM_MAX, Math.max(ZOOM_MIN, pdfZoom * (dist / lastPinchDist)));
                panX = midX - (midX - panX) * (pdfZoom / oldZoom);
                panY = midY - (midY - panY) * (pdfZoom / oldZoom);
                lastPinchDist = dist;
                clampPan();
                applyTransform();
            }
            e.preventDefault();
        }, { passive: false });

        pdfDragOverlay.addEventListener('touchend', (e) => {
            isDragging = false;
            if (e.touches.length < 2) lastPinchDist = 0;
        });
    }

    if (zoomInBtn)    zoomInBtn.addEventListener('click',    () => { pdfZoom = Math.min(ZOOM_MAX, pdfZoom + ZOOM_STEP); clampPan(); applyTransform(); });
    if (zoomOutBtn)   zoomOutBtn.addEventListener('click',   () => { pdfZoom = Math.max(ZOOM_MIN, pdfZoom - ZOOM_STEP); clampPan(); applyTransform(); });
    if (zoomResetBtn) zoomResetBtn.addEventListener('click', resetZoom);

    function closeFullscreen() {
        if (!fullscreenOverlay || !fullscreenFrame) return;
        fullscreenOverlay.classList.remove('is-open');
        fullscreenOverlay.setAttribute('aria-hidden', 'true');
        fullscreenFrame.innerHTML = '';
        if (fullscreenCard) fullscreenCard.classList.remove('is-native-embed');
        resetZoom();
    }

    if (fullscreenClose) fullscreenClose.addEventListener('click', closeFullscreen);
    if (fullscreenOverlay) {
        fullscreenOverlay.addEventListener('click', (e) => { if (e.target === fullscreenOverlay) closeFullscreen(); });
    }
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeFullscreen(); });

    // Center the map on a point, nudged right so it doesn't land underneath
    // the docked detail panel (panel becomes a bottom sheet below 576px, so
    // no horizontal nudge is needed there).
    function focusMap(lat, lng) {
        if (!map) return;
        const zoom = Math.max(map.getZoom(), Number(config.detailsPanel.zoom) || 14);
        const panelWidth = panel && window.innerWidth > 576 ? panel.offsetWidth : 0;

        if (panelWidth > 0) {
            const targetPoint = map.project([lat, lng], zoom).subtract([panelWidth / 2, 0]);
            map.flyTo(map.unproject(targetPoint, zoom), zoom, { duration: 0.8 });
        } else {
            map.flyTo([lat, lng], zoom, { duration: 0.8 });
        }
    }

    if (centerBtn && map) {
        centerBtn.addEventListener('click', () => {
            if (!currentItem) return;
            focusMap(Number(currentItem.lat), Number(currentItem.lng));
        });
    }

    function closeDetails() {
        panel.classList.remove('is-visible');
        preview.innerHTML = '';
        currentItem = null;
        if (sidebarToggle) sidebarToggle.classList.remove('is-panel-open');
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
        if (sidebarToggle) sidebarToggle.classList.add('is-panel-open');

        // Update type badge dynamically
        const badgeEl = document.getElementById('mapDetailBadge');
        if (badgeEl) {
            const tc = DATA_TYPE_CONFIG[data.dataType] || DATA_TYPE_CONFIG.geolistrik1d;
            badgeEl.innerHTML = `<i class="fa-solid ${tc.icon}" aria-hidden="true"></i> ${tc.label}`;
        }

        if (titleEl) titleEl.textContent = data.kode || '—';
        if (potensiEl) {
            if (data.potensi) {
                if (potensiTextEl) potensiTextEl.textContent = data.potensi;
                potensiEl.hidden = false;
            } else {
                if (potensiTextEl) potensiTextEl.textContent = '';
                potensiEl.hidden = true;
            }
        }
        if (coordsEl) coordsEl.textContent = Number(data.lat).toFixed(7) + ', ' + Number(data.lng).toFixed(7);
        if (gmapsBtn) gmapsBtn.href = 'https://www.google.com/maps?q=' + Number(data.lat) + ',' + Number(data.lng);

        Object.entries(fields).forEach(([key, el]) => {
            if (el) el.textContent = data[key] ? String(data[key]) : '—';
        });

        if (data.pdfUrl) {
            const driveEmbed = isDriveEmbedUrl(data.pdfUrl);

            if (driveEmbed) {
                const iframe = document.createElement('iframe');
                iframe.src = data.pdfUrl;
                iframe.loading = 'lazy';
                iframe.title = data.pdfName || data.kode || 'Preview PDF';
                preview.appendChild(iframe);
            } else {
                const canvas = document.createElement('canvas');
                canvas.setAttribute('role', 'img');
                canvas.setAttribute('aria-label', data.pdfName || data.kode || 'Preview PDF');
                preview.appendChild(canvas);
                const previewScale = 1.5 * Math.min(window.devicePixelRatio || 1, 2);
                renderPdfFirstPage(data.pdfUrl, canvas, previewScale)
                    .catch((err) => {
                        console.error('Gagal memuat preview PDF', err);
                        canvas.remove();
                        const failed = document.createElement('div');
                        failed.className = 'map-info-pdf-empty';
                        failed.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> <span>Gagal memuat PDF</span>';
                        preview.appendChild(failed);
                    });
            }

            const fsBtn = document.createElement('button');
            fsBtn.type = 'button';
            fsBtn.className = 'map-pdf-fullscreen-btn';
            fsBtn.setAttribute('aria-label', 'Perbesar preview PDF');
            fsBtn.innerHTML = '<i class="fa-solid fa-up-right-and-down-left-from-center" aria-hidden="true"></i>';
            fsBtn.addEventListener('click', () => {
                if (!fullscreenOverlay || !fullscreenFrame) return;
                fullscreenOverlay.classList.add('is-open');
                fullscreenOverlay.setAttribute('aria-hidden', 'false');
                fullscreenFrame.innerHTML = '';
                // Drive's embedded viewer has its own crisp, high-res zoom — our
                // CSS-transform zoom only rescales its already-rasterized output,
                // which blurs. So for Drive embeds we defer to its own controls
                // instead of layering ours on top.
                if (fullscreenCard) fullscreenCard.classList.toggle('is-native-embed', driveEmbed);

                if (driveEmbed) {
                    const iframe = document.createElement('iframe');
                    iframe.src = data.pdfUrl;
                    iframe.loading = 'lazy';
                    fullscreenFrame.appendChild(iframe);
                } else {
                    const canvas = document.createElement('canvas');
                    fullscreenFrame.appendChild(canvas);
                    // Rendered sharp enough to stay crisp up to the max CSS zoom level.
                    const fullscreenScale = ZOOM_MAX * Math.min(window.devicePixelRatio || 1, 2);
                    renderPdfFirstPage(data.pdfUrl, canvas, fullscreenScale)
                        .catch((err) => console.error('Gagal memuat PDF fullscreen', err));
                }
                // errors here are already visible via the preview panel's own
                // fallback message, since fullscreen is only reachable from there
            });
            preview.appendChild(fsBtn);
        } else {
            const noPdf = document.createElement('div');
            noPdf.className = 'map-info-pdf-empty';
            noPdf.innerHTML = '<i class="fa-regular fa-file-pdf"></i> <span>Belum ada file PDF</span>';
            preview.appendChild(noPdf);
        }
    }

    return { close: closeDetails, render: renderDetails, focusMap };
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
            if (detailsPanel) {
                detailsPanel.render(item);
                detailsPanel.focusMap(lat, lng);
            }
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
                if (detailsPanel) {
                    detailsPanel.render(item);
                    detailsPanel.focusMap(Number(item.lat), Number(item.lng));
                } else {
                    const zoom = Number(config.detailsPanel?.zoom) || 14;
                    map.flyTo([Number(item.lat), Number(item.lng)], Math.max(map.getZoom(), zoom), { duration: 0.8 });
                }
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

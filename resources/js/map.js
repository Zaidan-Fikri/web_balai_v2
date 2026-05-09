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

    map.fitBounds(createBounds(L, config.bounds), config.fitBoundsOptions);
}

document.addEventListener('DOMContentLoaded', initIndonesiaMap);

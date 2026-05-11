const DEFAULT_MAP_CONFIG = {
    elementId: 'indonesiaMap',
    mapOptions: {
        zoomControl: false,
        scrollWheelZoom: true,
    },
    bounds: {
        southWest: {
            lat: -11.2,
            lng: 94.6,
        },
        northEast: {
            lat: 6.2,
            lng: 141.1,
        },
    },
    fitBoundsOptions: {
        padding: [24, 24],
    },
    controls: {
        zoom: {
            position: 'bottomleft',
        },
        layers: {
            position: 'bottomright',
            collapsed: true,
        },
    },
    tileLayers: [],
    markers: {},
};

function parseMapConfig(rawConfig) {
    if (!rawConfig) {
        return {};
    }

    try {
        const parsedConfig = JSON.parse(rawConfig);

        return parsedConfig && typeof parsedConfig === 'object' ? parsedConfig : {};
    } catch (error) {
        return {};
    }
}

function mergeObject(defaultValue, customValue) {
    return {
        ...defaultValue,
        ...(customValue && typeof customValue === 'object' ? customValue : {}),
    };
}

export function readIndonesiaMapConfig(configElementId = 'indonesia-map-config') {
    const configElement = document.getElementById(configElementId);
    const customConfig = parseMapConfig(configElement ? configElement.textContent : '');

    return {
        ...DEFAULT_MAP_CONFIG,
        ...customConfig,
        mapOptions: mergeObject(DEFAULT_MAP_CONFIG.mapOptions, customConfig.mapOptions),
        bounds: mergeObject(DEFAULT_MAP_CONFIG.bounds, customConfig.bounds),
        fitBoundsOptions: mergeObject(DEFAULT_MAP_CONFIG.fitBoundsOptions, customConfig.fitBoundsOptions),
        controls: {
            zoom: mergeObject(DEFAULT_MAP_CONFIG.controls.zoom, customConfig.controls?.zoom),
            layers: mergeObject(DEFAULT_MAP_CONFIG.controls.layers, customConfig.controls?.layers),
        },
        tileLayers: Array.isArray(customConfig.tileLayers) ? customConfig.tileLayers : DEFAULT_MAP_CONFIG.tileLayers,
        markers: mergeObject(DEFAULT_MAP_CONFIG.markers, customConfig.markers),
    };
}

<?php

namespace App\Models;

final class IndonesiaMap
{
    public static function config(): array
    {
        $geolistrikMarkers = Geolistrik1d::query()
            ->orderBy('nama')
            ->get(['nama', 'latitude', 'longitude'])
            ->map(fn (Geolistrik1d $item): array => [
                'title' => $item->nama,
                'lat' => $item->latitude,
                'lng' => $item->longitude,
            ])
            ->values()
            ->all();

        return [
            'elementId' => 'indonesiaMap',
            'mapOptions' => [
                'zoomControl' => false,
                'scrollWheelZoom' => true,
            ],
            'bounds' => [
                'southWest' => [
                    'lat' => -11.2,
                    'lng' => 94.6,
                ],
                'northEast' => [
                    'lat' => 6.2,
                    'lng' => 141.1,
                ],
            ],
            'fitBoundsOptions' => [
                'padding' => [24, 24],
            ],
            'controls' => [
                'zoom' => [
                    'position' => 'bottomleft',
                ],
                'layers' => [
                    'position' => 'bottomright',
                    'collapsed' => true,
                ],
            ],
            'tileLayers' => [
                [
                    'key' => 'osm',
                    'label' => 'OpenStreetMap',
                    'url' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                    'active' => true,
                    'options' => [
                        'maxZoom' => 19,
                        'attribution' => '&copy; OpenStreetMap contributors',
                    ],
                ],
                [
                    'key' => 'satellite',
                    'label' => 'Satellite',
                    'url' => 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                    'active' => false,
                    'options' => [
                        'maxZoom' => 19,
                        'attribution' => 'Tiles &copy; Esri',
                    ],
                ],
            ],
            'markers' => [
                'geolistrik1d' => $geolistrikMarkers,
            ],
        ];
    }
}

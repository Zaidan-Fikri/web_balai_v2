<?php

namespace App\Models;

final class IndonesiaMap
{
    public static function config(): array
    {
        return self::baseConfig(false);
    }

    public static function adminConfig(): array
    {
        return self::baseConfig(true);
    }

    private static function baseConfig(bool $withDetails): array
    {
        $geolistrikMarkers = Geolistrik1d::query()
            ->orderBy('nama')
            ->get([
                'nama',
                'kode',
                'kab_kota',
                'kecamatan',
                'desa_kelurahan',
                'upt',
                'latitude',
                'longitude',
                'elevasi',
                'tanggal_akusisi_data',
                'geologi',
                'cekungan_air_tanah',
                'hidrogeologi',
                'lapisan_pembawa_air',
                'pdf_path',
            ])
            ->map(fn (Geolistrik1d $item): array => self::markerData($item, $withDetails))
            ->values()
            ->all();

        return [
            'elementId' => 'indonesiaMap',
            'detailsPanel' => [
                'enabled' => $withDetails,
                'zoom' => 14,
            ],
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

    private static function markerData(Geolistrik1d $item, bool $withDetails): array
    {
        $marker = [
            'title' => $item->nama,
            'lat' => $item->latitude,
            'lng' => $item->longitude,
        ];

        if (! $withDetails) {
            return $marker;
        }

        return array_merge($marker, [
            'kode' => $item->kode,
            'kabKota' => $item->kab_kota,
            'kecamatan' => $item->kecamatan,
            'desaKelurahan' => $item->desa_kelurahan,
            'upt' => $item->upt,
            'elevasi' => $item->elevasi,
            'tanggalAkusisiData' => $item->tanggal_akusisi_data,
            'geologi' => $item->geologi,
            'cekunganAirTanah' => $item->cekungan_air_tanah,
            'hidrogeologi' => $item->hidrogeologi,
            'lapisanPembawaAir' => $item->lapisan_pembawa_air,
            'pdfUrl' => self::pdfUrl($item->pdf_path),
            'pdfName' => $item->pdf_path ? basename($item->pdf_path) : null,
        ]);
    }

    private static function pdfUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        return asset('storage/' . $path);
    }
}

<?php

namespace App\Models;

use App\Models\SurveyData;

final class IndonesiaMap
{
    public static function config(): array
    {
        return self::baseConfig(false);
    }

    public static function adminConfig(): array
    {
        $config = self::baseConfig(true);

        // Map UPT name → region index (0–5) for marker coloring
        $uptRegionMap = [];
        foreach (\App\Http\Controllers\AdminGeolistrik1dController::allBalai() as $index => $group) {
            foreach ($group['items'] as $item) {
                $uptRegionMap[$item['name']] = $index;
            }
        }
        $config['uptRegionMap'] = $uptRegionMap;

        return $config;
    }

    private const SURVEY_COLS = [
        'kode', 'kab_kota', 'kecamatan', 'desa_kelurahan', 'upt',
        'latitude', 'longitude', 'elevasi', 'tanggal_akusisi_data',
        'geologi', 'cekungan_air_tanah', 'hidrogeologi', 'lapisan_pembawa_air', 'pdf_path',
    ];

    private static function baseConfig(bool $withDetails): array
    {
        $geo1dCols = array_merge(self::SURVEY_COLS, ['potensi']);

        $geolistrikMarkers = Geolistrik1d::query()
            ->orderBy('kode')
            ->get($geo1dCols)
            ->map(fn (Geolistrik1d $item): array => self::markerData($item, $withDetails))
            ->values()
            ->all();

        // Survey data types
        $surveyTypeMap = [
            'geolistrik2d'   => 'geolistrik_2d',
            'pumpingTest'    => 'pumping_test',
            'boreholeCamera' => 'borehole_camera',
            'logging'        => 'logging',
        ];
        $surveyMarkers = [];
        foreach ($surveyTypeMap as $jsKey => $dbType) {
            $surveyMarkers[$jsKey] = SurveyData::where('type', $dbType)
                ->orderBy('kode')
                ->get(array_merge(['id'], self::SURVEY_COLS))
                ->map(fn (SurveyData $item): array => self::surveyMarkerData($item, $withDetails, $jsKey))
                ->values()
                ->all();
        }

        return [
            'elementId' => 'indonesiaMap',
            'detailsPanel' => [
                'enabled' => $withDetails,
                'zoom' => 18,
            ],
            'mapOptions' => [
                'zoomControl' => false,
                'scrollWheelZoom' => true,
                'maxZoom' => 18,
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
                    'position' => 'bottomright',
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
                    'active' => false,
                    'options' => [
                        'maxZoom' => 19,
                        'attribution' => '&copy; OpenStreetMap contributors',
                    ],
                ],
                [
                    'key' => 'satellite',
                    'label' => 'Satellite',
                    'url' => 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                    'active' => true,
                    'options' => [
                        'maxZoom' => 19,
                        'attribution' => 'Tiles &copy; Esri',
                    ],
                ],
                [
                    'key' => 'topografi',
                    'label' => 'Topografi',
                    'url' => 'https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png',
                    'active' => false,
                    'options' => [
                        'maxZoom' => 17,
                        'attribution' => '&copy; OpenTopoMap contributors',
                    ],
                ],
            ],
            'markers' => array_merge(
                ['geolistrik1d' => $geolistrikMarkers],
                $surveyMarkers,
            ),
        ];
    }

    private static function markerData(Geolistrik1d $item, bool $withDetails): array
    {
        $marker = [
            'dataType' => 'geolistrik1d',
            'title'    => $item->kode ?: 'Geolistrik 1D',
            'lat'      => $item->latitude,
            'lng'      => $item->longitude,
        ];

        if (! $withDetails) {
            return $marker;
        }

        return array_merge($marker, [
            'kode'              => $item->kode,
            'kabKota'           => $item->kab_kota,
            'kecamatan'         => $item->kecamatan,
            'desaKelurahan'     => $item->desa_kelurahan,
            'upt'               => $item->upt,
            'elevasi'           => $item->elevasi,
            'tanggalAkusisiData'=> $item->tanggal_akusisi_data,
            'geologi'           => $item->geologi,
            'cekunganAirTanah'  => $item->cekungan_air_tanah,
            'hidrogeologi'      => $item->hidrogeologi,
            'lapisanPembawaAir' => $item->lapisan_pembawa_air,
            'potensi'           => $item->potensi,
            'pdfUrl'            => self::pdfUrl($item->pdf_path),
            'pdfName'           => $item->pdf_path ? basename($item->pdf_path) : null,
        ]);
    }

    private static function surveyMarkerData(SurveyData $item, bool $withDetails, string $dataType): array
    {
        $marker = [
            'dataType' => $dataType,
            'title'    => $item->kode ?: $dataType,
            'lat'      => $item->latitude,
            'lng'      => $item->longitude,
        ];

        if (! $withDetails) {
            return $marker;
        }

        return array_merge($marker, [
            'kode'              => $item->kode,
            'kabKota'           => $item->kab_kota,
            'kecamatan'         => $item->kecamatan,
            'desaKelurahan'     => $item->desa_kelurahan,
            'upt'               => $item->upt,
            'elevasi'           => $item->elevasi,
            'tanggalAkusisiData'=> $item->tanggal_akusisi_data?->format('Y-m-d'),
            'geologi'           => $item->geologi,
            'cekunganAirTanah'  => $item->cekungan_air_tanah,
            'hidrogeologi'      => $item->hidrogeologi,
            'lapisanPembawaAir' => $item->lapisan_pembawa_air,
            'pdfUrl'            => self::pdfUrl($item->pdf_path),
            'pdfName'           => $item->pdf_path ? basename($item->pdf_path) : null,
        ]);
    }

    private static function pdfUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $path)) {
            return self::normalizeDriveUrl($path);
        }

        return asset('storage/' . $path);
    }

    private static function normalizeDriveUrl(string $url): string
    {
        // drive.google.com/file/d/FILE_ID/... → /preview
        if (preg_match('#drive\.google\.com/file/d/([^/?]+)#', $url, $m)) {
            return 'https://drive.google.com/file/d/' . $m[1] . '/preview';
        }

        // drive.google.com/open?id=FILE_ID
        if (preg_match('#drive\.google\.com/open\?.*\bid=([^&]+)#', $url, $m)) {
            return 'https://drive.google.com/file/d/' . $m[1] . '/preview';
        }

        return $url;
    }
}

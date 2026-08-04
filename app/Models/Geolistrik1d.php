<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Geolistrik1d extends Model
{
    protected $table = 'geolistrik_1ds';

    protected $fillable = [
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
        'potensi',
        'pdf_path',
    ];

    public function getPdfUrlAttribute(): ?string
    {
        if (! $this->pdf_path) {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $this->pdf_path)) {
            return $this->normalizeDriveUrl($this->pdf_path);
        }

        return asset('storage/' . $this->pdf_path);
    }

    public function getPdfNameAttribute(): ?string
    {
        if (! $this->pdf_path) {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $this->pdf_path)) {
            return 'Lihat PDF';
        }

        return basename($this->pdf_path);
    }

    private function normalizeDriveUrl(string $url): string
    {
        if (preg_match('#drive\.google\.com/file/d/([^/?]+)#', $url, $matches)) {
            return 'https://drive.google.com/file/d/' . $matches[1] . '/preview';
        }

        if (preg_match('#drive\.google\.com/open\?.*\bid=([^&]+)#', $url, $matches)) {
            return 'https://drive.google.com/file/d/' . $matches[1] . '/preview';
        }

        return $url;
    }
}

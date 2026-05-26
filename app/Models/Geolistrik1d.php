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
        'pdf_path',
    ];

}

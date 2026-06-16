<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyData extends Model
{
    protected $table = 'survey_data';

    protected $fillable = [
        'type',
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

    protected $casts = [
        'latitude'             => 'float',
        'longitude'            => 'float',
        'tanggal_akusisi_data' => 'date',
    ];
}

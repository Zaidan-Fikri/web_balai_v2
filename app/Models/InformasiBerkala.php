<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiBerkala extends Model
{
    use HasFactory;

    protected $fillable = ['kategori', 'tahun', 'judul', 'pdf_path', 'urutan'];

    protected $casts = ['tahun' => 'integer', 'urutan' => 'integer'];

    public static array $kategoriLabels = [
        'laporan_ppid'       => 'Laporan PPID',
        'survey_kepuasan'    => 'Laporan Survey Kepuasan',
        'maklumat_pelayanan' => 'Maklumat Pelayanan',
        'standar_pelayanan'  => 'Standar Pelayanan',
    ];
}

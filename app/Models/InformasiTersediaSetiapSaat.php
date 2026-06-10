<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiTersediaSetiapSaat extends Model
{
    use HasFactory;

    protected $fillable = ['tahun', 'judul', 'pdf_path', 'urutan'];

    protected $casts = ['tahun' => 'integer', 'urutan' => 'integer'];
}

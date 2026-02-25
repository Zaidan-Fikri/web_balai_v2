<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryaIlmiah extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'thumbnail_path',
        'pdf_path',
    ];
}

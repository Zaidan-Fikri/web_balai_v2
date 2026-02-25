<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(BeritaImage::class);
    }
}

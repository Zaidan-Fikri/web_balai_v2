<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BeritaImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'berita_id',
        'image_path',
    ];

    public function berita(): BelongsTo
    {
        return $this->belongsTo(Berita::class);
    }
}

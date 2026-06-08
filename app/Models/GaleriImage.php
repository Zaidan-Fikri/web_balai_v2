<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GaleriImage extends Model
{
    protected $table = 'galeri_images';

    protected $fillable = ['galeri_id', 'image_path', 'sort_order'];

    public function galeri(): BelongsTo
    {
        return $this->belongsTo(Galeri::class);
    }

    public function getImageUrlAttribute(): string
    {
        $path = trim((string) $this->image_path);
        if ($path === '') return '';
        if (preg_match('/^(https?:)?\/\//i', $path) === 1) return $path;
        return asset(Storage::disk('public')->url(ltrim($path, '/')));
    }
}

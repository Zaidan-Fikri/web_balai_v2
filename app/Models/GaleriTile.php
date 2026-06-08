<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GaleriTile extends Model
{
    protected $table = 'galeri_tiles';

    protected $fillable = [
        'kategori',
        'image_path',
        'background_color',
    ];

    public function getImageUrlAttribute(): string
    {
        $path = trim((string) $this->image_path);

        if ($path === '') {
            return '';
        }

        if (preg_match('/^(https?:)?\/\//i', $path) === 1) {
            return $path;
        }

        return asset(Storage::disk('public')->url(ltrim($path, '/')));
    }

    public function hasImage(): bool
    {
        return $this->image_path !== null && $this->image_path !== '';
    }
}

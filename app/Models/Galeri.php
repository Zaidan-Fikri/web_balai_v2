<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Galeri extends Model
{
    protected $table = 'galeri';

    protected $fillable = [
        'admin_user_id',
        'judul',
        'deskripsi',
        'image_path',
        'type',
        'background_color',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(GaleriImage::class)->orderBy('sort_order');
    }

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
}

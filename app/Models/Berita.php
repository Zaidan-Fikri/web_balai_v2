<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_publish',
        'video_path',
        'video_orientasi',
        'views',
        'admin_user_id',
    ];

    protected $casts = [
        'views'           => 'integer',
        'tanggal_publish' => 'date',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(BeritaImage::class)->oldest('id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(AdminUser::class, 'admin_user_id');
    }
}

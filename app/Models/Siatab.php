<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siatab extends Model
{
    use HasFactory;

    protected $table = 'siatabs';

    protected $fillable = [
        'judul',
        'image_path',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(SiatabImage::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gem extends Model
{
    use HasFactory;

    protected $table = 'gems';

    protected $fillable = [
        'judul',
        'image_path',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(GemImage::class);
    }
}

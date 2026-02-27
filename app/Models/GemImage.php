<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GemImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'gem_id',
        'image_path',
    ];

    public function gem(): BelongsTo
    {
        return $this->belongsTo(Gem::class);
    }
}

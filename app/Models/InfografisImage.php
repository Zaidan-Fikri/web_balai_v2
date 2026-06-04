<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InfografisImage extends Model
{
    protected $fillable = [
        'image_path',
    ];

    public function infografis(): BelongsTo
    {
        return $this->belongsTo(Infografis::class);
    }
}

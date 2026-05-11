<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuletinImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'buletin_id',
        'image_path',
    ];

    public function buletin(): BelongsTo
    {
        return $this->belongsTo(Buletin::class);
    }
}

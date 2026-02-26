<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiatabImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'siatab_id',
        'image_path',
    ];

    public function siatab(): BelongsTo
    {
        return $this->belongsTo(Siatab::class);
    }
}

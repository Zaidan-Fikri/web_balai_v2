<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriEdukasi extends Model
{
    protected $fillable = [
        'nama',
    ];

    public function buletins(): HasMany
    {
        return $this->hasMany(Buletin::class);
    }
}

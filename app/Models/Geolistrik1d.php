<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Geolistrik1d extends Model
{
    protected $table = 'geolistrik_1ds';

    protected $fillable = [
        'nama',
        'latitude',
        'longitude',
    ];

}

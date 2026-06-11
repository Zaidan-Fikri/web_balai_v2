<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = ['name', 'label', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    /** All available menu permission keys with their display labels. */
    public static function allMenuKeys(): array
    {
        return [
            'profil'                => 'Profil',
            'publikasi_berita'      => 'Berita',
            'publikasi_pengumuman'  => 'Pengumuman',
            'publikasi_edukasi'     => 'Edukasi',
            'publikasi_infografis'  => 'Infografis',
            'publikasi_galeri'      => 'Galeri',
            'home_thumbnail'        => 'Thumbnail',
            'home_tile'             => 'Tile Landing Page',
            'jurnal'                => 'Jurnal',
            'karya_ilmiah'          => 'Karya Ilmiah',
            'sni'                   => 'SNI',
            'informasi_publik'      => 'Informasi Publik',
            'laporan_skm'           => 'Laporan SKM',
            'geolistrik_1d'         => 'Geolistrik 1D',
        ];
    }

    public function hasPermission(string $key): bool
    {
        return in_array($key, $this->permissions ?? [], true);
    }
}

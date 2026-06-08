<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePage extends Model
{
    use HasFactory;

    public const DEFAULT_PAGES = [
        ['title' => 'Tentang Kami', 'slug' => 'tentang-kami', 'route' => 'profil.index'],
        ['title' => 'Tugas dan Fungsi', 'slug' => 'tugas-dan-fungsi', 'route' => 'profil.tugas_dan_fungsi'],
        ['title' => 'Visi dan Misi', 'slug' => 'visi-dan-misi', 'route' => 'profil.visi_misi'],
        ['title' => 'Struktur Organisasi', 'slug' => 'struktur-organisasi', 'route' => 'profil.struktur_organisasi'],
        ['title' => 'Zona Integritas', 'slug' => 'zona-integritas', 'route' => 'profil.zona_integritas'],
        ['title' => 'Lokasi dan Kontak', 'slug' => 'lokasi-dan-kontak', 'route' => 'profil.lokasi_dan_kontak'],
    ];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'sort_order',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function defaultMenu(): array
    {
        return self::DEFAULT_PAGES;
    }

    public function publicRouteName(): string
    {
        foreach (self::DEFAULT_PAGES as $page) {
            if ($page['slug'] === $this->slug) {
                return $page['route'];
            }
        }

        return 'profil.index';
    }

    public function publicUrl(): string
    {
        if ($this->isDefaultPage()) {
            return route($this->publicRouteName());
        }

        return route('profil.show', $this);
    }

    public function isDefaultPage(): bool
    {
        foreach (self::DEFAULT_PAGES as $page) {
            if ($page['slug'] === $this->slug) {
                return true;
            }
        }

        return false;
    }
}

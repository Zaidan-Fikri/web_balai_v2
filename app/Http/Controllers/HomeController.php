<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Buletin;
use App\Models\Galeri;
use App\Models\GaleriTile;
use App\Models\Infografis;
use App\Models\LaporanSkm;
use App\Models\Pengumuman;
use App\Models\ProfilePage;
use App\Models\Thumbnail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $publikasiBeritas = Berita::query()
            ->with('images')
            ->latest()
            ->take(10)
            ->get();

        $selectedHeroThumbnails = Thumbnail::query()
            ->where('show_on_home', true)
            ->latest()
            ->get();

        $heroThumbnails = $selectedHeroThumbnails->isNotEmpty()
            ? $selectedHeroThumbnails
            : Thumbnail::query()
                ->latest()
                ->get();

        $publikasiEdukasi = Buletin::query()
            ->with('images')
            ->published()
            ->latest('published_at')
            ->take(12)
            ->get();
        $publikasiInfografis = Infografis::query()
            ->with('images')
            ->latest()
            ->take(12)
            ->get();
        $pengumumans = Pengumuman::query()->latest()->take(12)->get();
        $jumlahPengaduan = 0;
        $nilaiSkm = '0%';
        $jumlahLaporanSkm = LaporanSkm::query()->count();

        $galeriTiles = GaleriTile::orderBy('id')
            ->get()
            ->keyBy(fn ($item) => strtolower($item->kategori));

        // Latest foto per kategori (auto cover)
        $latestFotoByKategori = Galeri::query()
            ->where('type', 'foto')
            ->whereNotNull('kategori')
            ->whereNotNull('image_path')
            ->where('image_path', '!=', '')
            ->latest('tanggal_publish')
            ->get()
            ->groupBy(fn ($item) => strtolower($item->kategori))
            ->map(fn ($items) => $items->first());

        // Latest video (auto cover untuk tile video)
        $latestVideo = Galeri::query()
            ->where('type', 'video')
            ->whereNotNull('image_path')
            ->where('image_path', '!=', '')
            ->latest('tanggal_publish')
            ->first();

        $profilePages = ProfilePage::query()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get()
            ->keyBy('slug');

        $aboutProfilePage = $profilePages->get('tentang-kami');
        $aboutDescription = $this->profileExcerpt(
            $aboutProfilePage?->content,
            'Balai Air Tanah merupakan unit kerja di lingkungan Direktorat Jenderal Sumber Daya Air, Kementerian Pekerjaan Umum, yang mendukung pengelolaan air tanah secara berkelanjutan melalui pelaksanaan tugas teknis sesuai kewenangannya, meliputi pelayanan teknis air tanah, pengembangan dan penerapan teknologi, pengelolaan data dan informasi, serta pengelolaan laboratorium.'
        );

        return view('pages.home', compact(
            'publikasiBeritas',
            'heroThumbnails',
            'publikasiEdukasi',
            'publikasiInfografis',
            'pengumumans',
            'jumlahPengaduan',
            'nilaiSkm',
            'jumlahLaporanSkm',
            'galeriTiles',
            'latestFotoByKategori',
            'latestVideo',
            'profilePages',
            'aboutProfilePage',
            'aboutDescription'
        ));
    }

    private function profileExcerpt(?string $content, string $fallback): string
    {
        $lines = collect(preg_split('/\R/', trim((string) $content)))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->reject(fn ($line) => in_array(strtolower(rtrim($line, ':')), [
                'visi',
                'misi',
                'tugas',
                'fungsi',
            ], true));

        $paragraph = $lines->first(fn ($line) => ! preg_match('/^(?:[-*]|\d+[\.\)]|[a-zA-Z][\.\)])\s+/', $line));

        return $paragraph
            ? Str::limit($paragraph, 320)
            : $fallback;
    }
}

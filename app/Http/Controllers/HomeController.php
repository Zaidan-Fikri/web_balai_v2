<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Buletin;
use App\Models\Infografis;
use App\Models\LaporanSkm;
use App\Models\Pengumuman;
use App\Models\Thumbnail;
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

        return view('pages.home', compact(
            'publikasiBeritas',
            'heroThumbnails',
            'publikasiEdukasi',
            'publikasiInfografis',
            'pengumumans',
            'jumlahPengaduan',
            'nilaiSkm',
            'jumlahLaporanSkm'
        ));
    }
}

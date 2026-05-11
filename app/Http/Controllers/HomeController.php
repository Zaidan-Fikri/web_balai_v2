<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Buletin;
use App\Models\KaryaIlmiah;
use App\Models\LaporanSkm;
use App\Models\Pengumuman;
use App\Models\Siatab;
use App\Models\Sni;
use App\Models\Thumbnail;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $beritas = Berita::query()
            ->with('images')
            ->latest()
            ->take(10)
            ->get();

        $heroThumbnails = Thumbnail::query()
            ->where('show_on_home', true)
            ->latest()
            ->get();

        $publikasiKaryaIlmiahs = KaryaIlmiah::query()->latest()->take(12)->get();
        $publikasiSnis = Sni::query()->latest()->take(12)->get();
        $publikasiLaporanSkms = LaporanSkm::query()->latest()->take(12)->get();
        $publikasiBuletins = Buletin::query()
            ->with('images')
            ->published()
            ->latest('published_at')
            ->take(12)
            ->get();
        $pengumumans = Pengumuman::query()->latest()->take(12)->get();
        $siatabs = Siatab::query()
            ->with('images')
            ->latest()
            ->get();

        return view('pages.home', compact(
            'beritas',
            'heroThumbnails',
            'publikasiKaryaIlmiahs',
            'publikasiSnis',
            'publikasiLaporanSkms',
            'publikasiBuletins',
            'pengumumans',
            'siatabs'
        ));
    }
}

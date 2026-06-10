<?php

namespace App\Http\Controllers;

use App\Models\InformasiBerkala;
use Illuminate\View\View;

class InformasiBerkalaController extends Controller
{
    public function index(): View
    {
        $data = InformasiBerkala::query()
            ->orderByDesc('tahun')
            ->orderBy('urutan')
            ->orderBy('judul')
            ->get()
            ->groupBy('kategori');

        $kategoriList = InformasiBerkala::$kategoriLabels;

        return view('pages.informasi_publik.informasi_berkala', compact('data', 'kategoriList'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\InformasiTersediaSetiapSaat;
use Illuminate\View\View;

class InformasiTersediaSetiapSaatController extends Controller
{
    public function index(): View
    {
        $items = InformasiTersediaSetiapSaat::query()
            ->orderByDesc('tahun')
            ->orderBy('urutan')
            ->orderBy('judul')
            ->get()
            ->groupBy('tahun');

        return view('pages.informasi_publik.informasi_tersedia_setiap_saat', compact('items'));
    }
}

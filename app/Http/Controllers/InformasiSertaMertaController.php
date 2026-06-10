<?php

namespace App\Http\Controllers;

use App\Models\InformasiSertaMerta;
use Illuminate\View\View;

class InformasiSertaMertaController extends Controller
{
    public function index(): View
    {
        $items = InformasiSertaMerta::query()
            ->orderByDesc('tahun')
            ->orderBy('urutan')
            ->orderBy('judul')
            ->get()
            ->groupBy('tahun');

        return view('pages.informasi_publik.informasi_serta_merta', compact('items'));
    }
}

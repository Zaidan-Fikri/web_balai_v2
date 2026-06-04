<?php

namespace App\Http\Controllers;

use App\Models\LaporanSkm;
use Illuminate\View\View;

class LaporanSkmController extends Controller
{
    public function index(): View
    {
        $laporanSkms = LaporanSkm::query()
            ->latest()
            ->paginate(9);

        return view('pages.pelayanan_publik.laporan_skm', compact('laporanSkms'));
    }
}

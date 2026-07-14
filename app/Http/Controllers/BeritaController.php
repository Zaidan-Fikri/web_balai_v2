<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\View\View;

class BeritaController extends Controller
{
    public function index(): View
    {
        $beritas = Berita::query()
            ->with('images')
            ->latest('tanggal_publish')
            ->paginate(9);

        return view('pages.berita.index', compact('beritas'));
    }

    public function show(Berita $berita): View
    {
        $berita->load('images');
        $berita->increment('views');

        $otherBeritas = Berita::query()
            ->with('images')
            ->where('id', '!=', $berita->id)
            ->latest('tanggal_publish')
            ->limit(5)
            ->get();

        return view('pages.berita.show', compact('berita', 'otherBeritas'));
    }
}

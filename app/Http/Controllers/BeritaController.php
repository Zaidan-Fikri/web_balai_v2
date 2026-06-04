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
            ->latest()
            ->paginate(9);

        return view('pages.berita.index', compact('beritas'));
    }

    public function show(Berita $berita): View
    {
        $berita->load('images');

        return view('pages.berita.show', compact('berita'));
    }
}

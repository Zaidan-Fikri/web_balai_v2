<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GaleriFotoController extends Controller
{
    private const CATEGORIES = [
        'Geolistrik 1D',
        'Geolistrik 2D',
        'Pumping Test',
        'Borehole Camera',
        'Logger',
        'Kegiatan Balai Air Tanah',
        'Laboratorium',
    ];

    public function index(Request $request): View
    {
        $kategori = $request->query('kategori');

        if ($kategori && ! in_array($kategori, self::CATEGORIES, true)) {
            $kategori = null;
        }

        $fotos = Galeri::query()
            ->with('images')
            ->where('type', 'foto')
            ->when($kategori, fn ($q) => $q->where('kategori', $kategori))
            ->latest('tanggal_publish')
            ->paginate(6)
            ->withQueryString();
        $fotos->withPath(url('publikasi/galeri/foto'));

        return view('pages.galeri.foto', [
            'fotos'      => $fotos,
            'kategori'   => $kategori,
            'categories' => self::CATEGORIES,
        ]);
    }
}

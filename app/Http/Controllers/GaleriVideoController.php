<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GaleriVideoController extends Controller
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

        $videos = Galeri::query()
            ->where('type', 'video')
            ->whereNotNull('video_path')
            ->where('video_path', '!=', '')
            ->when($kategori, fn ($q) => $q->where('kategori', $kategori))
            ->latest('tanggal_publish')
            ->paginate(12)
            ->withQueryString();

        return view('pages.galeri.video', [
            'videos'     => $videos,
            'kategori'   => $kategori,
            'categories' => self::CATEGORIES,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreBeritaRequest;
use App\Http\Requests\Admin\UpdateBeritaRequest;
use App\Models\Berita;
use App\Services\Admin\GalleryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminBeritaController extends Controller
{
    private const IMAGE_DIR = 'berita-images';

    public function __construct(private readonly GalleryService $gallery)
    {
    }

    public function index(): View
    {
        $beritas = Berita::query()
            ->with('images')
            ->latest()
            ->get();

        return view('pages.admin.berita', compact('beritas'));
    }

    public function store(StoreBeritaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $berita = Berita::create([
                'judul' => $data['judul'],
                'deskripsi' => $data['deskripsi'],
            ]);

            $paths = $this->gallery->storeFiles($data['images'], self::IMAGE_DIR);
            $this->gallery->attachStoredImages($berita, $paths);
        });

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(UpdateBeritaRequest $request, Berita $berita): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($berita, $data) {
            $berita->update([
                'judul' => $data['judul'],
                'deskripsi' => $data['deskripsi'],
            ]);

            $this->gallery->syncImages(
                $berita,
                $data['images'] ?? [],
                $data['remove_image_ids'] ?? [],
                self::IMAGE_DIR,
                'Minimal harus ada 1 gambar untuk setiap berita.'
            );
        });

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita): RedirectResponse
    {
        DB::transaction(function () use ($berita) {
            $this->gallery->deleteModelWithImages($berita);
        });

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}

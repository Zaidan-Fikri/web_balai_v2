<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGemRequest;
use App\Models\Gem;
use App\Services\Admin\GalleryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminGemController extends Controller
{
    private const IMAGE_DIR = 'gem-images';

    public function __construct(private readonly GalleryService $gallery)
    {
    }

    public function index(): View
    {
        $gems = Gem::query()
            ->with('images')
            ->latest()
            ->get();

        return view('pages.admin.gems', compact('gems'));
    }

    public function store(StoreGalleryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $paths = $this->gallery->storeFiles($data['images'], self::IMAGE_DIR);

            $gem = Gem::create([
                'judul' => $data['judul'],
                'image_path' => $paths[0],
            ]);

            $this->gallery->attachStoredImages($gem, $paths);
        });

        return redirect()
            ->route('admin.gems.index')
            ->with('success', 'GEMS berhasil ditambahkan.');
    }

    public function update(UpdateGemRequest $request, Gem $gem): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($gem, $data) {
            $gem->update([
                'judul' => $data['judul'],
            ]);

            $this->gallery->syncImages(
                $gem,
                $data['images'] ?? [],
                $data['remove_image_ids'] ?? [],
                self::IMAGE_DIR,
                'Minimal harus ada 1 gambar untuk setiap data GEMS.'
            );
        });

        return redirect()
            ->route('admin.gems.index')
            ->with('success', 'GEMS berhasil diperbarui.');
    }

    public function destroy(Gem $gem): RedirectResponse
    {
        DB::transaction(function () use ($gem) {
            $this->gallery->deleteModelWithImages($gem);
        });

        return redirect()
            ->route('admin.gems.index')
            ->with('success', 'GEMS berhasil dihapus.');
    }
}

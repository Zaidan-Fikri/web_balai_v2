<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateSiatabRequest;
use App\Models\Siatab;
use App\Services\Admin\GalleryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminSiatabController extends Controller
{
    private const IMAGE_DIR = 'siatab-images';

    public function __construct(private readonly GalleryService $gallery)
    {
    }

    public function index(): View
    {
        $siatabs = Siatab::query()
            ->with('images')
            ->latest()
            ->get();

        return view('pages.admin.siatab', compact('siatabs'));
    }

    public function store(StoreGalleryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $paths = $this->gallery->storeFiles($data['images'], self::IMAGE_DIR);

            $siatab = Siatab::create([
                'judul' => $data['judul'],
                'image_path' => $paths[0],
            ]);

            $this->gallery->attachStoredImages($siatab, $paths);
        });

        return redirect()
            ->route('admin.siatab.index')
            ->with('success', 'SIATAB berhasil ditambahkan.');
    }

    public function update(UpdateSiatabRequest $request, Siatab $siatab): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($siatab, $data) {
            $siatab->update([
                'judul' => $data['judul'],
            ]);

            $this->gallery->syncImages(
                $siatab,
                $data['images'] ?? [],
                $data['remove_image_ids'] ?? [],
                self::IMAGE_DIR,
                'Minimal harus ada 1 gambar untuk setiap data SIATAB.'
            );
        });

        return redirect()
            ->route('admin.siatab.index')
            ->with('success', 'SIATAB berhasil diperbarui.');
    }

    public function destroy(Siatab $siatab): RedirectResponse
    {
        DB::transaction(function () use ($siatab) {
            $this->gallery->deleteModelWithImages($siatab);
        });

        return redirect()
            ->route('admin.siatab.index')
            ->with('success', 'SIATAB berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\UpdateGaleriTileRequest;
use App\Models\GaleriTile;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminGaleriTileController extends Controller
{
    private const IMAGE_DIR = 'galeri_tiles';

    public function __construct(private readonly FileUploadService $files)
    {
    }

    public function index(): View
    {
        $tiles = GaleriTile::orderBy('id')->get();

        return view('pages.admin.galeri_tile', compact('tiles'));
    }

    public function destroyImage(GaleriTile $galeriTile): RedirectResponse
    {
        if ($galeriTile->hasImage()) {
            $this->files->delete($galeriTile->image_path);
        }

        $galeriTile->update(['image_path' => null, 'background_color' => '#0d2d5e']);

        return redirect()
            ->route('admin.galeri-tile.index')
            ->with('success', 'Foto tile "' . $galeriTile->kategori . '" berhasil dihapus.');
    }

    public function update(UpdateGaleriTileRequest $request, GaleriTile $galeriTile): RedirectResponse
    {
        $data = $request->validated();

        $imagePath = $galeriTile->image_path;
        if (! empty($data['image'])) {
            $imagePath = $galeriTile->hasImage()
                ? $this->files->replace($galeriTile->image_path, $data['image'], self::IMAGE_DIR)
                : $this->files->store($data['image'], self::IMAGE_DIR);
        }

        $galeriTile->update([
            'image_path'       => $imagePath,
            'background_color' => $data['background_color'] ?? $galeriTile->background_color,
        ]);

        return redirect()
            ->route('admin.galeri-tile.index')
            ->with('success', 'Tile "' . $galeriTile->kategori . '" berhasil diperbarui.');
    }
}

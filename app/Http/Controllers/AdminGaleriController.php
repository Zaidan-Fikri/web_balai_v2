<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreGaleriRequest;
use App\Http\Requests\Admin\UpdateGaleriRequest;
use App\Models\Galeri;
use App\Models\GaleriImage;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminGaleriController extends Controller
{
    private const IMAGE_DIR = 'galeri';

    public function __construct(private readonly FileUploadService $files)
    {
    }

    public function index(): View
    {
        $galeris = Galeri::query()
            ->with(['author', 'images'])
            ->latest()
            ->get();

        return view('pages.admin.galeri', compact('galeris'));
    }

    public function store(StoreGaleriRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $galeri = Galeri::create([
            'admin_user_id'    => $request->session()->get('admin_user_id'),
            'judul'            => $data['judul'],
            'deskripsi'        => $data['deskripsi'] ?? null,
            'type'             => $data['type'],
            'background_color' => $data['background_color'] ?? null,
            'image_path'       => $this->files->store($data['image'], self::IMAGE_DIR),
        ]);

        foreach (($data['extra_images'] ?? []) as $i => $file) {
            $galeri->images()->create([
                'image_path' => $this->files->store($file, self::IMAGE_DIR),
                'sort_order' => $i,
            ]);
        }

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Item galeri berhasil ditambahkan.');
    }

    public function update(UpdateGaleriRequest $request, Galeri $galeri): RedirectResponse
    {
        $data = $request->validated();

        $imagePath = $galeri->image_path;
        if (! empty($data['image'])) {
            $imagePath = $this->files->replace($galeri->image_path, $data['image'], self::IMAGE_DIR);
        }

        $galeri->update([
            'judul'            => $data['judul'],
            'deskripsi'        => $data['deskripsi'] ?? null,
            'type'             => $data['type'],
            'background_color' => $data['background_color'] ?? null,
            'image_path'       => $imagePath,
        ]);

        foreach (($data['extra_images'] ?? []) as $i => $file) {
            $galeri->images()->create([
                'image_path' => $this->files->store($file, self::IMAGE_DIR),
                'sort_order' => $galeri->images()->count() + $i,
            ]);
        }

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Item galeri berhasil diperbarui.');
    }

    public function destroyImage(Galeri $galeri, GaleriImage $galeriImage): RedirectResponse
    {
        abort_if($galeriImage->galeri_id !== $galeri->id, 404);
        $this->files->delete($galeriImage->image_path);
        $galeriImage->delete();

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Foto tambahan berhasil dihapus.');
    }

    public function destroy(Galeri $galeri): RedirectResponse
    {
        foreach ($galeri->images as $img) {
            $this->files->delete($img->image_path);
        }
        $this->files->delete($galeri->image_path);
        $galeri->delete();

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Item galeri berhasil dihapus.');
    }
}

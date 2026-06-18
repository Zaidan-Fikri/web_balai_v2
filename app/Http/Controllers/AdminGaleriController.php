<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreGaleriRequest;
use App\Http\Requests\Admin\UpdateGaleriRequest;
use App\Models\Galeri;
use App\Models\GaleriImage;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminGaleriController extends Controller
{
    private const IMAGE_DIR = 'galeri';
    private const VIDEO_DIR = 'galeri-videos';

    public function __construct(private readonly FileUploadService $files)
    {
    }

    public function index(): View
    {
        $galeris = Galeri::query()
            ->with(['author', 'images'])
            ->latest('tanggal_publish')
            ->get();

        return view('pages.admin.galeri', compact('galeris'));
    }

    public function store(StoreGaleriRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $galleryImages = $data['images'] ?? [];

        if (! empty($galleryImages)) {
            $imagePath = $this->files->storeImage(array_shift($galleryImages), self::IMAGE_DIR);
        } else {
            $imagePath = $request->hasFile('image')
                ? $this->files->storeImage($data['image'], self::IMAGE_DIR)
                : '';
        }

        $videoPath = null;
        if ($data['type'] === 'video' && $request->hasFile('video')) {
            $videoPath = $request->file('video')->store(self::VIDEO_DIR, 'public');
        }

        $galeri = Galeri::create([
            'admin_user_id'    => $request->session()->get('admin_user_id'),
            'kategori'         => $data['kategori'] ?? null,
            'judul'            => $data['judul'],
            'deskripsi'        => $data['deskripsi'] ?? null,
            'type'             => $data['type'],
            'tanggal_publish'  => $data['tanggal_publish'] ?? now(),
            'image_path'       => $imagePath,
            'video_path'       => $videoPath,
            'background_color' => $data['background_color'] ?? null,
        ]);

        $extraImages = array_values(array_filter([
            ...$galleryImages,
            ...($data['extra_images'] ?? []),
        ]));

        foreach ($extraImages as $i => $file) {
            if (! $file) {
                continue;
            }

            $galeri->images()->create([
                'image_path' => $this->files->storeImage($file, self::IMAGE_DIR),
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
        if ($request->hasFile('image')) {
            $imagePath = $this->files->replaceImage($galeri->image_path, $data['image'], self::IMAGE_DIR);
        }

        $videoPath = $galeri->video_path;
        if (!empty($data['remove_video'])) {
            if ($galeri->video_path) {
                Storage::disk('public')->delete($galeri->video_path);
            }
            $videoPath = null;
        } elseif ($request->hasFile('video')) {
            if ($galeri->video_path) {
                Storage::disk('public')->delete($galeri->video_path);
            }
            $videoPath = $request->file('video')->store(self::VIDEO_DIR, 'public');
        }

        $galeri->update([
            'kategori'         => $data['kategori'] ?? null,
            'judul'            => $data['judul'],
            'deskripsi'        => $data['deskripsi'] ?? null,
            'type'             => $data['type'],
            'tanggal_publish'  => $data['tanggal_publish'] ?? $galeri->tanggal_publish,
            'image_path'       => $imagePath,
            'video_path'       => $videoPath,
            'background_color' => $data['background_color'] ?? null,
        ]);

        $currentImageCount = $galeri->images()->count();
        foreach (($data['extra_images'] ?? []) as $i => $file) {
            if (! $file) {
                continue;
            }

            $galeri->images()->create([
                'image_path' => $this->files->storeImage($file, self::IMAGE_DIR),
                'sort_order' => $currentImageCount + $i,
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
        if ($galeri->image_path) {
            $this->files->delete($galeri->image_path);
        }
        if ($galeri->video_path) {
            Storage::disk('public')->delete($galeri->video_path);
        }
        $galeri->delete();

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Item galeri berhasil dihapus.');
    }
}

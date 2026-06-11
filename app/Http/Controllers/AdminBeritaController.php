<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreBeritaRequest;
use App\Http\Requests\Admin\UpdateBeritaRequest;
use App\Models\Berita;
use App\Services\Admin\GalleryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminBeritaController extends Controller
{
    private const IMAGE_DIR = 'berita-images';
    private const VIDEO_DIR = 'berita-videos';

    public function __construct(private readonly GalleryService $gallery)
    {
    }

    public function index(): View
    {
        $beritas = Berita::query()
            ->with(['images', 'author'])
            ->latest()
            ->get();

        return view('pages.admin.berita', compact('beritas'));
    }

    public function store(StoreBeritaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request) {
            $videoPath = null;
            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store(self::VIDEO_DIR, 'public');
            }

            $berita = Berita::create([
                'judul'           => $data['judul'],
                'deskripsi'       => $data['deskripsi'],
                'video_path'      => $videoPath,
                'video_orientasi' => $data['video_orientasi'] ?? 'landscape',
                'admin_user_id'   => auth()->id(),
            ]);

            if (!empty($data['images'])) {
                $paths = $this->gallery->storeFiles($data['images'], self::IMAGE_DIR);
                $this->gallery->attachStoredImages($berita, $paths);
            }
        });

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(UpdateBeritaRequest $request, Berita $berita): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($berita, $data, $request) {
            $berita->update([
                'judul'     => $data['judul'],
                'deskripsi' => $data['deskripsi'],
            ]);

            // Handle video
            if (!empty($data['remove_video'])) {
                if ($berita->video_path) {
                    Storage::disk('public')->delete($berita->video_path);
                }
                $berita->update(['video_path' => null, 'video_orientasi' => 'landscape']);
            } elseif ($request->hasFile('video')) {
                if ($berita->video_path) {
                    Storage::disk('public')->delete($berita->video_path);
                }
                $videoPath = $request->file('video')->store(self::VIDEO_DIR, 'public');
                $berita->update([
                    'video_path'      => $videoPath,
                    'video_orientasi' => $data['video_orientasi'] ?? 'landscape',
                ]);
            } elseif (isset($data['video_orientasi'])) {
                $berita->update(['video_orientasi' => $data['video_orientasi']]);
            }

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
            if ($berita->video_path) {
                Storage::disk('public')->delete($berita->video_path);
            }
            $this->gallery->deleteModelWithImages($berita);
        });

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}

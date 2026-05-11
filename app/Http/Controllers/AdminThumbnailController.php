<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreThumbnailRequest;
use App\Http\Requests\Admin\ThumbnailVisibilityRequest;
use App\Http\Requests\Admin\UpdateThumbnailRequest;
use App\Models\Thumbnail;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminThumbnailController extends Controller
{
    private const IMAGE_DIR = 'thumbnails';

    public function __construct(private readonly FileUploadService $files)
    {
    }

    public function index(): View
    {
        $thumbnails = Thumbnail::query()
            ->latest()
            ->get();

        return view('pages.admin.thumbnail', compact('thumbnails'));
    }

    public function store(StoreThumbnailRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Thumbnail::create([
            'image_path' => $this->files->store($data['image'], self::IMAGE_DIR),
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.thumbnail.index')
            ->with('success', 'Thumbnail berhasil ditambahkan.');
    }

    public function update(UpdateThumbnailRequest $request, Thumbnail $thumbnail): RedirectResponse
    {
        $data = $request->validated();
        $imagePath = $thumbnail->image_path;

        if (! empty($data['image'])) {
            $imagePath = $this->files->replace($thumbnail->image_path, $data['image'], self::IMAGE_DIR);
        }

        $thumbnail->update([
            'image_path' => $imagePath,
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.thumbnail.index')
            ->with('success', 'Thumbnail berhasil diperbarui.');
    }

    public function destroy(Thumbnail $thumbnail): RedirectResponse
    {
        $this->files->delete($thumbnail->image_path);
        $thumbnail->delete();

        return redirect()
            ->route('admin.thumbnail.index')
            ->with('success', 'Thumbnail berhasil dihapus.');
    }

    public function updateVisibility(ThumbnailVisibilityRequest $request): RedirectResponse
    {
        $selectedIds = collect($request->validated()['selected_thumbnail_ids'] ?? [])
            ->map(function ($id) {
                return (int) $id;
            })
            ->unique()
            ->values()
            ->all();

        DB::transaction(function () use ($selectedIds) {
            Thumbnail::query()->update(['show_on_home' => false]);

            if (! empty($selectedIds)) {
                Thumbnail::query()
                    ->whereIn('id', $selectedIds)
                    ->update(['show_on_home' => true]);
            }
        });

        return redirect()
            ->route('admin.thumbnail.index')
            ->with('success', 'Pilihan thumbnail untuk halaman utama berhasil disimpan.');
    }
}

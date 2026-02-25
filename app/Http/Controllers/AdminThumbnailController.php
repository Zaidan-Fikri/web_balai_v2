<?php

namespace App\Http\Controllers;

use App\Models\Thumbnail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminThumbnailController extends Controller
{
    public function index()
    {
        $thumbnails = Thumbnail::query()
            ->latest()
            ->get();

        return view('pages.admin.thumbnail', compact('thumbnails'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $path = $validated['image']->store('thumbnails', 'public');

        Thumbnail::create([
            'image_path' => $path,
        ]);

        return redirect()
            ->route('admin.thumbnail')
            ->with('success', 'Thumbnail berhasil ditambahkan.');
    }

    public function update(Request $request, Thumbnail $thumbnail)
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if (! empty($thumbnail->image_path)) {
            Storage::disk('public')->delete($thumbnail->image_path);
        }

        $path = $validated['image']->store('thumbnails', 'public');

        $thumbnail->update([
            'image_path' => $path,
        ]);

        return redirect()
            ->route('admin.thumbnail')
            ->with('success', 'Thumbnail berhasil diperbarui.');
    }

    public function destroy(Thumbnail $thumbnail)
    {
        if (! empty($thumbnail->image_path)) {
            Storage::disk('public')->delete($thumbnail->image_path);
        }

        $thumbnail->delete();

        return redirect()
            ->route('admin.thumbnail')
            ->with('success', 'Thumbnail berhasil dihapus.');
    }

    public function updateVisibility(Request $request)
    {
        $validated = $request->validate([
            'selected_thumbnail_ids' => ['nullable', 'array'],
            'selected_thumbnail_ids.*' => ['integer', 'exists:thumbnails,id'],
        ]);

        $selectedIds = collect($validated['selected_thumbnail_ids'] ?? [])
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        Thumbnail::query()->update(['show_on_home' => false]);

        if (! empty($selectedIds)) {
            Thumbnail::query()
                ->whereIn('id', $selectedIds)
                ->update(['show_on_home' => true]);
        }

        return redirect()
            ->route('admin.thumbnail')
            ->with('success', 'Pilihan thumbnail untuk halaman utama berhasil disimpan.');
    }
}

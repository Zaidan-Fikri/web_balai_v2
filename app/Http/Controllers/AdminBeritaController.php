<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminBeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::query()
            ->with('images')
            ->latest()
            ->get();

        return view('pages.admin.berita', compact('beritas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        DB::transaction(function () use ($validated) {
            $berita = Berita::create([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
            ]);

            foreach ($validated['images'] as $image) {
                $path = $image->store('berita-images', 'public');

                $berita->images()->create([
                    'image_path' => $path,
                ]);
            }
        });

        return redirect()
            ->route('admin.berita')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, Berita $berita)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => ['integer', 'exists:berita_images,id'],
        ]);

        DB::transaction(function () use ($berita, $validated) {
            $berita->update([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
            ]);

            $removeIds = collect($validated['remove_image_ids'] ?? [])
                ->map(fn ($id) => (int) $id)
                ->all();

            if (! empty($removeIds)) {
                $imagesToDelete = $berita->images()
                    ->whereIn('id', $removeIds)
                    ->get();

                $paths = $imagesToDelete
                    ->pluck('image_path')
                    ->filter()
                    ->values()
                    ->all();

                if (! empty($paths)) {
                    Storage::disk('public')->delete($paths);
                }

                $berita->images()->whereIn('id', $removeIds)->delete();
            }

            foreach ($validated['images'] ?? [] as $image) {
                $path = $image->store('berita-images', 'public');

                $berita->images()->create([
                    'image_path' => $path,
                ]);
            }
        });

        return redirect()
            ->route('admin.berita')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        DB::transaction(function () use ($berita) {
            $paths = $berita->images()
                ->pluck('image_path')
                ->filter()
                ->values()
                ->all();

            if (! empty($paths)) {
                Storage::disk('public')->delete($paths);
            }

            $berita->delete();
        });

        return redirect()
            ->route('admin.berita')
            ->with('success', 'Berita berhasil dihapus.');
    }
}

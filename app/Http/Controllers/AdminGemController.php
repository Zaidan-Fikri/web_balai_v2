<?php

namespace App\Http\Controllers;

use App\Models\Gem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AdminGemController extends Controller
{
    public function index()
    {
        $gems = Gem::query()
            ->with('images')
            ->latest()
            ->get();

        return view('pages.admin.gems', compact('gems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        DB::transaction(function () use ($validated) {
            $firstPath = $validated['images'][0]->store('gem-images', 'public');

            $gem = Gem::create([
                'judul' => $validated['judul'],
                'image_path' => $firstPath,
            ]);

            $gem->images()->create([
                'image_path' => $firstPath,
            ]);

            foreach (array_slice($validated['images'], 1) as $image) {
                $path = $image->store('gem-images', 'public');
                $gem->images()->create([
                    'image_path' => $path,
                ]);
            }
        });

        return redirect()
            ->route('admin.gems')
            ->with('success', 'GEMS berhasil ditambahkan.');
    }

    public function update(Request $request, Gem $gem)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => ['integer', 'exists:gem_images,id'],
        ]);

        DB::transaction(function () use ($gem, $validated) {
            $gem->update([
                'judul' => $validated['judul'],
            ]);

            $removeIds = collect($validated['remove_image_ids'] ?? [])
                ->map(fn ($id) => (int) $id)
                ->all();

            if (!empty($removeIds)) {
                $imagesToDelete = $gem->images()
                    ->whereIn('id', $removeIds)
                    ->get();

                $paths = $imagesToDelete
                    ->pluck('image_path')
                    ->filter()
                    ->values()
                    ->all();

                if (!empty($paths)) {
                    Storage::disk('public')->delete($paths);
                }

                $gem->images()->whereIn('id', $removeIds)->delete();
            }

            foreach ($validated['images'] ?? [] as $image) {
                $path = $image->store('gem-images', 'public');
                $gem->images()->create([
                    'image_path' => $path,
                ]);
            }

            $latestImages = $gem->images()
                ->oldest('id')
                ->get();

            if ($latestImages->isEmpty()) {
                throw ValidationException::withMessages([
                    'images' => 'Minimal harus ada 1 gambar untuk setiap data GEMS.',
                ]);
            }

            $gem->update([
                'image_path' => $latestImages->first()->image_path,
            ]);
        });

        return redirect()
            ->route('admin.gems')
            ->with('success', 'GEMS berhasil diperbarui.');
    }

    public function destroy(Gem $gem)
    {
        DB::transaction(function () use ($gem) {
            $paths = $gem->images()
                ->pluck('image_path')
                ->filter()
                ->values()
                ->all();

            if (!empty($gem->image_path)) {
                $paths[] = $gem->image_path;
            }

            if (!empty($paths)) {
                Storage::disk('public')->delete(array_values(array_unique($paths)));
            }

            $gem->delete();
        });

        return redirect()
            ->route('admin.gems')
            ->with('success', 'GEMS berhasil dihapus.');
    }
}

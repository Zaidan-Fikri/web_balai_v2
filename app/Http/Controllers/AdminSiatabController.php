<?php

namespace App\Http\Controllers;

use App\Models\Siatab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AdminSiatabController extends Controller
{
    public function index()
    {
        $siatabs = Siatab::query()
            ->with('images')
            ->latest()
            ->get();

        return view('pages.admin.siatab', compact('siatabs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        DB::transaction(function () use ($validated) {
            $firstPath = $validated['images'][0]->store('siatab-images', 'public');

            $siatab = Siatab::create([
                'judul' => $validated['judul'],
                'image_path' => $firstPath,
            ]);

            $siatab->images()->create([
                'image_path' => $firstPath,
            ]);

            foreach (array_slice($validated['images'], 1) as $image) {
                $path = $image->store('siatab-images', 'public');
                $siatab->images()->create([
                    'image_path' => $path,
                ]);
            }
        });

        return redirect()
            ->route('admin.siatab')
            ->with('success', 'SIATAB berhasil ditambahkan.');
    }

    public function update(Request $request, Siatab $siatab)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image_ids' => ['nullable', 'array'],
            'remove_image_ids.*' => ['integer', 'exists:siatab_images,id'],
        ]);

        DB::transaction(function () use ($siatab, $validated) {
            $siatab->update([
                'judul' => $validated['judul'],
            ]);

            $removeIds = collect($validated['remove_image_ids'] ?? [])
                ->map(fn ($id) => (int) $id)
                ->all();

            if (!empty($removeIds)) {
                $imagesToDelete = $siatab->images()
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

                $siatab->images()->whereIn('id', $removeIds)->delete();
            }

            foreach ($validated['images'] ?? [] as $image) {
                $path = $image->store('siatab-images', 'public');
                $siatab->images()->create([
                    'image_path' => $path,
                ]);
            }

            $latestImages = $siatab->images()
                ->oldest('id')
                ->get();

            if ($latestImages->isEmpty()) {
                throw ValidationException::withMessages([
                    'images' => 'Minimal harus ada 1 gambar untuk setiap data SIATAB.',
                ]);
            }

            $siatab->update([
                'image_path' => $latestImages->first()->image_path,
            ]);
        });

        return redirect()
            ->route('admin.siatab')
            ->with('success', 'SIATAB berhasil diperbarui.');
    }

    public function destroy(Siatab $siatab)
    {
        DB::transaction(function () use ($siatab) {
            $paths = $siatab->images()
                ->pluck('image_path')
                ->filter()
                ->values()
                ->all();

            if (!empty($siatab->image_path)) {
                $paths[] = $siatab->image_path;
            }

            if (!empty($paths)) {
                Storage::disk('public')->delete(array_values(array_unique($paths)));
            }

            $siatab->delete();
        });

        return redirect()
            ->route('admin.siatab')
            ->with('success', 'SIATAB berhasil dihapus.');
    }
}

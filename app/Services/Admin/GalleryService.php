<?php

namespace App\Services\Admin;

use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class GalleryService
{
    public function __construct(private readonly FileUploadService $files)
    {
    }

    public function storeFiles(array $images, string $directory): array
    {
        return collect($images)
            ->map(fn ($image) => $this->files->store($image, $directory))
            ->all();
    }

    public function attachStoredImages(Model $model, array $paths): void
    {
        foreach ($paths as $path) {
            $model->images()->create([
                'image_path' => $path,
            ]);
        }
    }

    public function syncImages(Model $model, array $newImages, array $removeIds, string $directory, string $emptyMessage): void
    {
        $removeIds = $this->normalizeIds($removeIds);
        $this->ensureGalleryWillNotBeEmpty($model, $newImages, $removeIds, $emptyMessage);

        $this->deleteSelectedImages($model, $removeIds);
        $this->attachStoredImages($model, $this->storeFiles($newImages, $directory));

        $firstImage = $model->images()
            ->oldest('id')
            ->first();

        if (! $firstImage) {
            throw ValidationException::withMessages([
                'images' => $emptyMessage,
            ]);
        }

        if (in_array('image_path', $model->getFillable(), true)) {
            $model->update([
                'image_path' => $firstImage->image_path,
            ]);
        }
    }

    public function deleteModelWithImages(Model $model): void
    {
        $paths = $model->images()
            ->pluck('image_path')
            ->filter()
            ->values()
            ->all();

        if (in_array('image_path', $model->getFillable(), true)) {
            $paths[] = $model->image_path;
        }

        $this->files->deleteMany($paths);
        $model->delete();
    }

    private function ensureGalleryWillNotBeEmpty(Model $model, array $newImages, array $removeIds, string $emptyMessage): void
    {
        $remainingImages = $model->images()
            ->when(! empty($removeIds), fn ($query) => $query->whereNotIn('id', $removeIds))
            ->count();

        if (($remainingImages + count($newImages)) < 1) {
            throw ValidationException::withMessages([
                'images' => $emptyMessage,
            ]);
        }
    }

    private function deleteSelectedImages(Model $model, array $ids): void
    {
        if (empty($ids)) {
            return;
        }

        $images = $model->images()
            ->whereIn('id', $ids)
            ->get();

        $this->files->deleteMany($images->pluck('image_path')->all());
        $model->images()->whereIn('id', $ids)->delete();
    }

    private function normalizeIds(array $ids): array
    {
        return collect($ids)
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }
}

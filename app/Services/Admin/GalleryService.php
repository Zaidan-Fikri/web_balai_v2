<?php

namespace App\Services\Admin;

use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class GalleryService
{
    /** @var FileUploadService */
    private $files;

    public function __construct(FileUploadService $files)
    {
        $this->files = $files;
    }

    public function storeFiles(array $images, string $directory): array
    {
        return collect($images)
            ->map(function ($image) use ($directory) {
                return $this->files->store($image, $directory);
            })
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

    private function deleteSelectedImages(Model $model, array $ids): void
    {
        $ids = collect($ids)
            ->map(function ($id) {
                return (int) $id;
            })
            ->unique()
            ->values()
            ->all();

        if (empty($ids)) {
            return;
        }

        $images = $model->images()
            ->whereIn('id', $ids)
            ->get();

        $this->files->deleteMany($images->pluck('image_path')->all());
        $model->images()->whereIn('id', $ids)->delete();
    }
}

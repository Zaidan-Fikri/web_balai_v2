<?php

namespace App\Services\Admin;

use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DocumentService
{
    public function __construct(private readonly FileUploadService $files)
    {
    }

    public function create(string $modelClass, array $data, string $thumbnailDir, string $pdfDir): Model
    {
        return DB::transaction(function () use ($modelClass, $data, $thumbnailDir, $pdfDir): Model {
            return $modelClass::create([
                'judul' => $data['judul'],
                'deskripsi' => $data['deskripsi'],
                'thumbnail_path' => $this->files->store($data['thumbnail'], $thumbnailDir),
                'pdf_path' => $this->files->store($data['pdf'], $pdfDir),
            ]);
        });
    }

    public function update(Model $model, array $data, string $thumbnailDir, string $pdfDir): void
    {
        DB::transaction(function () use ($model, $data, $thumbnailDir, $pdfDir): void {
            $thumbnailPath = $model->thumbnail_path;
            $pdfPath = $model->pdf_path;

            if (! empty($data['thumbnail'])) {
                $thumbnailPath = $this->files->replace($model->thumbnail_path, $data['thumbnail'], $thumbnailDir);
            }

            if (! empty($data['pdf'])) {
                $pdfPath = $this->files->replace($model->pdf_path, $data['pdf'], $pdfDir);
            }

            $model->update([
                'judul' => $data['judul'],
                'deskripsi' => $data['deskripsi'],
                'thumbnail_path' => $thumbnailPath,
                'pdf_path' => $pdfPath,
            ]);
        });
    }

    public function delete(Model $model): void
    {
        DB::transaction(function () use ($model): void {
            $this->files->deleteMany([
                $model->thumbnail_path,
                $model->pdf_path,
            ]);

            $model->delete();
        });
    }
}

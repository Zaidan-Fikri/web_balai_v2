<?php

namespace App\Services;

use InvalidArgumentException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    private const DISK = 'public';

    public function store(UploadedFile $file, string $directory): string
    {
        return $file->store($this->safeDirectory($directory), self::DISK);
    }

    public function replace(?string $oldPath, UploadedFile $file, string $directory): string
    {
        $newPath = $this->store($file, $directory);
        $this->delete($oldPath);

        return $newPath;
    }

    public function delete(?string $path): void
    {
        if (! empty($path)) {
            Storage::disk(self::DISK)->delete($path);
        }
    }

    public function deleteMany(array $paths): void
    {
        $paths = collect($paths)
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (! empty($paths)) {
            Storage::disk(self::DISK)->delete($paths);
        }
    }

    private function safeDirectory(string $directory): string
    {
        $directory = trim(str_replace('\\', '/', $directory), '/');

        if ($directory === '' || str_contains($directory, '..')) {
            throw new InvalidArgumentException('Direktori upload tidak valid.');
        }

        return $directory;
    }
}

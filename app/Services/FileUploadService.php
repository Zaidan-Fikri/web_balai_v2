<?php

namespace App\Services;

use InvalidArgumentException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class FileUploadService
{
    private const DISK = 'public';

    /** Max panjang sisi terpanjang gambar (px) */
    private const MAX_DIMENSION = 1920;

    /** Kualitas JPEG/WebP setelah kompresi (0–100) */
    private const QUALITY = 85;

    /**
     * Simpan file mentah (PDF, video, dll — tanpa kompresi).
     */
    public function store(UploadedFile $file, string $directory): string
    {
        return $file->store($this->safeDirectory($directory), self::DISK);
    }

    /**
     * Simpan gambar dengan kompresi & resize otomatis.
     * Hasil selalu disimpan sebagai JPEG agar ukuran konsisten.
     */
    public function storeImage(UploadedFile $file, string $directory): string
    {
        $dir      = $this->safeDirectory($directory);
        $filename = Str::uuid() . '.jpg';
        $path     = $dir . '/' . $filename;

        $image = Image::read($file->getRealPath());

        // Hanya perkecil jika lebih besar dari MAX_DIMENSION, tidak pernah perbesar
        $image->scaleDown(self::MAX_DIMENSION, self::MAX_DIMENSION);

        Storage::disk(self::DISK)->put($path, $image->toJpeg(self::QUALITY));

        return $path;
    }

    /**
     * Ganti file lama dengan file baru (mentah).
     */
    public function replace(?string $oldPath, UploadedFile $file, string $directory): string
    {
        $newPath = $this->store($file, $directory);
        $this->delete($oldPath);

        return $newPath;
    }

    /**
     * Ganti gambar lama dengan gambar baru yang sudah dikompres.
     */
    public function replaceImage(?string $oldPath, UploadedFile $file, string $directory): string
    {
        $newPath = $this->storeImage($file, $directory);
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

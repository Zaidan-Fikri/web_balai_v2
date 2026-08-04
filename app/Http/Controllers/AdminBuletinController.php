<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreBuletinRequest;
use App\Http\Requests\Admin\UpdateBuletinRequest;
use App\Models\Buletin;
use App\Models\KategoriEdukasi;
use App\Services\Admin\GalleryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminBuletinController extends Controller
{
    private const IMAGE_DIR = 'buletin-images';

    public function __construct(private readonly GalleryService $gallery)
    {
    }

    public function index(): View
    {
        $buletins = Buletin::query()
            ->with(['author', 'images', 'kategori'])
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->get();

        $kategoriEdukasis = KategoriEdukasi::query()->orderBy('nama')->get();

        return view('pages.admin.buletin', compact('buletins', 'kategoriEdukasis'));
    }

    public function store(StoreBuletinRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request): void {
            $buletin = Buletin::create([
                'admin_user_id' => $request->session()->get('admin_user_id'),
                'kategori_edukasi_id' => $data['kategori_edukasi_id'] ?? null,
                'judul' => $data['judul'],
                'slug' => $this->uniqueSlug($data['judul']),
                'isi' => $data['isi'],
                'status' => $data['status'],
                'published_at' => $this->resolvePublishedAt($data),
            ]);

            $paths = $this->gallery->storeFiles($data['images'], self::IMAGE_DIR);
            $this->gallery->attachStoredImages($buletin, $paths);
        });

        return redirect()
            ->route('admin.buletin.index')
            ->with('success', 'Edukasi berhasil ditambahkan.');
    }

    public function update(UpdateBuletinRequest $request, Buletin $buletin): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($buletin, $data): void {
            $buletin->update([
                'kategori_edukasi_id' => $data['kategori_edukasi_id'] ?? null,
                'judul' => $data['judul'],
                'slug' => $this->uniqueSlug($data['judul'], $buletin->id),
                'isi' => $data['isi'],
                'status' => $data['status'],
                'published_at' => $this->resolvePublishedAt($data),
            ]);

            $this->gallery->syncImages(
                $buletin,
                $data['images'] ?? [],
                $data['remove_image_ids'] ?? [],
                self::IMAGE_DIR,
                'Minimal harus ada 1 gambar untuk setiap edukasi.'
            );
        });

        return redirect()
            ->route('admin.buletin.index')
            ->with('success', 'Edukasi berhasil diperbarui.');
    }

    public function destroy(Buletin $buletin): RedirectResponse
    {
        DB::transaction(function () use ($buletin): void {
            $this->gallery->deleteModelWithImages($buletin);
        });

        return redirect()
            ->route('admin.buletin.index')
            ->with('success', 'Edukasi berhasil dihapus.');
    }

    private function resolvePublishedAt(array $data): ?Carbon
    {
        if ($data['status'] !== Buletin::STATUS_PUBLISHED) {
            return null;
        }

        if (! empty($data['published_at'])) {
            return Carbon::parse($data['published_at']);
        }

        return now();
    }

    private function uniqueSlug(string $judul, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($judul) ?: 'edukasi';
        $slug = $baseSlug;
        $index = 2;

        while (
            Buletin::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $index;
            $index++;
        }

        return $slug;
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreInfografisRequest;
use App\Http\Requests\Admin\UpdateInfografisRequest;
use App\Models\Infografis;
use App\Services\Admin\GalleryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminInfografisController extends Controller
{
    private const IMAGE_DIR = 'infografis-images';

    public function __construct(private readonly GalleryService $gallery)
    {
    }

    public function index(): View
    {
        $infografisItems = Infografis::query()
            ->with(['author', 'images'])
            ->latest()
            ->get();

        return view('pages.admin.infografis', compact('infografisItems'));
    }

    public function store(StoreInfografisRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $request): void {
            $infografis = Infografis::create([
                'admin_user_id' => $request->session()->get('admin_user_id'),
                'judul' => $data['judul'],
                'deskripsi' => $data['deskripsi'],
            ]);

            $paths = $this->gallery->storeFiles($data['images'], self::IMAGE_DIR);
            $this->gallery->attachStoredImages($infografis, $paths);
        });

        return redirect()
            ->route('admin.infografis.index')
            ->with('success', 'Infografis berhasil ditambahkan.');
    }

    public function update(UpdateInfografisRequest $request, Infografis $infografis): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($infografis, $data): void {
            $infografis->update([
                'judul' => $data['judul'],
                'deskripsi' => $data['deskripsi'],
            ]);

            $this->gallery->syncImages(
                $infografis,
                $data['images'] ?? [],
                $data['remove_image_ids'] ?? [],
                self::IMAGE_DIR,
                'Minimal harus ada 1 gambar untuk setiap infografis.'
            );
        });

        return redirect()
            ->route('admin.infografis.index')
            ->with('success', 'Infografis berhasil diperbarui.');
    }

    public function destroy(Infografis $infografis): RedirectResponse
    {
        DB::transaction(function () use ($infografis): void {
            $this->gallery->deleteModelWithImages($infografis);
        });

        return redirect()
            ->route('admin.infografis.index')
            ->with('success', 'Infografis berhasil dihapus.');
    }
}

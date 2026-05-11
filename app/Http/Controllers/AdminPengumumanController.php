<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ImageUploadRequest;
use App\Models\Pengumuman;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminPengumumanController extends Controller
{
    private const IMAGE_DIR = 'pengumuman-images';

    public function __construct(private readonly FileUploadService $files)
    {
    }

    public function index(): View
    {
        $pengumumans = Pengumuman::query()
            ->latest()
            ->get();

        return view('pages.admin.pengumuman', compact('pengumumans'));
    }

    public function store(ImageUploadRequest $request): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data): void {
            Pengumuman::create([
                'image_path' => $this->files->store($data['image'], self::IMAGE_DIR),
            ]);
        });

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(ImageUploadRequest $request, Pengumuman $pengumuman): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($pengumuman, $data): void {
            $pengumuman->update([
                'image_path' => $this->files->replace($pengumuman->image_path, $data['image'], self::IMAGE_DIR),
            ]);
        });

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman): RedirectResponse
    {
        DB::transaction(function () use ($pengumuman): void {
            $this->files->delete($pengumuman->image_path);
            $pengumuman->delete();
        });

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}

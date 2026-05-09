<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ImageUploadRequest;
use App\Models\Pengumuman;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminPengumumanController extends Controller
{
    private const IMAGE_DIR = 'pengumuman-images';

    /** @var FileUploadService */
    private $files;

    public function __construct(FileUploadService $files)
    {
        $this->files = $files;
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

        Pengumuman::create([
            'image_path' => $this->files->store($data['image'], self::IMAGE_DIR),
        ]);

        return redirect()
            ->route('admin.pengumuman')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(ImageUploadRequest $request, Pengumuman $pengumuman): RedirectResponse
    {
        $data = $request->validated();

        $pengumuman->update([
            'image_path' => $this->files->replace($pengumuman->image_path, $data['image'], self::IMAGE_DIR),
        ]);

        return redirect()
            ->route('admin.pengumuman')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman): RedirectResponse
    {
        $this->files->delete($pengumuman->image_path);
        $pengumuman->delete();

        return redirect()
            ->route('admin.pengumuman')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}

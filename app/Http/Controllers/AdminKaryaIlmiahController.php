<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreDocumentRequest;
use App\Http\Requests\Admin\UpdateDocumentRequest;
use App\Models\KaryaIlmiah;
use App\Services\Admin\DocumentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminKaryaIlmiahController extends Controller
{
    private const PDF_DIR = 'karya-ilmiah-pdf';
    private const THUMBNAIL_DIR = 'karya-ilmiah-thumbnail';

    public function __construct(private readonly DocumentService $documents)
    {
    }

    public function index(): View
    {
        $karyaIlmiahs = KaryaIlmiah::query()
            ->latest()
            ->get();

        return view('pages.admin.karya-ilmiah', compact('karyaIlmiahs'));
    }

    public function store(StoreDocumentRequest $request): RedirectResponse
    {
        $this->documents->create(
            KaryaIlmiah::class,
            $request->validated(),
            self::THUMBNAIL_DIR,
            self::PDF_DIR
        );

        return redirect()
            ->route('admin.karya-ilmiah.index')
            ->with('success', 'Karya ilmiah berhasil ditambahkan.');
    }

    public function update(UpdateDocumentRequest $request, KaryaIlmiah $karyaIlmiah): RedirectResponse
    {
        $this->documents->update(
            $karyaIlmiah,
            $request->validated(),
            self::THUMBNAIL_DIR,
            self::PDF_DIR
        );

        return redirect()
            ->route('admin.karya-ilmiah.index')
            ->with('success', 'Karya ilmiah berhasil diperbarui.');
    }

    public function destroy(KaryaIlmiah $karyaIlmiah): RedirectResponse
    {
        $this->documents->delete($karyaIlmiah);

        return redirect()
            ->route('admin.karya-ilmiah.index')
            ->with('success', 'Karya ilmiah berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreDocumentRequest;
use App\Http\Requests\Admin\UpdateDocumentRequest;
use App\Models\LaporanSkm;
use App\Services\Admin\DocumentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminLaporanSkmController extends Controller
{
    private const PDF_DIR = 'laporan-skm-pdf';
    private const THUMBNAIL_DIR = 'laporan-skm-thumbnail';

    public function __construct(private readonly DocumentService $documents)
    {
    }

    public function index(): View
    {
        $laporanSkms = LaporanSkm::query()
            ->latest()
            ->get();

        return view('pages.admin.laporan-skm', compact('laporanSkms'));
    }

    public function store(StoreDocumentRequest $request): RedirectResponse
    {
        $this->documents->create(
            LaporanSkm::class,
            $request->validated(),
            self::THUMBNAIL_DIR,
            self::PDF_DIR
        );

        return redirect()
            ->route('admin.laporan-skm.index')
            ->with('success', 'Laporan SKM berhasil ditambahkan.');
    }

    public function update(UpdateDocumentRequest $request, LaporanSkm $laporanSkm): RedirectResponse
    {
        $this->documents->update(
            $laporanSkm,
            $request->validated(),
            self::THUMBNAIL_DIR,
            self::PDF_DIR
        );

        return redirect()
            ->route('admin.laporan-skm.index')
            ->with('success', 'Laporan SKM berhasil diperbarui.');
    }

    public function destroy(LaporanSkm $laporanSkm): RedirectResponse
    {
        $this->documents->delete($laporanSkm);

        return redirect()
            ->route('admin.laporan-skm.index')
            ->with('success', 'Laporan SKM berhasil dihapus.');
    }
}

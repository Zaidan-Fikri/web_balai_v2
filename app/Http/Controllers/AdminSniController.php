<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreDocumentRequest;
use App\Http\Requests\Admin\UpdateDocumentRequest;
use App\Models\Sni;
use App\Services\Admin\DocumentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminSniController extends Controller
{
    private const PDF_DIR = 'sni-pdf';
    private const THUMBNAIL_DIR = 'sni-thumbnail';

    public function __construct(private readonly DocumentService $documents)
    {
    }

    public function index(): View
    {
        $snis = Sni::query()
            ->latest()
            ->get();

        return view('pages.admin.sni', compact('snis'));
    }

    public function store(StoreDocumentRequest $request): RedirectResponse
    {
        $this->documents->create(
            Sni::class,
            $request->validated(),
            self::THUMBNAIL_DIR,
            self::PDF_DIR
        );

        return redirect()
            ->route('admin.sni.index')
            ->with('success', 'Data SNI berhasil ditambahkan.');
    }

    public function update(UpdateDocumentRequest $request, Sni $sni): RedirectResponse
    {
        $this->documents->update(
            $sni,
            $request->validated(),
            self::THUMBNAIL_DIR,
            self::PDF_DIR
        );

        return redirect()
            ->route('admin.sni.index')
            ->with('success', 'Data SNI berhasil diperbarui.');
    }

    public function destroy(Sni $sni): RedirectResponse
    {
        $this->documents->delete($sni);

        return redirect()
            ->route('admin.sni.index')
            ->with('success', 'Data SNI berhasil dihapus.');
    }
}

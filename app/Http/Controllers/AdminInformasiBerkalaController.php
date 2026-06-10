<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreInformasiBerkalaRequest;
use App\Http\Requests\Admin\UpdateInformasiBerkalaRequest;
use App\Models\InformasiBerkala;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminInformasiBerkalaController extends Controller
{
    private const PDF_DIR = 'informasi-berkala-pdf';

    public function __construct(private readonly FileUploadService $files) {}

    public function index(): View
    {
        $items = InformasiBerkala::query()
            ->orderBy('kategori')
            ->orderByDesc('tahun')
            ->orderBy('urutan')
            ->orderBy('judul')
            ->get();

        $kategoriLabels = InformasiBerkala::$kategoriLabels;

        return view('pages.admin.informasi-berkala', compact('items', 'kategoriLabels'));
    }

    public function store(StoreInformasiBerkalaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        InformasiBerkala::create([
            'kategori' => $data['kategori'],
            'tahun'    => $data['tahun'],
            'judul'    => $data['judul'],
            'pdf_path' => $this->files->store($data['pdf'], self::PDF_DIR),
            'urutan'   => 0,
        ]);

        return redirect()
            ->route('admin.informasi-berkala.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function update(UpdateInformasiBerkalaRequest $request, InformasiBerkala $informasiBerkala): RedirectResponse
    {
        $data    = $request->validated();
        $pdfPath = $informasiBerkala->pdf_path;

        if (! empty($data['pdf'])) {
            $pdfPath = $this->files->replace($informasiBerkala->pdf_path, $data['pdf'], self::PDF_DIR);
        }

        $informasiBerkala->update([
            'kategori' => $data['kategori'],
            'tahun'    => $data['tahun'],
            'judul'    => $data['judul'],
            'pdf_path' => $pdfPath,
        ]);

        return redirect()
            ->route('admin.informasi-berkala.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(InformasiBerkala $informasiBerkala): RedirectResponse
    {
        $this->files->delete($informasiBerkala->pdf_path);
        $informasiBerkala->delete();

        return redirect()
            ->route('admin.informasi-berkala.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}

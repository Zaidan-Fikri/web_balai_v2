<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreInformasiSertaMertaRequest;
use App\Http\Requests\Admin\UpdateInformasiSertaMertaRequest;
use App\Models\InformasiSertaMerta;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminInformasiSertaMertaController extends Controller
{
    private const PDF_DIR = 'informasi-serta-merta-pdf';

    public function __construct(private readonly FileUploadService $files) {}

    public function index(): View
    {
        $items = InformasiSertaMerta::query()
            ->orderByDesc('tahun')
            ->orderBy('urutan')
            ->orderBy('judul')
            ->get();

        return view('pages.admin.informasi-serta-merta', compact('items'));
    }

    public function store(StoreInformasiSertaMertaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        InformasiSertaMerta::create([
            'tahun'    => $data['tahun'],
            'judul'    => $data['judul'],
            'pdf_path' => $this->files->store($data['pdf'], self::PDF_DIR),
            'urutan'   => 0,
        ]);

        return redirect()
            ->route('admin.informasi-serta-merta.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function update(UpdateInformasiSertaMertaRequest $request, InformasiSertaMerta $informasiSertaMerta): RedirectResponse
    {
        $data    = $request->validated();
        $pdfPath = $informasiSertaMerta->pdf_path;

        if (! empty($data['pdf'])) {
            $pdfPath = $this->files->replace($informasiSertaMerta->pdf_path, $data['pdf'], self::PDF_DIR);
        }

        $informasiSertaMerta->update([
            'tahun'    => $data['tahun'],
            'judul'    => $data['judul'],
            'pdf_path' => $pdfPath,
        ]);

        return redirect()
            ->route('admin.informasi-serta-merta.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(InformasiSertaMerta $informasiSertaMerta): RedirectResponse
    {
        $this->files->delete($informasiSertaMerta->pdf_path);
        $informasiSertaMerta->delete();

        return redirect()
            ->route('admin.informasi-serta-merta.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}

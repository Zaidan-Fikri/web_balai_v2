<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\StoreInformasiTersediaSetiapSaatRequest;
use App\Http\Requests\Admin\UpdateInformasiTersediaSetiapSaatRequest;
use App\Models\InformasiTersediaSetiapSaat;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminInformasiTersediaSetiapSaatController extends Controller
{
    private const PDF_DIR = 'informasi-tersedia-setiap-saat-pdf';

    public function __construct(private readonly FileUploadService $files) {}

    public function index(): View
    {
        $items = InformasiTersediaSetiapSaat::query()
            ->orderByDesc('tahun')
            ->orderBy('urutan')
            ->orderBy('judul')
            ->get();

        return view('pages.admin.informasi-tersedia-setiap-saat', compact('items'));
    }

    public function store(StoreInformasiTersediaSetiapSaatRequest $request): RedirectResponse
    {
        $data = $request->validated();

        InformasiTersediaSetiapSaat::create([
            'tahun'    => $data['tahun'],
            'judul'    => $data['judul'],
            'pdf_path' => $this->files->store($data['pdf'], self::PDF_DIR),
            'urutan'   => 0,
        ]);

        return redirect()
            ->route('admin.informasi-tersedia-setiap-saat.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function update(UpdateInformasiTersediaSetiapSaatRequest $request, InformasiTersediaSetiapSaat $informasiTersediaSetiapSaat): RedirectResponse
    {
        $data    = $request->validated();
        $pdfPath = $informasiTersediaSetiapSaat->pdf_path;

        if (! empty($data['pdf'])) {
            $pdfPath = $this->files->replace($informasiTersediaSetiapSaat->pdf_path, $data['pdf'], self::PDF_DIR);
        }

        $informasiTersediaSetiapSaat->update([
            'tahun'    => $data['tahun'],
            'judul'    => $data['judul'],
            'pdf_path' => $pdfPath,
        ]);

        return redirect()
            ->route('admin.informasi-tersedia-setiap-saat.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(InformasiTersediaSetiapSaat $informasiTersediaSetiapSaat): RedirectResponse
    {
        $this->files->delete($informasiTersediaSetiapSaat->pdf_path);
        $informasiTersediaSetiapSaat->delete();

        return redirect()
            ->route('admin.informasi-tersedia-setiap-saat.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }
}

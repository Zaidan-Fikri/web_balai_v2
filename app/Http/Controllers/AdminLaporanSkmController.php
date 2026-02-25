<?php

namespace App\Http\Controllers;

use App\Models\LaporanSkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLaporanSkmController extends Controller
{
    public function index()
    {
        $laporanSkms = LaporanSkm::query()
            ->latest()
            ->get();

        return view('pages.admin.laporan-skm', compact('laporanSkms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $thumbnailPath = $validated['thumbnail']->store('laporan-skm-thumbnail', 'public');
        $pdfPath = $validated['pdf']->store('laporan-skm-pdf', 'public');

        LaporanSkm::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'thumbnail_path' => $thumbnailPath,
            'pdf_path' => $pdfPath,
        ]);

        return redirect()
            ->route('admin.laporan-skm')
            ->with('success', 'Laporan SKM berhasil ditambahkan.');
    }

    public function update(Request $request, LaporanSkm $laporanSkm)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $thumbnailPath = $laporanSkm->thumbnail_path;
        $pdfPath = $laporanSkm->pdf_path;

        if (!empty($validated['thumbnail'])) {
            if (!empty($laporanSkm->thumbnail_path)) {
                Storage::disk('public')->delete($laporanSkm->thumbnail_path);
            }
            $thumbnailPath = $validated['thumbnail']->store('laporan-skm-thumbnail', 'public');
        }

        if (!empty($validated['pdf'])) {
            if (!empty($laporanSkm->pdf_path)) {
                Storage::disk('public')->delete($laporanSkm->pdf_path);
            }
            $pdfPath = $validated['pdf']->store('laporan-skm-pdf', 'public');
        }

        $laporanSkm->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'thumbnail_path' => $thumbnailPath,
            'pdf_path' => $pdfPath,
        ]);

        return redirect()
            ->route('admin.laporan-skm')
            ->with('success', 'Laporan SKM berhasil diperbarui.');
    }

    public function destroy(LaporanSkm $laporanSkm)
    {
        if (!empty($laporanSkm->thumbnail_path)) {
            Storage::disk('public')->delete($laporanSkm->thumbnail_path);
        }

        if (!empty($laporanSkm->pdf_path)) {
            Storage::disk('public')->delete($laporanSkm->pdf_path);
        }

        $laporanSkm->delete();

        return redirect()
            ->route('admin.laporan-skm')
            ->with('success', 'Laporan SKM berhasil dihapus.');
    }
}

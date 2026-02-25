<?php

namespace App\Http\Controllers;

use App\Models\KaryaIlmiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminKaryaIlmiahController extends Controller
{
    public function index()
    {
        $karyaIlmiahs = KaryaIlmiah::query()
            ->latest()
            ->get();

        return view('pages.admin.karya-ilmiah', compact('karyaIlmiahs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $thumbnailPath = $validated['thumbnail']->store('karya-ilmiah-thumbnail', 'public');
        $pdfPath = $validated['pdf']->store('karya-ilmiah-pdf', 'public');

        KaryaIlmiah::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'thumbnail_path' => $thumbnailPath,
            'pdf_path' => $pdfPath,
        ]);

        return redirect()
            ->route('admin.karya-ilmiah')
            ->with('success', 'Karya ilmiah berhasil ditambahkan.');
    }

    public function update(Request $request, KaryaIlmiah $karyaIlmiah)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $thumbnailPath = $karyaIlmiah->thumbnail_path;
        $pdfPath = $karyaIlmiah->pdf_path;

        if (!empty($validated['thumbnail'])) {
            if (!empty($karyaIlmiah->thumbnail_path)) {
                Storage::disk('public')->delete($karyaIlmiah->thumbnail_path);
            }
            $thumbnailPath = $validated['thumbnail']->store('karya-ilmiah-thumbnail', 'public');
        }

        if (!empty($validated['pdf'])) {
            if (!empty($karyaIlmiah->pdf_path)) {
                Storage::disk('public')->delete($karyaIlmiah->pdf_path);
            }
            $pdfPath = $validated['pdf']->store('karya-ilmiah-pdf', 'public');
        }

        $karyaIlmiah->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'thumbnail_path' => $thumbnailPath,
            'pdf_path' => $pdfPath,
        ]);

        return redirect()
            ->route('admin.karya-ilmiah')
            ->with('success', 'Karya ilmiah berhasil diperbarui.');
    }

    public function destroy(KaryaIlmiah $karyaIlmiah)
    {
        if (!empty($karyaIlmiah->thumbnail_path)) {
            Storage::disk('public')->delete($karyaIlmiah->thumbnail_path);
        }

        if (!empty($karyaIlmiah->pdf_path)) {
            Storage::disk('public')->delete($karyaIlmiah->pdf_path);
        }

        $karyaIlmiah->delete();

        return redirect()
            ->route('admin.karya-ilmiah')
            ->with('success', 'Karya ilmiah berhasil dihapus.');
    }
}

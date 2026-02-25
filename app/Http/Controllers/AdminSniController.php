<?php

namespace App\Http\Controllers;

use App\Models\Sni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSniController extends Controller
{
    public function index()
    {
        $snis = Sni::query()
            ->latest()
            ->get();

        return view('pages.admin.sni', compact('snis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $thumbnailPath = $validated['thumbnail']->store('sni-thumbnail', 'public');
        $pdfPath = $validated['pdf']->store('sni-pdf', 'public');

        Sni::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'thumbnail_path' => $thumbnailPath,
            'pdf_path' => $pdfPath,
        ]);

        return redirect()
            ->route('admin.sni')
            ->with('success', 'Data SNI berhasil ditambahkan.');
    }

    public function update(Request $request, Sni $sni)
    {
        $validated = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $thumbnailPath = $sni->thumbnail_path;
        $pdfPath = $sni->pdf_path;

        if (!empty($validated['thumbnail'])) {
            if (!empty($sni->thumbnail_path)) {
                Storage::disk('public')->delete($sni->thumbnail_path);
            }
            $thumbnailPath = $validated['thumbnail']->store('sni-thumbnail', 'public');
        }

        if (!empty($validated['pdf'])) {
            if (!empty($sni->pdf_path)) {
                Storage::disk('public')->delete($sni->pdf_path);
            }
            $pdfPath = $validated['pdf']->store('sni-pdf', 'public');
        }

        $sni->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'thumbnail_path' => $thumbnailPath,
            'pdf_path' => $pdfPath,
        ]);

        return redirect()
            ->route('admin.sni')
            ->with('success', 'Data SNI berhasil diperbarui.');
    }

    public function destroy(Sni $sni)
    {
        if (!empty($sni->thumbnail_path)) {
            Storage::disk('public')->delete($sni->thumbnail_path);
        }

        if (!empty($sni->pdf_path)) {
            Storage::disk('public')->delete($sni->pdf_path);
        }

        $sni->delete();

        return redirect()
            ->route('admin.sni')
            ->with('success', 'Data SNI berhasil dihapus.');
    }
}

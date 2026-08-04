<?php

namespace App\Http\Controllers;

use App\Models\KategoriEdukasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminKategoriEdukasiController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100', 'unique:kategori_edukasis,nama'],
        ]);

        KategoriEdukasi::create($data);

        return redirect()
            ->route('admin.buletin.index')
            ->with('success', 'Kategori edukasi berhasil ditambahkan.');
    }

    public function destroy(KategoriEdukasi $kategoriEdukasi): RedirectResponse
    {
        $kategoriEdukasi->delete();

        return redirect()
            ->route('admin.buletin.index')
            ->with('success', 'Kategori edukasi berhasil dihapus.');
    }
}

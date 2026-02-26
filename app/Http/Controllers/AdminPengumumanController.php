<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPengumumanController extends Controller
{
    public function index()
    {
        $pengumumans = Pengumuman::query()
            ->latest()
            ->get();

        return view('pages.admin.pengumuman', compact('pengumumans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $path = $validated['image']->store('pengumuman-images', 'public');

        Pengumuman::create([
            'image_path' => $path,
        ]);

        return redirect()
            ->route('admin.pengumuman')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if (!empty($pengumuman->image_path)) {
            Storage::disk('public')->delete($pengumuman->image_path);
        }

        $path = $validated['image']->store('pengumuman-images', 'public');

        $pengumuman->update([
            'image_path' => $path,
        ]);

        return redirect()
            ->route('admin.pengumuman')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        if (!empty($pengumuman->image_path)) {
            Storage::disk('public')->delete($pengumuman->image_path);
        }

        $pengumuman->delete();

        return redirect()
            ->route('admin.pengumuman')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Geolistrik1d;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminGeolistrik1dController extends Controller
{
    public function index(): View
    {
        $geolistrik1ds = Geolistrik1d::query()
            ->latest()
            ->get();

        return view('pages.admin.geolistrik-1d', compact('geolistrik1ds'));
    }

    public function store(Request $request): RedirectResponse
    {
        Geolistrik1d::create($this->validatedData($request));

        return redirect()
            ->route('admin.geolistrik-1d.index')
            ->with('success', 'Data Geolistrik 1D berhasil ditambahkan.');
    }

    public function update(Request $request, Geolistrik1d $geolistrik1d): RedirectResponse
    {
        $geolistrik1d->update($this->validatedData($request));

        return redirect()
            ->route('admin.geolistrik-1d.index')
            ->with('success', 'Data Geolistrik 1D berhasil diperbarui.');
    }

    public function destroy(Geolistrik1d $geolistrik1d): RedirectResponse
    {
        $geolistrik1d->delete();

        return redirect()
            ->route('admin.geolistrik-1d.index')
            ->with('success', 'Data Geolistrik 1D berhasil dihapus.');
    }

    /**
     * @return array{nama: string, latitude: numeric, longitude: numeric}
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-11.2,6.2'],
            'longitude' => ['required', 'numeric', 'between:94.6,141.1'],
        ]);
    }
}

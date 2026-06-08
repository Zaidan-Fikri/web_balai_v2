<?php

namespace App\Http\Controllers;

use App\Models\ProfilePage;
use Illuminate\View\View;

class ProfilePageController extends Controller
{
    public function show(string $slug, string $fallbackTitle): View
    {
        $profilePage = ProfilePage::query()
            ->where('slug', $slug)
            ->first();

        return view('pages.menu_detail', [
            'menuGroup' => 'Profil',
            'pageTitle' => $profilePage?->title ?? $fallbackTitle,
            'profilePage' => $profilePage,
        ]);
    }

    public function showPage(ProfilePage $profilePage): View
    {
        return view('pages.menu_detail', [
            'menuGroup' => 'Profil',
            'pageTitle' => $profilePage->title,
            'profilePage' => $profilePage,
        ]);
    }

    public function index(): View
    {
        return $this->show('tentang-kami', 'Tentang Kami');
    }

    public function tugasDanFungsi(): View
    {
        return $this->show('tugas-dan-fungsi', 'Tugas dan Fungsi');
    }

    public function visiMisi(): View
    {
        return $this->show('visi-dan-misi', 'Visi dan Misi');
    }

    public function strukturOrganisasi(): View
    {
        return $this->show('struktur-organisasi', 'Struktur Organisasi');
    }

    public function informasiPejabat(): View
    {
        return $this->show('informasi-pejabat', 'Informasi Pejabat');
    }

    public function zonaIntegritas(): View
    {
        return $this->show('zona-integritas', 'Zona Integritas');
    }

    public function lokasiDanKontak(): View
    {
        return $this->show('lokasi-dan-kontak', 'Lokasi dan Kontak');
    }
}

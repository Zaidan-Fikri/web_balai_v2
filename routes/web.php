<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminBuletinController;
use App\Http\Controllers\AdminGemController;
use App\Http\Controllers\AdminGeolistrik1dController;
use App\Http\Controllers\AdminInfografisController;
use App\Http\Controllers\AdminKaryaIlmiahController;
use App\Http\Controllers\AdminLaporanSkmController;
use App\Http\Controllers\AdminPengumumanController;
use App\Http\Controllers\AdminSniController;
use App\Http\Controllers\AdminSiatabController;
use App\Http\Controllers\AdminThumbnailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BuletinController;
use App\Http\Controllers\InfografisController;
use App\Http\Controllers\SearchController;
use App\Models\IndonesiaMap;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', SearchController::class)->name('search');

Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('login.process');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
Route::get('/peta', function (): View {
    return view('pages.peta', [
        'mapConfig' => IndonesiaMap::config(),
    ]);
})->name('peta');
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/peta', function (): View {
        return view('pages.petaAdmin', [
            'mapConfig' => IndonesiaMap::adminConfig(),
        ]);
    })->name('peta');
});
Route::view('/gems', 'pages.menu_detail', ['menuGroup' => 'Layanan Unggulan', 'pageTitle' => 'GEMS'])->name('gems');
Route::view('/laboratorium', 'pages.menu_detail', ['menuGroup' => 'Layanan Unggulan', 'pageTitle' => 'Laboratorium'])->name('laboratorium');

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::view('/dashboard', 'pages.admin.dashboard')->name('dashboard');

    Route::middleware('admin.role:kompu')->group(function () {
        Route::get('/berita', [AdminBeritaController::class, 'index'])->name('berita.index');
        Route::get('/buletin', [AdminBuletinController::class, 'index'])->name('buletin.index');
        Route::post('/buletin', [AdminBuletinController::class, 'store'])->name('buletin.store');
        Route::put('/buletin/{buletin}', [AdminBuletinController::class, 'update'])->name('buletin.update');
        Route::delete('/buletin/{buletin}', [AdminBuletinController::class, 'destroy'])->name('buletin.destroy');
        Route::get('/infografis', [AdminInfografisController::class, 'index'])->name('infografis.index');
        Route::post('/infografis', [AdminInfografisController::class, 'store'])->name('infografis.store');
        Route::put('/infografis/{infografis}', [AdminInfografisController::class, 'update'])->name('infografis.update');
        Route::delete('/infografis/{infografis}', [AdminInfografisController::class, 'destroy'])->name('infografis.destroy');
        Route::post('/berita', [AdminBeritaController::class, 'store'])->name('berita.store');
        Route::put('/berita/{berita}', [AdminBeritaController::class, 'update'])->name('berita.update');
        Route::delete('/berita/{berita}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');
        Route::get('/thumbnail', [AdminThumbnailController::class, 'index'])->name('thumbnail.index');
        Route::post('/thumbnail', [AdminThumbnailController::class, 'store'])->name('thumbnail.store');
        Route::put('/thumbnail/{thumbnail}', [AdminThumbnailController::class, 'update'])->name('thumbnail.update');
        Route::delete('/thumbnail/{thumbnail}', [AdminThumbnailController::class, 'destroy'])->name('thumbnail.destroy');
        Route::post('/thumbnail/visibility', [AdminThumbnailController::class, 'updateVisibility'])->name('thumbnail.visibility');
        Route::get('/pengumuman', [AdminPengumumanController::class, 'index'])->name('pengumuman.index');
        Route::post('/pengumuman', [AdminPengumumanController::class, 'store'])->name('pengumuman.store');
        Route::put('/pengumuman/{pengumuman}', [AdminPengumumanController::class, 'update'])->name('pengumuman.update');
        Route::delete('/pengumuman/{pengumuman}', [AdminPengumumanController::class, 'destroy'])->name('pengumuman.destroy');
        Route::view('/jurnal', 'pages.admin.jurnal')->name('jurnal');
        Route::get('/karya-ilmiah', [AdminKaryaIlmiahController::class, 'index'])->name('karya-ilmiah.index');
        Route::post('/karya-ilmiah', [AdminKaryaIlmiahController::class, 'store'])->name('karya-ilmiah.store');
        Route::put('/karya-ilmiah/{karyaIlmiah}', [AdminKaryaIlmiahController::class, 'update'])->name('karya-ilmiah.update');
        Route::delete('/karya-ilmiah/{karyaIlmiah}', [AdminKaryaIlmiahController::class, 'destroy'])->name('karya-ilmiah.destroy');
        Route::get('/sni', [AdminSniController::class, 'index'])->name('sni.index');
        Route::post('/sni', [AdminSniController::class, 'store'])->name('sni.store');
        Route::put('/sni/{sni}', [AdminSniController::class, 'update'])->name('sni.update');
        Route::delete('/sni/{sni}', [AdminSniController::class, 'destroy'])->name('sni.destroy');
        Route::get('/siatab', [AdminSiatabController::class, 'index'])->name('siatab.index');
        Route::post('/siatab', [AdminSiatabController::class, 'store'])->name('siatab.store');
        Route::put('/siatab/{siatab}', [AdminSiatabController::class, 'update'])->name('siatab.update');
        Route::delete('/siatab/{siatab}', [AdminSiatabController::class, 'destroy'])->name('siatab.destroy');
        Route::get('/gems', [AdminGemController::class, 'index'])->name('gems.index');
        Route::post('/gems', [AdminGemController::class, 'store'])->name('gems.store');
        Route::put('/gems/{gem}', [AdminGemController::class, 'update'])->name('gems.update');
        Route::delete('/gems/{gem}', [AdminGemController::class, 'destroy'])->name('gems.destroy');
        Route::get('/laporan-skm', [AdminLaporanSkmController::class, 'index'])->name('laporan-skm.index');
        Route::post('/laporan-skm', [AdminLaporanSkmController::class, 'store'])->name('laporan-skm.store');
        Route::put('/laporan-skm/{laporanSkm}', [AdminLaporanSkmController::class, 'update'])->name('laporan-skm.update');
        Route::delete('/laporan-skm/{laporanSkm}', [AdminLaporanSkmController::class, 'destroy'])->name('laporan-skm.destroy');
    });

    Route::middleware('admin.role:layanan_teknis')->group(function () {
        Route::get('/geolistrik-1d', [AdminGeolistrik1dController::class, 'index'])->name('geolistrik-1d.index');
        Route::post('/geolistrik-1d', [AdminGeolistrik1dController::class, 'store'])->name('geolistrik-1d.store');
        Route::post('/geolistrik-1d/import-preview', [AdminGeolistrik1dController::class, 'importPreview'])->name('geolistrik-1d.import-preview');
        Route::post('/geolistrik-1d/import-store', [AdminGeolistrik1dController::class, 'importStore'])->name('geolistrik-1d.import-store');
        Route::put('/geolistrik-1d/{geolistrik1d}', [AdminGeolistrik1dController::class, 'update'])->name('geolistrik-1d.update');
        Route::delete('/geolistrik-1d/{geolistrik1d}', [AdminGeolistrik1dController::class, 'destroy'])->name('geolistrik-1d.destroy');
    });
});

Route::prefix('profil')->name('profil.')->group(function () {
    Route::view('/', 'pages.menu_detail', [
        'menuGroup' => 'Profil',
        'pageTitle' => 'Profil Balai Air Tanah',
    ])->name('index');
    Route::view('/tugas_dan_fungsi', 'pages.menu_detail', ['menuGroup' => 'Profil', 'pageTitle' => 'Tugas dan Fungsi'])->name('tugas_dan_fungsi');
    Route::view('/visi_misi', 'pages.menu_detail', ['menuGroup' => 'Profil', 'pageTitle' => 'Visi & Misi'])->name('visi_misi');
    Route::view('/struktur_organisasi', 'pages.menu_detail', ['menuGroup' => 'Profil', 'pageTitle' => 'Struktur Organisasi'])->name('struktur_organisasi');
    Route::view('/lokasi_dan_kontak', 'pages.menu_detail', ['menuGroup' => 'Profil', 'pageTitle' => 'Lokasi dan Kontak'])->name('lokasi_dan_kontak');
});

Route::prefix('publikasi')->name('publikasi.')->group(function () {
    Route::view('/berita', 'pages.menu_detail', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Berita'])->name('berita');
    Route::get('/buletin', [BuletinController::class, 'index'])->name('buletin.index');
    Route::get('/buletin/{buletin:slug}', [BuletinController::class, 'show'])->name('buletin.show');
    Route::view('/pengumuman', 'pages.menu_detail', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Pengumuman'])->name('pengumuman');
    Route::get('/infografis', [InfografisController::class, 'index'])->name('infografis');
    Route::view('/galeri', 'pages.menu_detail', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Galeri'])->name('galeri');
});

Route::prefix('informasi_publik')->name('informasi_publik.')->group(function () {
    Route::view('/informasi_berkala', 'pages.menu_detail', ['menuGroup' => 'Informasi Publik', 'pageTitle' => 'Informasi Berkala'])->name('informasi_berkala');
    Route::view('/informasi_serta_merta', 'pages.menu_detail', ['menuGroup' => 'Informasi Publik', 'pageTitle' => 'Informasi Serta Merta'])->name('informasi_serta_merta');
    Route::view('/informasi_tersedia_setiap_saat', 'pages.menu_detail', ['menuGroup' => 'Informasi Publik', 'pageTitle' => 'Informasi Tersedia Setiap Saat'])->name('informasi_tersedia_setiap_saat');
});

Route::prefix('pelayanan_publik')->name('pelayanan_publik.')->group(function () {
    Route::view('/standar_pelayanan', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Standar Pelayanan'])->name('standar_pelayanan');
    Route::view('/maklumat_pelayanan', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Maklumat Pelayanan'])->name('maklumat_pelayanan');
    Route::view('/permintaan_pelayanan', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Permintaan Pelayanan'])->name('permintaan_pelayanan');
    Route::view('/permintaan_pelayanan/data', 'pages.pelayanan_publik.permintaan_pelayanan_data')->name('permintaan_pelayanan_data');
    Route::view('/permintaan_pelayanan/magang', 'pages.pelayanan_publik.permintaan_pelayanan_magang')->name('permintaan_pelayanan_magang');
    Route::view('/permintaan_pelayanan/advis', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Permintaan Pelayanan Advis'])->name('permintaan_pelayanan_advis');
    Route::view('/e_ppid', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'E-PPID'])->name('e_ppid');
    Route::view('/layanan_pengaduan', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Layanan Pengaduan'])->name('layanan_pengaduan');
});

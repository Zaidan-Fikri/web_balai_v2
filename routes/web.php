<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminKaryaIlmiahController;
use App\Http\Controllers\AdminLaporanSkmController;
use App\Http\Controllers\AdminPengumumanController;
use App\Http\Controllers\AdminSniController;
use App\Http\Controllers\AdminSiatabController;
use App\Http\Controllers\AdminThumbnailController;
use App\Models\Berita;
use App\Models\KaryaIlmiah;
use App\Models\LaporanSkm;
use App\Models\Pengumuman;
use App\Models\Siatab;
use App\Models\Sni;
use App\Models\Thumbnail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $beritas = Berita::query()
        ->with(['images' => function ($query) {
            $query->oldest('id');
        }])
        ->latest()
        ->take(10)
        ->get();

    $heroThumbnails = Thumbnail::query()
        ->where('show_on_home', true)
        ->latest()
        ->get();

    $publikasiKaryaIlmiahs = KaryaIlmiah::query()->latest()->take(12)->get();
    $publikasiSnis = Sni::query()->latest()->take(12)->get();
    $publikasiLaporanSkms = LaporanSkm::query()->latest()->take(12)->get();
    $pengumumans = Pengumuman::query()->latest()->take(12)->get();
    $siatabs = Siatab::query()
        ->with(['images' => function ($query) {
            $query->oldest('id');
        }])
        ->latest()
        ->get();

    return view('pages.home', compact(
        'beritas',
        'heroThumbnails',
        'publikasiKaryaIlmiahs',
        'publikasiSnis',
        'publikasiLaporanSkms',
        'pengumumans',
        'siatabs'
    ));
})->name('home');

Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::view('/dashboard', 'pages.admin.dashboard')->name('dashboard');
    Route::get('/berita', [AdminBeritaController::class, 'index'])->name('berita');
    Route::post('/berita', [AdminBeritaController::class, 'store'])->name('berita.store');
    Route::put('/berita/{berita}', [AdminBeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}', [AdminBeritaController::class, 'destroy'])->name('berita.destroy');
    Route::get('/thumbnail', [AdminThumbnailController::class, 'index'])->name('thumbnail');
    Route::post('/thumbnail', [AdminThumbnailController::class, 'store'])->name('thumbnail.store');
    Route::put('/thumbnail/{thumbnail}', [AdminThumbnailController::class, 'update'])->name('thumbnail.update');
    Route::delete('/thumbnail/{thumbnail}', [AdminThumbnailController::class, 'destroy'])->name('thumbnail.destroy');
    Route::post('/thumbnail/visibility', [AdminThumbnailController::class, 'updateVisibility'])->name('thumbnail.visibility');
    Route::get('/pengumuman', [AdminPengumumanController::class, 'index'])->name('pengumuman');
    Route::post('/pengumuman', [AdminPengumumanController::class, 'store'])->name('pengumuman.store');
    Route::put('/pengumuman/{pengumuman}', [AdminPengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{pengumuman}', [AdminPengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    Route::view('/jurnal', 'pages.admin.jurnal')->name('jurnal');
    Route::get('/karya-ilmiah', [AdminKaryaIlmiahController::class, 'index'])->name('karya-ilmiah');
    Route::post('/karya-ilmiah', [AdminKaryaIlmiahController::class, 'store'])->name('karya-ilmiah.store');
    Route::put('/karya-ilmiah/{karyaIlmiah}', [AdminKaryaIlmiahController::class, 'update'])->name('karya-ilmiah.update');
    Route::delete('/karya-ilmiah/{karyaIlmiah}', [AdminKaryaIlmiahController::class, 'destroy'])->name('karya-ilmiah.destroy');
    Route::get('/sni', [AdminSniController::class, 'index'])->name('sni');
    Route::post('/sni', [AdminSniController::class, 'store'])->name('sni.store');
    Route::put('/sni/{sni}', [AdminSniController::class, 'update'])->name('sni.update');
    Route::delete('/sni/{sni}', [AdminSniController::class, 'destroy'])->name('sni.destroy');
    Route::get('/siatab', [AdminSiatabController::class, 'index'])->name('siatab');
    Route::post('/siatab', [AdminSiatabController::class, 'store'])->name('siatab.store');
    Route::put('/siatab/{siatab}', [AdminSiatabController::class, 'update'])->name('siatab.update');
    Route::delete('/siatab/{siatab}', [AdminSiatabController::class, 'destroy'])->name('siatab.destroy');
    Route::get('/laporan-skm', [AdminLaporanSkmController::class, 'index'])->name('laporan-skm');
    Route::post('/laporan-skm', [AdminLaporanSkmController::class, 'store'])->name('laporan-skm.store');
    Route::put('/laporan-skm/{laporanSkm}', [AdminLaporanSkmController::class, 'update'])->name('laporan-skm.update');
    Route::delete('/laporan-skm/{laporanSkm}', [AdminLaporanSkmController::class, 'destroy'])->name('laporan-skm.destroy');
});

Route::prefix('profil')->name('profil.')->group(function () {
    Route::view('/tugas_dan_fungsi', 'pages.menu_detail', ['menuGroup' => 'Profil', 'pageTitle' => 'Tugas dan Fungsi'])->name('tugas_dan_fungsi');
    Route::view('/visi_misi', 'pages.menu_detail', ['menuGroup' => 'Profil', 'pageTitle' => 'Visi & Misi'])->name('visi_misi');
    Route::view('/struktur_organisasi', 'pages.menu_detail', ['menuGroup' => 'Profil', 'pageTitle' => 'Struktur Organisasi'])->name('struktur_organisasi');
    Route::view('/lokasi_dan_kontak', 'pages.menu_detail', ['menuGroup' => 'Profil', 'pageTitle' => 'Lokasi dan Kontak'])->name('lokasi_dan_kontak');
});

Route::prefix('publikasi')->name('publikasi.')->group(function () {
    Route::view('/berita', 'pages.menu_detail', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Berita'])->name('berita');
    Route::view('/pengumuman', 'pages.menu_detail', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Pengumuman'])->name('pengumuman');
    Route::view('/infografis', 'pages.menu_detail', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Infografis'])->name('infografis');
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
    Route::view('/e_ppid', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'E-PPID'])->name('e_ppid');
    Route::view('/layanan_pengaduan', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Layanan Pengaduan'])->name('layanan_pengaduan');
});

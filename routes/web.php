<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminBuletinController;
use App\Http\Controllers\AdminGemController;
use App\Http\Controllers\AdminGeolistrik1dController;
use App\Http\Controllers\AdminInfografisController;
use App\Http\Controllers\AdminKaryaIlmiahController;
use App\Http\Controllers\AdminInformasiBerkalaController;
use App\Http\Controllers\AdminInformasiSertaMertaController;
use App\Http\Controllers\AdminInformasiTersediaSetiapSaatController;
use App\Http\Controllers\AdminLaporanSkmController;
use App\Http\Controllers\AdminPengumumanController;
use App\Http\Controllers\AdminSniController;
use App\Http\Controllers\AdminSiatabController;
use App\Http\Controllers\AdminGaleriController;
use App\Http\Controllers\AdminGaleriTileController;
use App\Http\Controllers\AdminProfilePageController;
use App\Http\Controllers\AdminThumbnailController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BuletinController;
use App\Http\Controllers\InfografisController;
use App\Http\Controllers\GaleriFotoController;
use App\Http\Controllers\InformasiBerkalaController;
use App\Http\Controllers\InformasiSertaMertaController;
use App\Http\Controllers\InformasiTersediaSetiapSaatController;
use App\Http\Controllers\LaporanSkmController;
use App\Http\Controllers\ProfilePageController;
use App\Http\Controllers\GaleriVideoController;
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
        Route::get('/profile-pages', [AdminProfilePageController::class, 'index'])->name('profile-pages.index');
        Route::post('/profile-pages', [AdminProfilePageController::class, 'store'])->name('profile-pages.store');
        Route::get('/profile-pages/{profilePage:slug}/edit', [AdminProfilePageController::class, 'edit'])->name('profile-pages.edit');
        Route::put('/profile-pages/{profilePage:slug}', [AdminProfilePageController::class, 'update'])->name('profile-pages.update');
        Route::delete('/profile-pages/{profilePage:slug}', [AdminProfilePageController::class, 'destroy'])->name('profile-pages.destroy');
        Route::post('/profile-pages/upload-org-photo', [AdminProfilePageController::class, 'uploadOrgPhoto'])->name('profile-pages.upload-org-photo');
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
        Route::get('/informasi-berkala', [AdminInformasiBerkalaController::class, 'index'])->name('informasi-berkala.index');
        Route::post('/informasi-berkala', [AdminInformasiBerkalaController::class, 'store'])->name('informasi-berkala.store');
        Route::put('/informasi-berkala/{informasiBerkala}', [AdminInformasiBerkalaController::class, 'update'])->name('informasi-berkala.update');
        Route::delete('/informasi-berkala/{informasiBerkala}', [AdminInformasiBerkalaController::class, 'destroy'])->name('informasi-berkala.destroy');
        Route::get('/informasi-serta-merta', [AdminInformasiSertaMertaController::class, 'index'])->name('informasi-serta-merta.index');
        Route::post('/informasi-serta-merta', [AdminInformasiSertaMertaController::class, 'store'])->name('informasi-serta-merta.store');
        Route::put('/informasi-serta-merta/{informasiSertaMerta}', [AdminInformasiSertaMertaController::class, 'update'])->name('informasi-serta-merta.update');
        Route::delete('/informasi-serta-merta/{informasiSertaMerta}', [AdminInformasiSertaMertaController::class, 'destroy'])->name('informasi-serta-merta.destroy');
        Route::get('/informasi-tersedia-setiap-saat', [AdminInformasiTersediaSetiapSaatController::class, 'index'])->name('informasi-tersedia-setiap-saat.index');
        Route::post('/informasi-tersedia-setiap-saat', [AdminInformasiTersediaSetiapSaatController::class, 'store'])->name('informasi-tersedia-setiap-saat.store');
        Route::put('/informasi-tersedia-setiap-saat/{informasiTersediaSetiapSaat}', [AdminInformasiTersediaSetiapSaatController::class, 'update'])->name('informasi-tersedia-setiap-saat.update');
        Route::delete('/informasi-tersedia-setiap-saat/{informasiTersediaSetiapSaat}', [AdminInformasiTersediaSetiapSaatController::class, 'destroy'])->name('informasi-tersedia-setiap-saat.destroy');
        Route::get('/laporan-skm', [AdminLaporanSkmController::class, 'index'])->name('laporan-skm.index');
        Route::post('/laporan-skm', [AdminLaporanSkmController::class, 'store'])->name('laporan-skm.store');
        Route::put('/laporan-skm/{laporanSkm}', [AdminLaporanSkmController::class, 'update'])->name('laporan-skm.update');
        Route::delete('/laporan-skm/{laporanSkm}', [AdminLaporanSkmController::class, 'destroy'])->name('laporan-skm.destroy');
        Route::get('/galeri', [AdminGaleriController::class, 'index'])->name('galeri.index');
        Route::post('/galeri', [AdminGaleriController::class, 'store'])->name('galeri.store');
        Route::put('/galeri/{galeri}', [AdminGaleriController::class, 'update'])->name('galeri.update');
        Route::delete('/galeri/{galeri}', [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');
        Route::delete('/galeri/{galeri}/image/{galeriImage}', [AdminGaleriController::class, 'destroyImage'])->name('galeri.destroy-image');
        Route::get('/galeri-tile', [AdminGaleriTileController::class, 'index'])->name('galeri-tile.index');
        Route::put('/galeri-tile/{galeriTile}', [AdminGaleriTileController::class, 'update'])->name('galeri-tile.update');
        Route::delete('/galeri-tile/{galeriTile}/image', [AdminGaleriTileController::class, 'destroyImage'])->name('galeri-tile.destroy-image');
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
    Route::get('/', [ProfilePageController::class, 'index'])->name('index');
    Route::get('/tugas_dan_fungsi', [ProfilePageController::class, 'tugasDanFungsi'])->name('tugas_dan_fungsi');
    Route::get('/visi_misi', [ProfilePageController::class, 'visiMisi'])->name('visi_misi');
    Route::get('/struktur_organisasi', [ProfilePageController::class, 'strukturOrganisasi'])->name('struktur_organisasi');
    Route::get('/zona_integritas', [ProfilePageController::class, 'zonaIntegritas'])->name('zona_integritas');
    Route::get('/lokasi_dan_kontak', [ProfilePageController::class, 'lokasiDanKontak'])->name('lokasi_dan_kontak');
    Route::get('/{profilePage:slug}', [ProfilePageController::class, 'showPage'])->name('show');
});

Route::prefix('publikasi')->name('publikasi.')->group(function () {
    Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
    Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');
    Route::get('/buletin', [BuletinController::class, 'index'])->name('buletin.index');
    Route::get('/buletin/{buletin:slug}', [BuletinController::class, 'show'])->name('buletin.show');
    Route::view('/pengumuman', 'pages.menu_detail', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Pengumuman'])->name('pengumuman');
    Route::get('/infografis', [InfografisController::class, 'index'])->name('infografis');
    Route::view('/galeri', 'pages.menu_detail', ['menuGroup' => 'Publikasi', 'pageTitle' => 'Galeri'])->name('galeri');
    Route::get('/galeri/foto', [GaleriFotoController::class, 'index'])->name('galeri.foto');
    Route::get('/galeri/video', [GaleriVideoController::class, 'index'])->name('galeri.video');
});

Route::prefix('informasi_publik')->name('informasi_publik.')->group(function () {
    Route::get('/informasi_berkala', [InformasiBerkalaController::class, 'index'])->name('informasi_berkala');
    Route::get('/informasi_serta_merta', [InformasiSertaMertaController::class, 'index'])->name('informasi_serta_merta');
    Route::get('/informasi_tersedia_setiap_saat', [InformasiTersediaSetiapSaatController::class, 'index'])->name('informasi_tersedia_setiap_saat');
});

Route::prefix('pelayanan_publik')->name('pelayanan_publik.')->group(function () {
    Route::view('/standar_pelayanan', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Standar Pelayanan'])->name('standar_pelayanan');
    Route::view('/maklumat_pelayanan', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Maklumat Pelayanan'])->name('maklumat_pelayanan');
    Route::view('/permintaan_pelayanan', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Permintaan Pelayanan'])->name('permintaan_pelayanan');
    Route::view('/permintaan_pelayanan/data', 'pages.pelayanan_publik.permintaan_pelayanan_data')->name('permintaan_pelayanan_data');
    Route::view('/permintaan_pelayanan/magang', 'pages.pelayanan_publik.permintaan_pelayanan_magang')->name('permintaan_pelayanan_magang');
    Route::view('/peminjaman_ruangan', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Peminjaman Ruangan'])->name('peminjaman_ruangan');
    Route::view('/permintaan_pelayanan/advis', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Permintaan Pelayanan Advis'])->name('permintaan_pelayanan_advis');
    Route::view('/e_ppid', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'E-PPID'])->name('e_ppid');
    Route::view('/layanan_pengaduan', 'pages.menu_detail', ['menuGroup' => 'Pelayanan Publik', 'pageTitle' => 'Layanan Pengaduan'])->name('layanan_pengaduan');
    Route::get('/laporan_skm', [LaporanSkmController::class, 'index'])->name('laporan_skm');
});

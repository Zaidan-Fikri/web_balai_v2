<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Buletin;
use App\Models\Infografis;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));
        $results = collect();

        if ($query !== '') {
            $results = $this->menuResults($query)
                ->merge($this->beritaResults($query))
                ->merge($this->buletinResults($query))
                ->merge($this->infografisResults($query))
                ->sortBy('title', SORT_NATURAL | SORT_FLAG_CASE)
                ->values();
        }

        return view('pages.search', [
            'query' => $query,
            'results' => $results,
        ]);
    }

    private function menuResults(string $query): Collection
    {
        $menus = collect([
            ['title' => 'Profil Balai Air Tanah', 'category' => 'Profil', 'url' => route('profil.index'), 'excerpt' => 'Informasi profil Balai Air Tanah.'],
            ['title' => 'Tugas dan Fungsi', 'category' => 'Profil', 'url' => route('profil.tugas_dan_fungsi'), 'excerpt' => 'Tugas dan fungsi Balai Air Tanah.'],
            ['title' => 'Visi dan Misi', 'category' => 'Profil', 'url' => route('profil.visi_misi'), 'excerpt' => 'Visi dan misi organisasi.'],
            ['title' => 'Struktur Organisasi', 'category' => 'Profil', 'url' => route('profil.struktur_organisasi'), 'excerpt' => 'Struktur organisasi Balai Air Tanah.'],
            ['title' => 'Lokasi dan Kontak', 'category' => 'Profil', 'url' => route('profil.lokasi_dan_kontak'), 'excerpt' => 'Alamat, lokasi, dan kontak Balai Air Tanah.'],
            ['title' => 'Layanan Terpadu', 'category' => 'Pelayanan Publik', 'url' => route('pelayanan_publik.permintaan_pelayanan'), 'excerpt' => 'Permintaan layanan terpadu Balai Air Tanah.'],
            ['title' => 'Layanan Advis', 'category' => 'Pelayanan Publik', 'url' => route('pelayanan_publik.permintaan_pelayanan_advis'), 'excerpt' => 'Permintaan pelayanan advis teknis.'],
            ['title' => 'Permintaan Data', 'category' => 'Pelayanan Publik', 'url' => route('pelayanan_publik.permintaan_pelayanan_data'), 'excerpt' => 'Permintaan data air tanah.'],
            ['title' => 'Permintaan Magang', 'category' => 'Pelayanan Publik', 'url' => route('pelayanan_publik.permintaan_pelayanan_magang'), 'excerpt' => 'Informasi dan formulir permintaan magang.'],
            ['title' => 'Layanan Pengaduan', 'category' => 'Pelayanan Publik', 'url' => route('pelayanan_publik.layanan_pengaduan'), 'excerpt' => 'Kanal layanan pengaduan masyarakat.'],
            ['title' => 'Laporan SKM', 'category' => 'Pelayanan Publik', 'url' => route('pelayanan_publik.laporan_skm'), 'excerpt' => 'Himpunan laporan survei kepuasan masyarakat.'],
            ['title' => 'Standar Pelayanan', 'category' => 'Pelayanan Publik', 'url' => route('pelayanan_publik.standar_pelayanan'), 'excerpt' => 'Standar pelayanan publik Balai Air Tanah.'],
            ['title' => 'Maklumat Pelayanan', 'category' => 'Pelayanan Publik', 'url' => route('pelayanan_publik.maklumat_pelayanan'), 'excerpt' => 'Maklumat pelayanan publik.'],
            ['title' => 'Informasi Berkala', 'category' => 'Informasi Publik', 'url' => route('informasi_publik.informasi_berkala'), 'excerpt' => 'Daftar informasi publik berkala.'],
            ['title' => 'Informasi Serta Merta', 'category' => 'Informasi Publik', 'url' => route('informasi_publik.informasi_serta_merta'), 'excerpt' => 'Daftar informasi publik serta merta.'],
            ['title' => 'Informasi Tersedia Setiap Saat', 'category' => 'Informasi Publik', 'url' => route('informasi_publik.informasi_tersedia_setiap_saat'), 'excerpt' => 'Informasi publik yang tersedia setiap saat.'],
            ['title' => 'Berita', 'category' => 'Publikasi', 'url' => route('publikasi.berita'), 'excerpt' => 'Publikasi berita Balai Air Tanah.'],
            ['title' => 'Edukasi', 'category' => 'Publikasi', 'url' => route('publikasi.buletin.index'), 'excerpt' => 'Materi edukasi Balai Air Tanah.'],
            ['title' => 'Pengumuman', 'category' => 'Publikasi', 'url' => route('publikasi.pengumuman'), 'excerpt' => 'Pengumuman resmi Balai Air Tanah.'],
            ['title' => 'Infografis', 'category' => 'Publikasi', 'url' => route('publikasi.infografis'), 'excerpt' => 'Publikasi infografis.'],
            ['title' => 'Galeri', 'category' => 'Publikasi', 'url' => route('publikasi.galeri'), 'excerpt' => 'Galeri kegiatan Balai Air Tanah.'],
            ['title' => 'Galeri Foto', 'category' => 'Publikasi', 'url' => route('publikasi.galeri.foto'), 'excerpt' => 'Galeri foto kegiatan Balai Air Tanah.'],
            ['title' => 'Galeri Video', 'category' => 'Publikasi', 'url' => route('publikasi.galeri.video'), 'excerpt' => 'Galeri video kegiatan Balai Air Tanah.'],
            ['title' => 'GEMS', 'category' => 'Layanan Unggulan', 'url' => route('gems'), 'excerpt' => 'Layanan unggulan GEMS.'],
            ['title' => 'Laboratorium', 'category' => 'Layanan Unggulan', 'url' => route('laboratorium'), 'excerpt' => 'Informasi layanan laboratorium.'],
            ['title' => 'Peta', 'category' => 'Data', 'url' => route('peta'), 'excerpt' => 'Peta informasi air tanah.'],
        ]);

        return $menus
            ->filter(fn (array $item): bool => $this->matches($item, $query))
            ->map(fn (array $item): array => $item + ['type' => 'Halaman']);
    }

    private function beritaResults(string $query): Collection
    {
        return Berita::query()
            ->where('judul', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn (Berita $berita): array => [
                'title' => $berita->judul,
                'category' => 'Publikasi',
                'type' => 'Berita',
                'url' => route('publikasi.berita.show', $berita),
                'excerpt' => Str::limit(strip_tags($berita->deskripsi), 180),
            ]);
    }

    private function buletinResults(string $query): Collection
    {
        return Buletin::query()
            ->published()
            ->where(function ($builder) use ($query): void {
                $builder
                    ->where('judul', 'like', "%{$query}%")
                    ->orWhere('isi', 'like', "%{$query}%");
            })
            ->latest('published_at')
            ->limit(8)
            ->get()
            ->map(fn (Buletin $buletin): array => [
                'title' => $buletin->judul,
                'category' => 'Publikasi',
                'type' => 'Edukasi',
                'url' => route('publikasi.buletin.show', $buletin),
                'excerpt' => Str::limit(strip_tags($buletin->isi), 180),
            ]);
    }

    private function infografisResults(string $query): Collection
    {
        return Infografis::query()
            ->where('judul', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn (Infografis $infografis): array => [
                'title' => $infografis->judul,
                'category' => 'Publikasi',
                'type' => 'Infografis',
                'url' => route('publikasi.infografis'),
                'excerpt' => Str::limit(strip_tags($infografis->deskripsi), 180),
            ]);
    }

    private function matches(array $item, string $query): bool
    {
        $haystack = Str::lower(implode(' ', [
            $item['title'],
            $item['category'],
            $item['excerpt'],
        ]));

        return Str::contains($haystack, Str::lower($query));
    }
}

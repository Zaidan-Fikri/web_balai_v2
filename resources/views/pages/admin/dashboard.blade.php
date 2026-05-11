@extends('master.admin.app')

@section('title', 'Admin Dashboard')

@section('content')
    <section>
        <div class="panel full-card">
            <div class="section-head">
                <div>
                    <p class="page-kicker">Ringkasan CMS</p>
                    <h3>Dashboard</h3>
                </div>
            </div>

            <div class="dashboard-grid">
                <div class="stat-card">
                    <span>Konten</span>
                    <strong>10</strong>
                    <small>Menu CMS aktif</small>
                </div>
                <div class="stat-card">
                    <span>Akses</span>
                    <strong>Admin</strong>
                    <small>Session server-side</small>
                </div>
                <div class="stat-card">
                    <span>Asset</span>
                    <strong>Vite</strong>
                    <small>CSS dan JS eksternal</small>
                </div>
                <div class="stat-card">
                    <span>Status</span>
                    <strong>Ready</strong>
                    <small>Panel pengelolaan data</small>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Area</th>
                        <th>Fungsi</th>
                        <th>Validasi</th>
                        <th>Asset</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Berita & Galeri</td>
                        <td>Kelola judul, deskripsi, dan gambar</td>
                        <td>Form Request Laravel</td>
                        <td>CSS/JS Admin</td>
                        <td class="status good">Aktif</td>
                    </tr>
                    <tr>
                        <td>Publikasi Dokumen</td>
                        <td>Karya Ilmiah, SNI, Laporan SKM</td>
                        <td>Upload thumbnail dan PDF</td>
                        <td>CSS/JS Admin</td>
                        <td class="status good">Aktif</td>
                    </tr>
                    <tr>
                        <td>Pengumuman</td>
                        <td>Kelola gambar pengumuman</td>
                        <td>Validasi upload server-side</td>
                        <td>CSS/JS Admin</td>
                        <td class="status good">Aktif</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

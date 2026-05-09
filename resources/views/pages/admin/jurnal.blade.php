@extends('master.admin.app')

@section('title', 'Admin Jurnal')

@section('content')

    <section>
        <div class="panel full-card">
            <div class="berita-head">
                <h3>Jurnal</h3>
                <button type="button" class="btn-plus" aria-label="Tambah jurnal">+</button>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>Judul Jurnal</th>
                        <th>Terbit</th>
                        <th>Sitasi</th>
                        <th>Unduhan</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Evaluasi Pola Aliran DAS</td>
                        <td>10 Jan, 2026</td>
                        <td>127</td>
                        <td>2,802</td>
                        <td class="status good">Indexed</td>
                    </tr>
                    <tr>
                        <td>Mitigasi Banjir Perkotaan</td>
                        <td>06 Jan, 2026</td>
                        <td>92</td>
                        <td>1,943</td>
                        <td class="status warn">Revision</td>
                    </tr>
                    <tr>
                        <td>Studi Ketahanan Tanggul</td>
                        <td>02 Jan, 2026</td>
                        <td>44</td>
                        <td>1,122</td>
                        <td class="status bad">Archived</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

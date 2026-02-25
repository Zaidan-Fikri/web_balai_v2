@extends('master.admin.app')

@section('title', 'Admin Jurnal')

@section('content')
    <style>
        .berita-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
        }

        .berita-head h3 {
            margin: 0;
            font-size: clamp(34px, 7vw, 40px);
            line-height: 1.15;
            min-width: 0;
            flex: 1;
        }

        .btn-plus {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            border: 1px solid #d9d9d9;
            background: #fff;
            font-size: 30px;
            line-height: 1;
            color: #14161b;
            cursor: pointer;
            transition: background-color .2s ease, color .2s ease, border-color .2s ease;
        }

        .btn-plus:hover {
            background: #111217;
            color: #fff;
            border-color: #111217;
        }
    </style>

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

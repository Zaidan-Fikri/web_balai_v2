@extends('master.admin.app')

@section('title', 'Geolistrik 1D')

@section('content')
    @php
        $totalCount = array_sum($uptCounts);
        $allBalaiFlat           = collect($allBalai)->flatMap(fn($g) => $g['items']);
        $balaiAktif             = $allBalaiFlat->filter(fn($b) => ($uptCounts[$b['name']] ?? 0) > 0)->count();
        $totalBalai             = $allBalaiFlat->count();
        $progressPct            = $totalBalai > 0 ? round($balaiAktif / $totalBalai * 100) : 0;
    @endphp

    <section class="geo-main geo1d-main">

        <div class="panel full-card">
            <div class="item-head">
                <div>
                    @if ($selectedUpt !== '')
                        <p class="page-kicker">{{ Str::startsWith($selectedUpt, 'Balai Besar') ? 'BBWS' : 'BWS' }}</p>
                    @endif
                    <h3>Geolistrik 1D{{ $selectedUpt !== '' ? ' — ' . Str::after($selectedUpt, 'Sungai ') : '' }}</h3>
                    @if ($selectedUpt !== '')
                        <a href="{{ route('admin.geolistrik-1d.index') }}" class="geo-clear-filter">
                            <i class="fa-solid fa-xmark" aria-hidden="true"></i> Hapus filter
                        </a>
                    @endif
                </div>
                <div class="item-head-actions">
                    {{-- Filter Wilayah dropdown --}}
                    <div class="geo-dd-wrap" id="geoBalaiDropdown">
                        <button type="button" class="geo-dd-btn {{ $selectedUpt !== '' ? 'is-active' : '' }}" id="geoBalaiToggle" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-folder-tree" aria-hidden="true"></i>
                            <span>{{ $selectedUpt !== '' ? Str::after($selectedUpt, 'Sungai ') : 'Wilayah' }}</span>
                            <i class="fa-solid fa-chevron-down geo-dd-caret" aria-hidden="true"></i>
                        </button>
                        <div class="geo-dd-menu" id="geoBalaiMenu" hidden>
                            <div class="geo-dd-header">
                                <span class="geo-dd-title"><i class="fa-solid fa-folder-tree"></i> Wilayah Sungai</span>
                                <div class="geo-progress-wrap" style="margin-top:6px">
                                    <div class="geo-progress-bar">
                                        <div class="geo-progress-fill" style="width:{{ $progressPct }}%"></div>
                                    </div>
                                    <span class="geo-progress-text">{{ $balaiAktif }}/{{ $totalBalai }} balai memiliki data</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.geolistrik-1d.index') }}"
                               class="geo-folder-all {{ $selectedUpt === '' ? 'is-active' : '' }}">
                                <i class="fa-solid fa-layer-group" aria-hidden="true"></i>
                                <span>Semua Data</span>
                                <span class="geo-badge">{{ $totalCount }}</span>
                            </a>
                            @foreach ($allBalai as $group)
                                @php
                                    $groupHasActive = collect($group['items'])->contains('name', $selectedUpt);
                                    $groupAktif     = collect($group['items'])->filter(fn($b) => ($uptCounts[$b['name']] ?? 0) > 0)->count();
                                    $groupTotal     = count($group['items']);
                                @endphp
                                <details class="geo-folder-group" {{ $groupHasActive ? 'open' : '' }}>
                                    <summary class="geo-folder-group-label">
                                        <i class="fa-solid fa-chevron-right geo-caret" aria-hidden="true"></i>
                                        <i class="fa-solid {{ $group['icon'] }} geo-region-icon" aria-hidden="true"></i>
                                        <span>{{ $group['label'] }}</span>
                                        <span class="geo-group-meta">{{ $groupAktif }}/{{ $groupTotal }}</span>
                                    </summary>
                                    @foreach ($group['items'] as $balai)
                                        @php $count = $uptCounts[$balai['name']] ?? 0; @endphp
                                        <a href="{{ route('admin.geolistrik-1d.index', ['upt' => $balai['name']]) }}"
                                           class="geo-folder-item {{ $selectedUpt === $balai['name'] ? 'is-active' : '' }} {{ $count === 0 ? 'is-empty' : '' }}"
                                           title="{{ $balai['name'] }}">
                                            <i class="fa-{{ $count > 0 ? 'solid fa-folder-open' : 'regular fa-folder' }}" aria-hidden="true"></i>
                                            <span>{{ $balai['short'] }}</span>
                                            @if ($count > 0)
                                                <span class="geo-badge">{{ $count }}</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </details>
                            @endforeach
                        </div>
                    </div>
                    <button type="button" class="btn-upload-excel" id="openGeolistrikImportPopup">
                        <i class="fa-solid fa-file-excel" aria-hidden="true"></i>
                        <span>Upload Excel</span>
                    </button>
                    <button type="button" class="btn-plus" id="openGeolistrikPopup" aria-label="Tambah Geolistrik 1D">+</button>
                </div>
            </div>

            @if (session('success'))<div class="flash-success">{{ session('success') }}</div>@endif
            @if (session('error'))<div class="flash-error">{{ session('error') }}</div>@endif
            @if ($errors->any())<div class="flash-error">{{ $errors->first() }}</div>@endif

            @if ($geolistrik1ds->isEmpty())
                {{-- Empty State --}}
                <div class="geo-empty-state">
                    <div class="geo-empty-icon">
                        <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
                    </div>
                    <p class="geo-empty-title">Belum ada data</p>
                    @if ($selectedUpt !== '')
                        <p class="geo-empty-sub">{{ $selectedUpt }} belum memiliki data titik geolistrik.</p>
                    @else
                        <p class="geo-empty-sub">Belum ada data Geolistrik 1D. Mulai dengan upload file Excel.</p>
                    @endif
                    <div class="geo-empty-actions">
                        <button type="button" class="btn-upload-excel" onclick="document.getElementById('openGeolistrikImportPopup').click()">
                            <i class="fa-solid fa-file-excel" aria-hidden="true"></i> Upload Excel
                        </button>
                    </div>
                </div>
            @else
                <div class="table-toolbar">
                    <div class="table-toolbar-meta">
                        Menampilkan {{ $geolistrik1ds->firstItem() }}&ndash;{{ $geolistrik1ds->lastItem() }} dari {{ $geolistrik1ds->total() }} data
                    </div>
                    <form method="GET" class="table-page-size-form">
                        @if ($selectedUpt !== '')
                            <input type="hidden" name="upt" value="{{ $selectedUpt }}">
                        @endif
                        <label for="perPageInput">Data per halaman</label>
                        <input type="number" id="perPageInput" name="per_page" value="{{ $perPage }}" min="1" max="100" step="1">
                        <button type="submit" class="btn-action">Terapkan</button>
                    </form>
                </div>

                <div class="bulk-actions-bar" id="geolistrikBulkBar">
                    <span class="bulk-actions-count"><strong id="geolistrikBulkCount">0</strong> data terpilih</span>
                    <div class="bulk-actions-buttons">
                        <button type="button" class="btn-action" id="geolistrikBulkClear">Batal Pilih</button>
                        <button type="button" class="bulk-actions-delete-btn" id="geolistrikBulkDeleteBtn">
                            <i class="fa-solid fa-trash" aria-hidden="true"></i> Hapus Terpilih
                        </button>
                    </div>
                </div>
                <form method="POST" id="geolistrikBulkDeleteForm" action="{{ route('admin.geolistrik-1d.bulk-destroy') }}">
                    @csrf
                    @method('DELETE')
                </form>

                <div class="table-wrap">
                    <table class="item-table geolistrik-table">
                        <thead>
                        <tr>
                            <th class="bulk-checkbox-col"><input type="checkbox" class="js-bulk-select-all" id="geolistrikSelectAll" aria-label="Pilih semua"></th>
                            <th>Kode</th>
                            <th>Kab/Kota</th>
                            <th>Kecamatan</th>
                            <th>Desa/Kelurahan</th>
                            @if ($selectedUpt === '') <th>UPT</th> @endif
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Elevasi</th>
                            <th>Tanggal Akusisi Data</th>
                            <th>Geologi</th>
                            <th>Cekungan Air Tanah</th>
                            <th>Hidrogeologi</th>
                            <th>Lapisan Pembawa Air</th>
                            <th>Potensi</th>
                            <th>PDF</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($geolistrik1ds as $item)
                            <tr>
                                <td class="bulk-checkbox-col"><input type="checkbox" class="js-bulk-checkbox" value="{{ $item->id }}" aria-label="Pilih {{ $item->kode }}"></td>
                                <td class="col-nowrap">{{ $item->kode ?? '-' }}</td>
                                <td>{{ $item->kab_kota ?? '-' }}</td>
                                <td>{{ $item->kecamatan ?? '-' }}</td>
                                <td>{{ $item->desa_kelurahan ?? '-' }}</td>
                                @if ($selectedUpt === '') <td>{{ $item->upt ?? '-' }}</td> @endif
                                <td class="col-nowrap">{{ number_format($item->latitude, 7, '.', '') }}</td>
                                <td class="col-nowrap">{{ number_format($item->longitude, 7, '.', '') }}</td>
                                <td class="col-nowrap">{{ $item->elevasi ?? '-' }}</td>
                                <td class="col-nowrap">{{ $item->tanggal_akusisi_data ?? '-' }}</td>
                                <td>{{ $item->geologi ?? '-' }}</td>
                                <td>{{ $item->cekungan_air_tanah ?? '-' }}</td>
                                <td>{{ $item->hidrogeologi ?? '-' }}</td>
                                <td>{{ $item->lapisan_pembawa_air ?? '-' }}</td>
                                <td>{{ $item->potensi ?? '-' }}</td>
                                <td class="col-nowrap">
                                    @if ($item->pdf_path)
                                        <a class="btn-action read" href="{{ $item->pdf_url }}" target="_blank" rel="noopener">PDF</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="action-group">
                                        <button type="button" class="btn-action read js-geolistrik-read-btn"
                                            data-kode="{{ $item->kode }}"
                                            data-kab-kota="{{ $item->kab_kota }}"
                                            data-kecamatan="{{ $item->kecamatan }}"
                                            data-desa-kelurahan="{{ $item->desa_kelurahan }}"
                                            data-upt="{{ $item->upt }}"
                                            data-latitude="{{ number_format($item->latitude, 7, '.', '') }}"
                                            data-longitude="{{ number_format($item->longitude, 7, '.', '') }}"
                                            data-elevasi="{{ $item->elevasi }}"
                                            data-tanggal-akusisi-data="{{ $item->tanggal_akusisi_data }}"
                                            data-geologi="{{ $item->geologi }}"
                                            data-cekungan-air-tanah="{{ $item->cekungan_air_tanah }}"
                                            data-hidrogeologi="{{ $item->hidrogeologi }}"
                                            data-lapisan-pembawa-air="{{ $item->lapisan_pembawa_air }}"
                                            data-potensi="{{ $item->potensi }}"
                                            data-pdf-url="{{ $item->pdf_url }}"
                                            data-pdf-name="{{ $item->pdf_name }}"
                                        >Read</button>
                                        <button type="button" class="btn-action update js-geolistrik-update-btn"
                                            data-update-url="{{ route('admin.geolistrik-1d.update', $item->id) }}"
                                            data-kode="{{ $item->kode }}"
                                            data-kab-kota="{{ $item->kab_kota }}"
                                            data-kecamatan="{{ $item->kecamatan }}"
                                            data-desa-kelurahan="{{ $item->desa_kelurahan }}"
                                            data-upt="{{ $item->upt }}"
                                            data-latitude="{{ number_format($item->latitude, 7, '.', '') }}"
                                            data-longitude="{{ number_format($item->longitude, 7, '.', '') }}"
                                            data-elevasi="{{ $item->elevasi }}"
                                            data-tanggal-akusisi-data="{{ $item->tanggal_akusisi_data }}"
                                            data-geologi="{{ $item->geologi }}"
                                            data-cekungan-air-tanah="{{ $item->cekungan_air_tanah }}"
                                            data-hidrogeologi="{{ $item->hidrogeologi }}"
                                            data-lapisan-pembawa-air="{{ $item->lapisan_pembawa_air }}"
                                            data-potensi="{{ $item->potensi }}"
                                            data-pdf-url="{{ $item->pdf_url }}"
                                            data-pdf-name="{{ $item->pdf_name }}"
                                        >Update</button>
                                        <form method="POST" action="{{ route('admin.geolistrik-1d.destroy', $item->id) }}" class="js-geolistrik-delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-action delete">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($geolistrik1ds->hasPages())
                    <div class="pagination-wrap">
                        <nav class="admin-pagination" aria-label="Pagination Geolistrik 1D">
                            @if ($geolistrik1ds->onFirstPage())
                                <span class="page-link disabled">&laquo; Previous</span>
                            @else
                                <a class="page-link" href="{{ $geolistrik1ds->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                            @endif
                            @php
                                $currentPage  = $geolistrik1ds->currentPage();
                                $lastPage     = $geolistrik1ds->lastPage();
                                $pages        = collect([1, $lastPage])->merge(range(max(1, $currentPage - 2), min($lastPage, $currentPage + 2)))->unique()->sort()->values();
                                $previousPage = 0;
                            @endphp
                            @foreach ($pages as $page)
                                @if ($previousPage && $page > $previousPage + 1)<span class="page-link dots">...</span>@endif
                                @if ($page === $currentPage)
                                    <span class="page-link active" aria-current="page">{{ $page }}</span>
                                @else
                                    <a class="page-link" href="{{ $geolistrik1ds->url($page) }}">{{ $page }}</a>
                                @endif
                                @php($previousPage = $page)
                            @endforeach
                            @if ($geolistrik1ds->hasMorePages())
                                <a class="page-link" href="{{ $geolistrik1ds->nextPageUrl() }}" rel="next">Next &raquo;</a>
                            @else
                                <span class="page-link disabled">Next &raquo;</span>
                            @endif
                        </nav>
                    </div>
                @endif
            @endif
        </div>
    </section>{{-- /geo-main --}}

    <div class="popup-overlay" id="geolistrikImportOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4>Upload Excel Geolistrik 1D</h4>
            <form method="POST" action="{{ route('admin.geolistrik-1d.import-preview') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="selected_upt" value="{{ $selectedUpt }}">
                <input type="file" class="popup-input" id="geolistrikImportFile" name="excel_file" accept=".xlsx,.csv" required>
                @if ($selectedUpt !== '')
                    <span class="popup-help popup-help-info">
                        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                        Baris tanpa kolom UPT akan otomatis diisi: <strong>{{ $selectedUpt }}</strong>
                    </span>
                @endif
                <span class="popup-help">Gunakan header: KODE, KAB/KOTA, KECAMATAN, DESA/KELURAHAN, UPT, LATITUDE, LONGITUDE, ELEVASI, TANGGAL AKUSISI DATA, GEOLOGI, CEKUNGAN AIR TANAH, HIDROGEOLOGI, LAPISAN PEMBAWA AIR, POTENSI, PDF (atau FOTO/LINK). Kolom PDF boleh diisi link Google Drive dsb., baik sebagai teks biasa maupun hyperlink.</span>
                <div class="popup-actions">
                    <button type="button" class="btn-action" data-close-overlay="geolistrikImportOverlay">Batal</button>
                    <button type="submit" class="btn-primary">Preview</button>
                </div>
            </form>
        </div>
    </div>

    @if (count($importPreviewRows))
        <div class="popup-overlay" id="geolistrikImportPreviewOverlay" aria-hidden="true">
            <div class="popup-card import-preview-card">
                <h4>Preview Data Excel</h4>
                @if ($importPreviewErrorCount > 0)
                    <div class="flash-error">Ada {{ $importPreviewErrorCount }} baris yang belum valid. Data belum bisa ditambahkan.</div>
                @else
                    <div class="flash-success">{{ count($importPreviewRows) }} baris siap ditambahkan.@if ($importPreviewWarnCount > 0) {{ $importPreviewWarnCount }} baris memiliki peringatan UPT — periksa kolom Status.@endif</div>
                @endif

                <div class="table-wrap import-preview-wrap">
                    <table class="item-table geolistrik-table import-preview-table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Kab/Kota</th>
                            <th>Kecamatan</th>
                            <th>Desa/Kelurahan</th>
                            <th>UPT</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Elevasi</th>
                            <th>Tanggal Akusisi Data</th>
                            <th>Geologi</th>
                            <th>Cekungan Air Tanah</th>
                            <th>Hidrogeologi</th>
                            <th>Lapisan Pembawa Air</th>
                            <th>Potensi</th>
                            <th>PDF</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($importPreviewRows as $row)
                            @php($data = $row['data'])
                            <tr>
                                <td>{{ $row['number'] }}</td>
                                <td>{{ $data['kode'] ?? '-' }}</td>
                                <td>{{ $data['kab_kota'] ?? '-' }}</td>
                                <td>{{ $data['kecamatan'] ?? '-' }}</td>
                                <td>{{ $data['desa_kelurahan'] ?? '-' }}</td>
                                <td>{{ $data['upt'] ?? '-' }}</td>
                                <td>{{ $data['latitude'] ?? '-' }}</td>
                                <td>{{ $data['longitude'] ?? '-' }}</td>
                                <td>{{ $data['elevasi'] ?? '-' }}</td>
                                <td>{{ $data['tanggal_akusisi_data'] ?? '-' }}</td>
                                <td>{{ $data['geologi'] ?? '-' }}</td>
                                <td>{{ $data['cekungan_air_tanah'] ?? '-' }}</td>
                                <td>{{ $data['hidrogeologi'] ?? '-' }}</td>
                                <td>{{ $data['lapisan_pembawa_air'] ?? '-' }}</td>
                                <td>{{ $data['potensi'] ?? '-' }}</td>
                                <td>{{ $data['pdf_path'] ?? '-' }}</td>
                                <td>
                                    @if (count($row['errors']))
                                        <span class="status bad">Error</span>
                                        <small class="import-row-errors">{{ implode(', ', $row['errors']) }}</small>
                                    @elseif (count($row['warnings'] ?? []))
                                        <span class="status warn">Peringatan</span>
                                        <small class="import-row-errors">{{ implode(', ', $row['warnings']) }}</small>
                                    @else
                                        <span class="status good">Valid</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <form method="POST" action="{{ route('admin.geolistrik-1d.import-store') }}">
                    @csrf
                    <div class="popup-actions has-gap">
                        <button type="button" class="btn-action" data-close-overlay="geolistrikImportPreviewOverlay">Batal</button>
                        <button type="submit" class="btn-primary" @disabled($importPreviewErrorCount > 0)>Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="popup-overlay" id="geolistrikCreateOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4>Tambah Geolistrik 1D</h4>
            <form method="POST" action="{{ route('admin.geolistrik-1d.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <input type="text" class="popup-input" id="createGeolistrikKode" name="kode" value="{{ old('kode') }}" placeholder="Kode" required>
                <input type="text" class="popup-input" name="kab_kota" value="{{ old('kab_kota') }}" placeholder="Kab/Kota">
                <input type="text" class="popup-input" name="kecamatan" value="{{ old('kecamatan') }}" placeholder="Kecamatan">
                <input type="text" class="popup-input" name="desa_kelurahan" value="{{ old('desa_kelurahan') }}" placeholder="Desa/Kelurahan">
                <input type="text" class="popup-input" name="upt" value="{{ old('upt') }}" placeholder="UPT">
                <input type="number" class="popup-input" name="latitude" value="{{ old('latitude') }}" placeholder="Latitude, contoh: -6.2088000" min="-11.2" max="6.2" step="0.0000001" required>
                <input type="number" class="popup-input" name="longitude" value="{{ old('longitude') }}" placeholder="Longitude, contoh: 106.8456000" min="94.6" max="141.1" step="0.0000001" required>
                <input type="text" class="popup-input" name="elevasi" value="{{ old('elevasi') }}" placeholder="Elevasi">
                <input type="date" class="popup-input" name="tanggal_akusisi_data" value="{{ old('tanggal_akusisi_data') }}" placeholder="Tanggal Akusisi Data">
                <textarea class="popup-input" name="geologi" placeholder="Geologi">{{ old('geologi') }}</textarea>
                <input type="text" class="popup-input" name="cekungan_air_tanah" value="{{ old('cekungan_air_tanah') }}" placeholder="Cekungan Air Tanah">
                <textarea class="popup-input" name="hidrogeologi" placeholder="Hidrogeologi">{{ old('hidrogeologi') }}</textarea>
                <textarea class="popup-input" name="lapisan_pembawa_air" placeholder="Lapisan Pembawa Air">{{ old('lapisan_pembawa_air') }}</textarea>
                <textarea class="popup-input" name="potensi" placeholder="Potensi">{{ old('potensi') }}</textarea>
                <input type="file" class="popup-input" name="pdf_file" accept=".pdf,application/pdf">
                <span class="popup-help">Koordinat dibatasi dalam wilayah Indonesia.</span>
                <div class="popup-actions"><button type="submit" class="btn-primary">Tambah</button></div>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="geolistrikReadOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4 id="readGeolistrikNama">Detail Geolistrik 1D</h4>
            <p class="read-meta">Kode: <strong id="readGeolistrikKode">-</strong></p>
            <p class="read-meta">Kab/Kota: <strong id="readGeolistrikKabKota">-</strong></p>
            <p class="read-meta">Kecamatan: <strong id="readGeolistrikKecamatan">-</strong></p>
            <p class="read-meta">Desa/Kelurahan: <strong id="readGeolistrikDesaKelurahan">-</strong></p>
            <p class="read-meta">UPT: <strong id="readGeolistrikUpt">-</strong></p>
            <p class="read-meta">Latitude: <strong id="readGeolistrikLatitude">-</strong></p>
            <p class="read-meta">Longitude: <strong id="readGeolistrikLongitude">-</strong></p>
            <p class="read-meta">Elevasi: <strong id="readGeolistrikElevasi">-</strong></p>
            <p class="read-meta">Tanggal Akusisi Data: <strong id="readGeolistrikTanggalAkusisiData">-</strong></p>
            <p class="read-meta">Geologi: <strong id="readGeolistrikGeologi">-</strong></p>
            <p class="read-meta">Cekungan Air Tanah: <strong id="readGeolistrikCekunganAirTanah">-</strong></p>
            <p class="read-meta">Hidrogeologi: <strong id="readGeolistrikHidrogeologi">-</strong></p>
            <p class="read-meta">Lapisan Pembawa Air: <strong id="readGeolistrikLapisanPembawaAir">-</strong></p>
            <p class="read-meta">Potensi: <strong id="readGeolistrikPotensi">-</strong></p>
            <p class="read-meta">PDF: <strong id="readGeolistrikPdf">-</strong></p>
            <div class="popup-actions"><button type="button" class="btn-primary" data-close-overlay="geolistrikReadOverlay">Tutup</button></div>
        </div>
    </div>

    <div class="popup-overlay" id="geolistrikUpdateOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4>Update Geolistrik 1D</h4>
            <form method="POST" id="geolistrikUpdateForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="update">
                <input type="text" class="popup-input" id="updateGeolistrikKode" name="kode" placeholder="Kode" required>
                <input type="text" class="popup-input" id="updateGeolistrikKabKota" name="kab_kota" placeholder="Kab/Kota">
                <input type="text" class="popup-input" id="updateGeolistrikKecamatan" name="kecamatan" placeholder="Kecamatan">
                <input type="text" class="popup-input" id="updateGeolistrikDesaKelurahan" name="desa_kelurahan" placeholder="Desa/Kelurahan">
                <input type="text" class="popup-input" id="updateGeolistrikUpt" name="upt" placeholder="UPT">
                <input type="number" class="popup-input" id="updateGeolistrikLatitude" name="latitude" placeholder="Latitude" min="-11.2" max="6.2" step="0.0000001" required>
                <input type="number" class="popup-input" id="updateGeolistrikLongitude" name="longitude" placeholder="Longitude" min="94.6" max="141.1" step="0.0000001" required>
                <input type="text" class="popup-input" id="updateGeolistrikElevasi" name="elevasi" placeholder="Elevasi">
                <input type="date" class="popup-input" id="updateGeolistrikTanggalAkusisiData" name="tanggal_akusisi_data" placeholder="Tanggal Akusisi Data">
                <textarea class="popup-input" id="updateGeolistrikGeologi" name="geologi" placeholder="Geologi"></textarea>
                <input type="text" class="popup-input" id="updateGeolistrikCekunganAirTanah" name="cekungan_air_tanah" placeholder="Cekungan Air Tanah">
                <textarea class="popup-input" id="updateGeolistrikHidrogeologi" name="hidrogeologi" placeholder="Hidrogeologi"></textarea>
                <textarea class="popup-input" id="updateGeolistrikLapisanPembawaAir" name="lapisan_pembawa_air" placeholder="Lapisan Pembawa Air"></textarea>
                <textarea class="popup-input" id="updateGeolistrikPotensi" name="potensi" placeholder="Potensi"></textarea>
                <p class="read-meta">PDF Saat Ini: <strong id="updateGeolistrikPdfCurrent">-</strong></p>
                <input type="file" class="popup-input" id="updateGeolistrikPdfFile" name="pdf_file" accept=".pdf,application/pdf">
                <span class="popup-help">Kosongkan tidak diperbolehkan karena marker peta membutuhkan koordinat.</span>
                <div class="popup-actions"><button type="submit" class="btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>

@push('scripts')
<script>
(function () {
    const toggle = document.getElementById('geoBalaiToggle');
    const menu   = document.getElementById('geoBalaiMenu');
    if (!toggle || !menu) return;

    toggle.addEventListener('click', function () {
        const open = !menu.hidden;
        menu.hidden = open;
        toggle.setAttribute('aria-expanded', String(!open));
        toggle.classList.toggle('is-open', !open);
    });

    document.addEventListener('click', function (e) {
        if (!document.getElementById('geoBalaiDropdown').contains(e.target)) {
            menu.hidden = true;
            toggle.setAttribute('aria-expanded', 'false');
            toggle.classList.remove('is-open');
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !menu.hidden) {
            menu.hidden = true;
            toggle.setAttribute('aria-expanded', 'false');
            toggle.classList.remove('is-open');
            toggle.focus();
        }
    });
})();
</script>
@endpush
@endsection

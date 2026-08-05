@extends('master.admin.app')

@section('title', $typeConfig['label'])

@section('content')
    @php
        $totalCount  = array_sum($uptCounts);
        $allBalaiFlat = collect($allBalai)->flatMap(fn($g) => $g['items']);
        $balaiAktif   = $allBalaiFlat->filter(fn($b) => ($uptCounts[$b['name']] ?? 0) > 0)->count();
        $totalBalai   = $allBalaiFlat->count();
        $progressPct  = $totalBalai > 0 ? round($balaiAktif / $totalBalai * 100) : 0;

        $importOverlayId        = 'surveyImportOverlay';
        $importPreviewOverlayId = 'surveyImportPreviewOverlay';
        $createOverlayId        = 'surveyCreateOverlay';
        $readOverlayId          = 'surveyReadOverlay';
        $updateOverlayId        = 'surveyUpdateOverlay';
    @endphp

    <section class="geo-main survey-main">
        <div class="panel full-card">
            <div class="item-head">
                <div>
                    @if ($selectedUpt !== '')
                        <p class="page-kicker">{{ Str::startsWith($selectedUpt, 'Balai Besar') ? 'BBWS' : 'BWS' }}</p>
                    @endif
                    <h3>
                        <i class="fa-solid {{ $typeConfig['icon'] }}" aria-hidden="true"></i>
                        {{ $typeConfig['label'] }}{{ $selectedUpt !== '' ? ' — ' . Str::after($selectedUpt, 'Sungai ') : '' }}
                    </h3>
                    @if ($selectedUpt !== '')
                        <a href="{{ route('admin.survey.index', ['typeSlug' => $typeSlug]) }}" class="geo-clear-filter">
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
                            <a href="{{ route('admin.survey.index', ['typeSlug' => $typeSlug]) }}"
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
                                        <a href="{{ route('admin.survey.index', ['typeSlug' => $typeSlug, 'upt' => $balai['name']]) }}"
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
                    <button type="button" class="btn-upload-excel" id="openSurveyImportPopup">
                        <i class="fa-solid fa-file-excel" aria-hidden="true"></i>
                        <span>Upload Excel</span>
                    </button>
                    <button type="button" class="btn-plus" id="openSurveyCreatePopup" aria-label="Tambah {{ $typeConfig['label'] }}">+</button>
                </div>
            </div>

            @if (session('success'))<div class="flash-success">{{ session('success') }}</div>@endif
            @if (session('error'))<div class="flash-error">{{ session('error') }}</div>@endif
            @if ($errors->any())<div class="flash-error">{{ $errors->first() }}</div>@endif

            @if ($items->isEmpty())
                <div class="geo-empty-state">
                    <div class="geo-empty-icon">
                        <i class="fa-regular fa-folder-open" aria-hidden="true"></i>
                    </div>
                    <p class="geo-empty-title">Belum ada data</p>
                    @if ($selectedUpt !== '')
                        <p class="geo-empty-sub">{{ $selectedUpt }} belum memiliki data {{ $typeConfig['label'] }}.</p>
                    @else
                        <p class="geo-empty-sub">Belum ada data {{ $typeConfig['label'] }}. Mulai dengan upload file Excel.</p>
                    @endif
                    <div class="geo-empty-actions">
                        <button type="button" class="btn-upload-excel" onclick="document.getElementById('openSurveyImportPopup').click()">
                            <i class="fa-solid fa-file-excel" aria-hidden="true"></i> Upload Excel
                        </button>
                    </div>
                </div>
            @else
                <div class="table-toolbar">
                    <div class="table-toolbar-meta">
                        Menampilkan {{ $items->firstItem() }}&ndash;{{ $items->lastItem() }} dari {{ $items->total() }} data
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

                <div class="bulk-actions-bar" id="surveyBulkBar">
                    <span class="bulk-actions-count"><strong id="surveyBulkCount">0</strong> data terpilih</span>
                    <div class="bulk-actions-buttons">
                        <button type="button" class="btn-action" id="surveyBulkClear">Batal Pilih</button>
                        <button type="button" class="bulk-actions-delete-btn" id="surveyBulkDeleteBtn">
                            <i class="fa-solid fa-trash" aria-hidden="true"></i> Hapus Terpilih
                        </button>
                    </div>
                </div>
                <form method="POST" id="surveyBulkDeleteForm" action="{{ route('admin.survey.bulk-destroy', ['typeSlug' => $typeSlug]) }}">
                    @csrf
                    @method('DELETE')
                </form>

                <div class="table-wrap">
                    <table class="item-table geolistrik-table">
                        <thead>
                        <tr>
                            <th class="bulk-checkbox-col"><input type="checkbox" class="js-bulk-select-all" id="surveySelectAll" aria-label="Pilih semua"></th>
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
                            <th>PDF</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($items as $item)
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
                                <td class="col-nowrap">{{ $item->tanggal_akusisi_data?->format('Y-m-d') ?? '-' }}</td>
                                <td>{{ $item->geologi ?? '-' }}</td>
                                <td>{{ $item->cekungan_air_tanah ?? '-' }}</td>
                                <td>{{ $item->hidrogeologi ?? '-' }}</td>
                                <td>{{ $item->lapisan_pembawa_air ?? '-' }}</td>
                                <td class="col-nowrap">
                                    @if ($item->pdf_path)
                                        <a class="btn-action read" href="{{ asset('storage/' . $item->pdf_path) }}" target="_blank" rel="noopener">PDF</a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="action-group">
                                        <button type="button" class="btn-action read js-survey-read-btn"
                                            data-kode="{{ $item->kode }}"
                                            data-kab-kota="{{ $item->kab_kota }}"
                                            data-kecamatan="{{ $item->kecamatan }}"
                                            data-desa-kelurahan="{{ $item->desa_kelurahan }}"
                                            data-upt="{{ $item->upt }}"
                                            data-latitude="{{ number_format($item->latitude, 7, '.', '') }}"
                                            data-longitude="{{ number_format($item->longitude, 7, '.', '') }}"
                                            data-elevasi="{{ $item->elevasi }}"
                                            data-tanggal-akusisi-data="{{ $item->tanggal_akusisi_data?->format('Y-m-d') }}"
                                            data-geologi="{{ $item->geologi }}"
                                            data-cekungan-air-tanah="{{ $item->cekungan_air_tanah }}"
                                            data-hidrogeologi="{{ $item->hidrogeologi }}"
                                            data-lapisan-pembawa-air="{{ $item->lapisan_pembawa_air }}"
                                            data-pdf-url="{{ $item->pdf_path ? asset('storage/' . $item->pdf_path) : '' }}"
                                            data-pdf-name="{{ $item->pdf_path ? basename($item->pdf_path) : '' }}"
                                        >Read</button>
                                        <button type="button" class="btn-action update js-survey-update-btn"
                                            data-update-url="{{ route('admin.survey.update', ['typeSlug' => $typeSlug, 'surveyData' => $item->id]) }}"
                                            data-kode="{{ $item->kode }}"
                                            data-kab-kota="{{ $item->kab_kota }}"
                                            data-kecamatan="{{ $item->kecamatan }}"
                                            data-desa-kelurahan="{{ $item->desa_kelurahan }}"
                                            data-upt="{{ $item->upt }}"
                                            data-latitude="{{ number_format($item->latitude, 7, '.', '') }}"
                                            data-longitude="{{ number_format($item->longitude, 7, '.', '') }}"
                                            data-elevasi="{{ $item->elevasi }}"
                                            data-tanggal-akusisi-data="{{ $item->tanggal_akusisi_data?->format('Y-m-d') }}"
                                            data-geologi="{{ $item->geologi }}"
                                            data-cekungan-air-tanah="{{ $item->cekungan_air_tanah }}"
                                            data-hidrogeologi="{{ $item->hidrogeologi }}"
                                            data-lapisan-pembawa-air="{{ $item->lapisan_pembawa_air }}"
                                            data-pdf-url="{{ $item->pdf_path ? asset('storage/' . $item->pdf_path) : '' }}"
                                            data-pdf-name="{{ $item->pdf_path ? basename($item->pdf_path) : '' }}"
                                        >Update</button>
                                        <form method="POST" action="{{ route('admin.survey.destroy', ['typeSlug' => $typeSlug, 'surveyData' => $item->id]) }}" class="js-survey-delete-form">
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

                @if ($items->hasPages())
                    <div class="pagination-wrap">
                        <nav class="admin-pagination" aria-label="Pagination {{ $typeConfig['label'] }}">
                            @if ($items->onFirstPage())
                                <span class="page-link disabled">&laquo; Previous</span>
                            @else
                                <a class="page-link" href="{{ $items->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                            @endif
                            @php
                                $currentPage  = $items->currentPage();
                                $lastPage     = $items->lastPage();
                                $pages        = collect([1, $lastPage])->merge(range(max(1, $currentPage - 2), min($lastPage, $currentPage + 2)))->unique()->sort()->values();
                                $previousPage = 0;
                            @endphp
                            @foreach ($pages as $page)
                                @if ($previousPage && $page > $previousPage + 1)<span class="page-link dots">...</span>@endif
                                @if ($page === $currentPage)
                                    <span class="page-link active" aria-current="page">{{ $page }}</span>
                                @else
                                    <a class="page-link" href="{{ $items->url($page) }}">{{ $page }}</a>
                                @endif
                                @php($previousPage = $page)
                            @endforeach
                            @if ($items->hasMorePages())
                                <a class="page-link" href="{{ $items->nextPageUrl() }}" rel="next">Next &raquo;</a>
                            @else
                                <span class="page-link disabled">Next &raquo;</span>
                            @endif
                        </nav>
                    </div>
                @endif
            @endif
        </div>
    </section>

    {{-- Import Upload Popup --}}
    <div class="popup-overlay" id="{{ $importOverlayId }}" aria-hidden="true">
        <div class="popup-card">
            <h4>Upload Excel {{ $typeConfig['label'] }}</h4>
            <form method="POST" action="{{ route('admin.survey.import-preview', ['typeSlug' => $typeSlug]) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="selected_upt" value="{{ $selectedUpt }}">
                <input type="file" class="popup-input" name="excel_file" accept=".xlsx,.csv" required>
                @if ($selectedUpt !== '')
                    <span class="popup-help popup-help-info">
                        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                        Baris tanpa kolom UPT akan otomatis diisi: <strong>{{ $selectedUpt }}</strong>
                    </span>
                @endif
                <span class="popup-help">Gunakan header: KODE, KAB/KOTA, KECAMATAN, DESA/KELURAHAN, UPT, LATITUDE, LONGITUDE, ELEVASI, TANGGAL AKUSISI DATA, GEOLOGI, CEKUNGAN AIR TANAH, HIDROGEOLOGI, LAPISAN PEMBAWA AIR, PDF.</span>
                <div class="popup-actions">
                    <button type="button" class="btn-action" data-close-overlay="{{ $importOverlayId }}">Batal</button>
                    <button type="submit" class="btn-primary">Preview</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Import Preview Popup --}}
    @if (count($importPreviewRows))
        <div class="popup-overlay" id="{{ $importPreviewOverlayId }}" aria-hidden="true">
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

                <form method="POST" action="{{ route('admin.survey.import-store', ['typeSlug' => $typeSlug]) }}">
                    @csrf
                    <div class="popup-actions has-gap">
                        <button type="button" class="btn-action" data-close-overlay="{{ $importPreviewOverlayId }}">Batal</button>
                        <button type="submit" class="btn-primary" @disabled($importPreviewErrorCount > 0)>Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Create Popup --}}
    <div class="popup-overlay" id="{{ $createOverlayId }}" aria-hidden="true">
        <div class="popup-card">
            <h4>Tambah {{ $typeConfig['label'] }}</h4>
            <form method="POST" action="{{ route('admin.survey.store', ['typeSlug' => $typeSlug]) }}" enctype="multipart/form-data">
                @csrf
                <input type="text" class="popup-input" name="kode" value="{{ old('kode') }}" placeholder="Kode" required>
                <input type="text" class="popup-input" name="kab_kota" value="{{ old('kab_kota') }}" placeholder="Kab/Kota">
                <input type="text" class="popup-input" name="kecamatan" value="{{ old('kecamatan') }}" placeholder="Kecamatan">
                <input type="text" class="popup-input" name="desa_kelurahan" value="{{ old('desa_kelurahan') }}" placeholder="Desa/Kelurahan">
                <input type="text" class="popup-input" name="upt" value="{{ old('upt') }}" placeholder="UPT">
                <input type="number" class="popup-input" name="latitude" value="{{ old('latitude') }}" placeholder="Latitude, contoh: -6.2088000" min="-11.2" max="6.2" step="0.0000001" required>
                <input type="number" class="popup-input" name="longitude" value="{{ old('longitude') }}" placeholder="Longitude, contoh: 106.8456000" min="94.6" max="141.1" step="0.0000001" required>
                <input type="text" class="popup-input" name="elevasi" value="{{ old('elevasi') }}" placeholder="Elevasi">
                <input type="date" class="popup-input" name="tanggal_akusisi_data" value="{{ old('tanggal_akusisi_data') }}">
                <textarea class="popup-input" name="geologi" placeholder="Geologi">{{ old('geologi') }}</textarea>
                <input type="text" class="popup-input" name="cekungan_air_tanah" value="{{ old('cekungan_air_tanah') }}" placeholder="Cekungan Air Tanah">
                <textarea class="popup-input" name="hidrogeologi" placeholder="Hidrogeologi">{{ old('hidrogeologi') }}</textarea>
                <textarea class="popup-input" name="lapisan_pembawa_air" placeholder="Lapisan Pembawa Air">{{ old('lapisan_pembawa_air') }}</textarea>
                <input type="file" class="popup-input" name="pdf_file" accept=".pdf,application/pdf">
                <span class="popup-help">Koordinat dibatasi dalam wilayah Indonesia.</span>
                <div class="popup-actions">
                    <button type="button" class="btn-action" data-close-overlay="{{ $createOverlayId }}">Batal</button>
                    <button type="submit" class="btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Read Popup --}}
    <div class="popup-overlay" id="{{ $readOverlayId }}" aria-hidden="true">
        <div class="popup-card">
            <h4>Detail {{ $typeConfig['label'] }}</h4>
            <p class="read-meta">Kode: <strong id="readSurveyKode">-</strong></p>
            <p class="read-meta">Kab/Kota: <strong id="readSurveyKabKota">-</strong></p>
            <p class="read-meta">Kecamatan: <strong id="readSurveyKecamatan">-</strong></p>
            <p class="read-meta">Desa/Kelurahan: <strong id="readSurveyDesaKelurahan">-</strong></p>
            <p class="read-meta">UPT: <strong id="readSurveyUpt">-</strong></p>
            <p class="read-meta">Latitude: <strong id="readSurveyLatitude">-</strong></p>
            <p class="read-meta">Longitude: <strong id="readSurveyLongitude">-</strong></p>
            <p class="read-meta">Elevasi: <strong id="readSurveyElevasi">-</strong></p>
            <p class="read-meta">Tanggal Akusisi Data: <strong id="readSurveyTanggal">-</strong></p>
            <p class="read-meta">Geologi: <strong id="readSurveyGeologi">-</strong></p>
            <p class="read-meta">Cekungan Air Tanah: <strong id="readSurveyCekungan">-</strong></p>
            <p class="read-meta">Hidrogeologi: <strong id="readSurveyHidrogeologi">-</strong></p>
            <p class="read-meta">Lapisan Pembawa Air: <strong id="readSurveyLapisan">-</strong></p>
            <p class="read-meta">PDF: <strong id="readSurveyPdf">-</strong></p>
            <div class="popup-actions">
                <button type="button" class="btn-primary" data-close-overlay="{{ $readOverlayId }}">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Update Popup --}}
    <div class="popup-overlay" id="{{ $updateOverlayId }}" aria-hidden="true">
        <div class="popup-card">
            <h4>Update {{ $typeConfig['label'] }}</h4>
            <form method="POST" id="surveyUpdateForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="text" class="popup-input" id="updateSurveyKode" name="kode" placeholder="Kode" required>
                <input type="text" class="popup-input" id="updateSurveyKabKota" name="kab_kota" placeholder="Kab/Kota">
                <input type="text" class="popup-input" id="updateSurveyKecamatan" name="kecamatan" placeholder="Kecamatan">
                <input type="text" class="popup-input" id="updateSurveyDesaKelurahan" name="desa_kelurahan" placeholder="Desa/Kelurahan">
                <input type="text" class="popup-input" id="updateSurveyUpt" name="upt" placeholder="UPT">
                <input type="number" class="popup-input" id="updateSurveyLatitude" name="latitude" placeholder="Latitude" min="-11.2" max="6.2" step="0.0000001" required>
                <input type="number" class="popup-input" id="updateSurveyLongitude" name="longitude" placeholder="Longitude" min="94.6" max="141.1" step="0.0000001" required>
                <input type="text" class="popup-input" id="updateSurveyElevasi" name="elevasi" placeholder="Elevasi">
                <input type="date" class="popup-input" id="updateSurveyTanggal" name="tanggal_akusisi_data">
                <textarea class="popup-input" id="updateSurveyGeologi" name="geologi" placeholder="Geologi"></textarea>
                <input type="text" class="popup-input" id="updateSurveyCekungan" name="cekungan_air_tanah" placeholder="Cekungan Air Tanah">
                <textarea class="popup-input" id="updateSurveyHidrogeologi" name="hidrogeologi" placeholder="Hidrogeologi"></textarea>
                <textarea class="popup-input" id="updateSurveyLapisan" name="lapisan_pembawa_air" placeholder="Lapisan Pembawa Air"></textarea>
                <p class="read-meta">PDF Saat Ini: <strong id="updateSurveyPdfCurrent">-</strong></p>
                <input type="file" class="popup-input" id="updateSurveyPdfFile" name="pdf_file" accept=".pdf,application/pdf">
                <span class="popup-help">Kosongkan tidak diperbolehkan karena data membutuhkan koordinat.</span>
                <div class="popup-actions">
                    <button type="button" class="btn-action" data-close-overlay="{{ $updateOverlayId }}">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script>
(function () {
    // Wilayah dropdown
    const toggle = document.getElementById('geoBalaiToggle');
    const menu   = document.getElementById('geoBalaiMenu');
    if (toggle && menu) {
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
    }

    // Open create popup
    const openCreateBtn = document.getElementById('openSurveyCreatePopup');
    if (openCreateBtn) {
        openCreateBtn.addEventListener('click', function () {
            document.getElementById('{{ $createOverlayId }}').removeAttribute('aria-hidden');
        });
    }

    // Open import popup
    const openImportBtn = document.getElementById('openSurveyImportPopup');
    if (openImportBtn) {
        openImportBtn.addEventListener('click', function () {
            document.getElementById('{{ $importOverlayId }}').removeAttribute('aria-hidden');
        });
    }

    @if (count($importPreviewRows))
    // Auto-open import preview if data present
    (function () {
        const overlay = document.getElementById('{{ $importPreviewOverlayId }}');
        if (overlay) overlay.removeAttribute('aria-hidden');
    })();
    @endif

    // Read buttons
    document.querySelectorAll('.js-survey-read-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('readSurveyKode').textContent          = btn.dataset.kode || '-';
            document.getElementById('readSurveyKabKota').textContent       = btn.dataset.kabKota || '-';
            document.getElementById('readSurveyKecamatan').textContent     = btn.dataset.kecamatan || '-';
            document.getElementById('readSurveyDesaKelurahan').textContent = btn.dataset.desaKelurahan || '-';
            document.getElementById('readSurveyUpt').textContent           = btn.dataset.upt || '-';
            document.getElementById('readSurveyLatitude').textContent      = btn.dataset.latitude || '-';
            document.getElementById('readSurveyLongitude').textContent     = btn.dataset.longitude || '-';
            document.getElementById('readSurveyElevasi').textContent       = btn.dataset.elevasi || '-';
            document.getElementById('readSurveyTanggal').textContent       = btn.dataset.tanggalAkusisiData || '-';
            document.getElementById('readSurveyGeologi').textContent       = btn.dataset.geologi || '-';
            document.getElementById('readSurveyCekungan').textContent      = btn.dataset.cekunganAirTanah || '-';
            document.getElementById('readSurveyHidrogeologi').textContent  = btn.dataset.hidrogeologi || '-';
            document.getElementById('readSurveyLapisan').textContent       = btn.dataset.lapisanPembawaAir || '-';
            const pdfEl = document.getElementById('readSurveyPdf');
            if (btn.dataset.pdfUrl) {
                pdfEl.innerHTML = '<a href="' + btn.dataset.pdfUrl + '" target="_blank" rel="noopener">' + (btn.dataset.pdfName || 'Lihat PDF') + '</a>';
            } else {
                pdfEl.textContent = '-';
            }
            document.getElementById('{{ $readOverlayId }}').removeAttribute('aria-hidden');
        });
    });

    // Update buttons
    document.querySelectorAll('.js-survey-update-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const form = document.getElementById('surveyUpdateForm');
            form.action = btn.dataset.updateUrl;
            document.getElementById('updateSurveyKode').value          = btn.dataset.kode || '';
            document.getElementById('updateSurveyKabKota').value       = btn.dataset.kabKota || '';
            document.getElementById('updateSurveyKecamatan').value     = btn.dataset.kecamatan || '';
            document.getElementById('updateSurveyDesaKelurahan').value = btn.dataset.desaKelurahan || '';
            document.getElementById('updateSurveyUpt').value           = btn.dataset.upt || '';
            document.getElementById('updateSurveyLatitude').value      = btn.dataset.latitude || '';
            document.getElementById('updateSurveyLongitude').value     = btn.dataset.longitude || '';
            document.getElementById('updateSurveyElevasi').value       = btn.dataset.elevasi || '';
            document.getElementById('updateSurveyTanggal').value       = btn.dataset.tanggalAkusisiData || '';
            document.getElementById('updateSurveyGeologi').value       = btn.dataset.geologi || '';
            document.getElementById('updateSurveyCekungan').value      = btn.dataset.cekunganAirTanah || '';
            document.getElementById('updateSurveyHidrogeologi').value  = btn.dataset.hidrogeologi || '';
            document.getElementById('updateSurveyLapisan').value       = btn.dataset.lapisanPembawaAir || '';
            document.getElementById('updateSurveyPdfCurrent').textContent = btn.dataset.pdfName || '-';
            document.getElementById('updateSurveyPdfFile').value = '';
            document.getElementById('{{ $updateOverlayId }}').removeAttribute('aria-hidden');
        });
    });

    // Delete confirmation
    document.querySelectorAll('.js-survey-delete-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!confirm('Hapus data ini?')) e.preventDefault();
        });
    });

    // Bulk select + bulk delete
    (function () {
        const selectAll = document.getElementById('surveySelectAll');
        const bar = document.getElementById('surveyBulkBar');
        const countEl = document.getElementById('surveyBulkCount');
        const clearBtn = document.getElementById('surveyBulkClear');
        const deleteBtn = document.getElementById('surveyBulkDeleteBtn');
        const bulkForm = document.getElementById('surveyBulkDeleteForm');

        if (!selectAll || !bar || !bulkForm) return;

        function checkboxes() {
            return Array.from(document.querySelectorAll('.js-bulk-checkbox'));
        }

        function updateBar() {
            const all = checkboxes();
            const checked = all.filter(function (cb) { return cb.checked; });

            if (countEl) countEl.textContent = String(checked.length);
            bar.classList.toggle('is-visible', checked.length > 0);

            selectAll.checked = all.length > 0 && checked.length === all.length;
            selectAll.indeterminate = checked.length > 0 && checked.length < all.length;
        }

        selectAll.addEventListener('change', function () {
            checkboxes().forEach(function (cb) { cb.checked = selectAll.checked; });
            updateBar();
        });

        checkboxes().forEach(function (cb) {
            cb.addEventListener('change', updateBar);
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                checkboxes().forEach(function (cb) { cb.checked = false; });
                updateBar();
            });
        }

        if (deleteBtn) {
            deleteBtn.addEventListener('click', function () {
                const ids = checkboxes().filter(function (cb) { return cb.checked; }).map(function (cb) { return cb.value; });
                if (!ids.length) return;
                if (!window.confirm('Hapus ' + ids.length + ' data {{ $typeConfig['label'] }} terpilih? Tindakan ini tidak bisa dibatalkan.')) return;

                bulkForm.querySelectorAll('input[name="ids[]"]').forEach(function (el) { el.remove(); });
                ids.forEach(function (id) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = id;
                    bulkForm.appendChild(input);
                });
                bulkForm.submit();
            });
        }

        updateBar();
    })();
})();
</script>
@endpush
@endsection

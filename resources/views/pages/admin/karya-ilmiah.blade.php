@extends('master.admin.app')

@section('title', 'Admin Karya Ilmiah')

@section('content')
    <style>
        .karya-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
        }

        .karya-head h3 {
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

        .flash-success {
            margin: 12px 0 0;
            border: 1px solid #b8e2c3;
            background: #eaf9ee;
            color: #1f6b35;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
        }

        .flash-error {
            margin: 12px 0 0;
            border: 1px solid #f3c2c2;
            background: #fff0f0;
            color: #9c2f2f;
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
        }

        .karya-table {
            width: 100%;
            table-layout: fixed;
        }

        .karya-table th,
        .karya-table td {
            white-space: normal;
            word-break: break-word;
            vertical-align: top;
        }

        .karya-table th:nth-child(1),
        .karya-table td:nth-child(1) {
            width: 17%;
        }

        .karya-table th:nth-child(2),
        .karya-table td:nth-child(2) {
            width: 22%;
        }

        .karya-table th:nth-child(3),
        .karya-table td:nth-child(3) {
            width: 29%;
        }

        .karya-table th:nth-child(4),
        .karya-table td:nth-child(4) {
            width: 15%;
        }

        .karya-table th:nth-child(5),
        .karya-table td:nth-child(5) {
            width: 17%;
        }

        .thumb-box {
            width: min(100%, 160px);
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            background: #f7f7f7;
        }

        .thumb-box img {
            width: 100%;
            aspect-ratio: 16 / 10;
            object-fit: cover;
            display: block;
        }

        .thumb-preview {
            width: 100%;
            border: 1px solid #e4e4e4;
            border-radius: 10px;
            overflow: hidden;
            background: #f8f8f8;
            margin-bottom: 12px;
        }

        .thumb-preview img {
            width: 100%;
            max-height: 220px;
            object-fit: contain;
            display: block;
            background: #0f1b30;
        }

        .read-thumb {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
            background: #f7f7f7;
            margin-bottom: 12px;
        }

        .read-thumb img {
            width: 100%;
            max-height: 280px;
            object-fit: contain;
            display: block;
            background: #0f1b30;
        }

        .pdf-link {
            font-weight: 700;
            color: #1e4b95;
            text-decoration: none;
        }

        .action-group {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            white-space: nowrap;
        }

        .btn-action {
            border: 1px solid #d2d2d2;
            background: #fff;
            color: #1a1a1a;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-action.read {
            border-color: #b9d2ff;
            background: #ecf3ff;
            color: #1e4b95;
        }

        .btn-action.update {
            border-color: #cde8cd;
            background: #ecf8ec;
            color: #1f6b35;
        }

        .btn-action.delete {
            border-color: #f2c6c6;
            background: #fff1f1;
            color: #a72c2c;
        }

        .popup-overlay {
            position: fixed;
            inset: 0;
            background: rgba(10, 12, 18, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1400;
            padding: 16px;
        }

        .popup-overlay.is-open {
            display: flex;
        }

        .popup-card {
            width: min(100%, 560px);
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 20px 40px rgba(17, 18, 23, 0.18);
            max-height: 88vh;
            overflow: auto;
        }

        .popup-card h4 {
            margin: 0 0 12px;
            font-size: 20px;
            line-height: 1.2;
        }

        .popup-input {
            width: 100%;
            border: 1px solid #d4d4d4;
            border-radius: 10px;
            padding: 10px 12px;
            font: inherit;
            color: #161616;
            outline: none;
            margin-bottom: 12px;
        }

        .popup-textarea {
            width: 100%;
            min-height: 120px;
            resize: vertical;
            border: 1px solid #d4d4d4;
            border-radius: 10px;
            padding: 10px 12px;
            font: inherit;
            color: #161616;
            outline: none;
            margin-bottom: 12px;
        }

        .popup-help {
            display: block;
            margin: -4px 0 10px;
            color: #666;
            font-size: 12px;
        }

        .popup-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }

        .btn-primary {
            border: 1px solid #111217;
            background: #111217;
            color: #fff;
            border-radius: 10px;
            padding: 9px 16px;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        .read-meta {
            margin: 0 0 10px;
            font-size: 12px;
            color: #666;
        }

        .read-desc {
            margin: 0 0 12px;
            color: #222;
            line-height: 1.5;
            white-space: pre-wrap;
            word-break: break-word;
        }

        @media (max-width: 900px) {
            .karya-table th:nth-child(1),
            .karya-table td:nth-child(1),
            .karya-table th:nth-child(4),
            .karya-table td:nth-child(4) {
                width: auto;
            }
        }
    </style>

    <section>
        <div class="panel full-card">
            <div class="karya-head">
                <h3>Karya Ilmiah</h3>
                <button type="button" class="btn-plus" id="openKaryaPopup" aria-label="Tambah karya ilmiah">+</button>
            </div>

            @if (session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="flash-error">{{ $errors->first() }}</div>
            @endif

            <div class="table-wrap">
                <table class="karya-table">
                    <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Upload PDF</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($karyaIlmiahs as $karya)
                        @php
                            $thumbnailUrl = $karya->thumbnail_path ? asset('storage/' . $karya->thumbnail_path) : '';
                            $pdfUrl = asset('storage/' . $karya->pdf_path);
                            $pdfName = basename($karya->pdf_path);
                        @endphp
                        <tr>
                            <td>
                                @if ($thumbnailUrl)
                                    <div class="thumb-box">
                                        <img src="{{ $thumbnailUrl }}" alt="Thumbnail {{ $karya->judul }}">
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $karya->judul }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($karya->deskripsi, 120) }}</td>
                            <td>
                                <a class="pdf-link" href="{{ $pdfUrl }}" target="_blank" rel="noopener">{{ $pdfName }}</a>
                            </td>
                            <td>
                                <div class="action-group">
                                    <button
                                        type="button"
                                        class="btn-action read js-read-btn"
                                        data-judul="{{ $karya->judul }}"
                                        data-deskripsi="{{ $karya->deskripsi }}"
                                        data-thumbnail-url="{{ $thumbnailUrl }}"
                                        data-pdf-url="{{ $pdfUrl }}"
                                        data-pdf-name="{{ $pdfName }}"
                                    >Read</button>
                                    <button
                                        type="button"
                                        class="btn-action update js-update-btn"
                                        data-update-url="{{ route('admin.karya-ilmiah.update', $karya->id) }}"
                                        data-judul="{{ $karya->judul }}"
                                        data-deskripsi="{{ $karya->deskripsi }}"
                                        data-thumbnail-url="{{ $thumbnailUrl }}"
                                        data-pdf-url="{{ $pdfUrl }}"
                                        data-pdf-name="{{ $pdfName }}"
                                    >Update</button>
                                    <form method="POST" action="{{ route('admin.karya-ilmiah.destroy', $karya->id) }}" class="js-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data karya ilmiah.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="popup-overlay" id="createKaryaOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="createKaryaTitle">
            <h4 id="createKaryaTitle">Tambah Karya Ilmiah</h4>
            <form method="POST" action="{{ route('admin.karya-ilmiah.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <input type="text" class="popup-input" id="createKaryaJudul" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul" required>
                <textarea class="popup-textarea" name="deskripsi" placeholder="Masukkan deskripsi" required>{{ old('deskripsi') }}</textarea>
                <input type="file" class="popup-input" name="thumbnail" accept=".jpg,.jpeg,.png,.webp,image/*" required>
                <span class="popup-help">Thumbnail: JPG/JPEG/PNG/WEBP (maks 5MB).</span>
                <input type="file" class="popup-input" name="pdf" accept=".pdf,application/pdf" required>
                <span class="popup-help">Format file: PDF (maks 10MB).</span>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="readKaryaOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="readKaryaTitle">
            <h4 id="readKaryaTitle">Detail Karya Ilmiah</h4>
            <div class="read-thumb" id="readKaryaThumb"></div>
            <p class="read-desc" id="readKaryaDesc"></p>
            <p class="read-meta">
                PDF: <a class="pdf-link" id="readKaryaPdf" href="#" target="_blank" rel="noopener">-</a>
            </p>
            <div class="popup-actions">
                <button type="button" class="btn-primary" data-close-overlay="readKaryaOverlay">Tutup</button>
            </div>
        </div>
    </div>

    <div class="popup-overlay" id="updateKaryaOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="updateKaryaTitle">
            <h4 id="updateKaryaTitle">Update Karya Ilmiah</h4>
            <form method="POST" id="updateKaryaForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="update">
                <input type="text" class="popup-input" id="updateKaryaJudul" name="judul" placeholder="Masukkan judul" required>
                <textarea class="popup-textarea" id="updateKaryaDeskripsi" name="deskripsi" placeholder="Masukkan deskripsi" required></textarea>
                <p class="read-meta">Thumbnail saat ini:</p>
                <div class="thumb-preview" id="updateKaryaCurrentThumb"></div>
                <input type="file" class="popup-input" name="thumbnail" accept=".jpg,.jpeg,.png,.webp,image/*">
                <span class="popup-help">Kosongkan jika tidak ingin mengganti thumbnail.</span>
                <p class="read-meta">
                    PDF saat ini: <a class="pdf-link" id="updateKaryaCurrentPdf" href="#" target="_blank" rel="noopener">-</a>
                </p>
                <input type="file" class="popup-input" name="pdf" accept=".pdf,application/pdf">
                <span class="popup-help">Kosongkan jika tidak ingin mengganti PDF.</span>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const openButton = document.getElementById('openKaryaPopup');
            const createOverlay = document.getElementById('createKaryaOverlay');
            const createJudul = document.getElementById('createKaryaJudul');
            const readOverlay = document.getElementById('readKaryaOverlay');
            const readTitle = document.getElementById('readKaryaTitle');
            const readThumb = document.getElementById('readKaryaThumb');
            const readDesc = document.getElementById('readKaryaDesc');
            const readPdf = document.getElementById('readKaryaPdf');
            const updateOverlay = document.getElementById('updateKaryaOverlay');
            const updateForm = document.getElementById('updateKaryaForm');
            const updateJudul = document.getElementById('updateKaryaJudul');
            const updateDesc = document.getElementById('updateKaryaDeskripsi');
            const updateCurrentThumb = document.getElementById('updateKaryaCurrentThumb');
            const updateCurrentPdf = document.getElementById('updateKaryaCurrentPdf');

            if (!openButton || !createOverlay) return;

            function openOverlay(overlay, focusTarget) {
                if (!overlay) return;
                overlay.classList.add('is-open');
                overlay.setAttribute('aria-hidden', 'false');
                if (focusTarget) {
                    window.setTimeout(function () {
                        focusTarget.focus();
                    }, 0);
                }
            }

            function closeOverlay(overlay) {
                if (!overlay) return;
                overlay.classList.remove('is-open');
                overlay.setAttribute('aria-hidden', 'true');
            }

            function closeAllOverlays() {
                document.querySelectorAll('.popup-overlay.is-open').forEach(function (overlay) {
                    closeOverlay(overlay);
                });
            }

            openButton.addEventListener('click', function () {
                openOverlay(createOverlay, createJudul);
            });

            document.querySelectorAll('.js-read-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    readTitle.textContent = button.dataset.judul || 'Detail Karya Ilmiah';
                    readThumb.innerHTML = button.dataset.thumbnailUrl
                        ? '<img src="' + button.dataset.thumbnailUrl + '" alt="Thumbnail karya ilmiah">'
                        : '<p class="read-meta" style="margin:8px 10px;">Thumbnail belum tersedia.</p>';
                    readDesc.textContent = button.dataset.deskripsi || '-';
                    readPdf.textContent = button.dataset.pdfName || '-';
                    readPdf.href = button.dataset.pdfUrl || '#';
                    openOverlay(readOverlay);
                });
            });

            document.querySelectorAll('.js-update-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    updateForm.action = button.dataset.updateUrl || '';
                    updateJudul.value = button.dataset.judul || '';
                    updateDesc.value = button.dataset.deskripsi || '';
                    updateCurrentThumb.innerHTML = button.dataset.thumbnailUrl
                        ? '<img src="' + button.dataset.thumbnailUrl + '" alt="Thumbnail saat ini">'
                        : '<p class="read-meta" style="margin:8px 10px;">Thumbnail belum tersedia.</p>';
                    updateCurrentPdf.textContent = button.dataset.pdfName || '-';
                    updateCurrentPdf.href = button.dataset.pdfUrl || '#';
                    openOverlay(updateOverlay, updateJudul);
                });
            });

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus karya ilmiah ini?')) {
                        event.preventDefault();
                    }
                });
            });

            document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) {
                        closeOverlay(overlay);
                    }
                });
            });

            document.querySelectorAll('[data-close-overlay]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const overlayId = button.getAttribute('data-close-overlay');
                    if (!overlayId) return;
                    closeOverlay(document.getElementById(overlayId));
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeAllOverlays();
                }
            });

            @if ($errors->any() && old('form_type') === 'create')
                openOverlay(createOverlay, createJudul);
            @endif
        })();
    </script>
@endsection

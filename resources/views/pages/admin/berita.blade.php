@extends('master.admin.app')

@section('title', 'Admin Berita')

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
            width: min(100%, 420px);
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 20px 40px rgba(17, 18, 23, 0.18);
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

        .popup-input:focus {
            border-color: #111217;
            box-shadow: 0 0 0 3px rgba(17, 18, 23, 0.1);
        }

        .popup-actions {
            display: flex;
            justify-content: flex-end;
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

        .popup-help {
            display: block;
            margin: -4px 0 10px;
            color: #666;
            font-size: 12px;
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

        .popup-textarea:focus {
            border-color: #111217;
            box-shadow: 0 0 0 3px rgba(17, 18, 23, 0.1);
        }

        .btn-tambah {
            border: 1px solid #111217;
            background: #111217;
            color: #fff;
            border-radius: 10px;
            padding: 9px 16px;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        .action-group {
            display: flex;
            gap: 6px;
            white-space: nowrap;
            flex-wrap: wrap;
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

        .read-meta {
            margin: 0 0 10px;
            font-size: 12px;
            color: #666;
        }

        .read-desc {
            margin: 0;
            color: #222;
            line-height: 1.5;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .read-images {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-top: 12px;
        }

        .read-images img {
            width: 100%;
            aspect-ratio: 16 / 10;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e4e4e4;
        }

        .existing-image-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin: 0 0 12px;
        }

        .existing-image-item {
            border: 1px solid #e4e4e4;
            border-radius: 10px;
            padding: 8px;
        }

        .existing-image-item img {
            width: 100%;
            aspect-ratio: 16 / 10;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .existing-image-item label {
            font-size: 12px;
            color: #4a4a4a;
        }

        .image-input-list {
            display: grid;
            gap: 8px;
            margin-bottom: 8px;
        }

        .image-input-row {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .image-input-row .popup-input {
            margin-bottom: 0;
        }

        .btn-remove-image-input {
            border: 1px solid #f2c6c6;
            background: #fff1f1;
            color: #a72c2c;
            border-radius: 10px;
            padding: 8px 10px;
            font: inherit;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-remove-image-input:disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        .btn-add-image-input {
            border: 1px solid #b9d2ff;
            background: #ecf3ff;
            color: #1e4b95;
            border-radius: 10px;
            padding: 8px 12px;
            font: inherit;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .upload-preview-list {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
            margin: 0 0 10px;
        }

        .upload-preview-item {
            border: 1px solid #e4e4e4;
            border-radius: 10px;
            overflow: hidden;
            background: #f8f8f8;
        }

        .upload-preview-item img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            display: block;
        }

        .berita-table-wrap {
            overflow-x: hidden;
        }

        .berita-table {
            width: 100%;
            min-width: 0;
            table-layout: fixed;
        }

        .berita-table th,
        .berita-table td {
            white-space: normal;
            word-break: break-word;
            vertical-align: top;
        }

        .berita-table th:nth-child(1),
        .berita-table td:nth-child(1) {
            width: 22%;
        }

        .berita-table th:nth-child(2),
        .berita-table td:nth-child(2) {
            width: 34%;
        }

        .berita-table th:nth-child(3),
        .berita-table td:nth-child(3) {
            width: 14%;
        }

        .berita-table th:nth-child(4),
        .berita-table td:nth-child(4) {
            width: 10%;
        }

        .berita-table th:nth-child(5),
        .berita-table td:nth-child(5) {
            width: 20%;
        }

        @media (max-width: 620px) {
            .btn-plus {
                width: 42px;
                height: 42px;
                border-radius: 14px;
                flex-shrink: 0;
            }

            .upload-preview-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .berita-table th:nth-child(3),
            .berita-table td:nth-child(3),
            .berita-table th:nth-child(4),
            .berita-table td:nth-child(4) {
                width: auto;
            }
        }
    </style>

    <section>
        <div class="panel full-card">
            <div class="berita-head">
                <h3>Berita</h3>
                <button type="button" class="btn-plus" id="openBeritaPopup" aria-label="Tambah berita">+</button>
            </div>
            @if (session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="flash-error">{{ $errors->first() }}</div>
            @endif

            <div class="table-wrap berita-table-wrap">
                <table class="berita-table">
                    <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Dibuat</th>
                        <th>Jumlah Gambar</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($beritas as $berita)
                        @php
                            $imagePayload = $berita->images
                                ->map(function ($image) {
                                    return [
                                        'id' => $image->id,
                                        'url' => asset('storage/' . $image->image_path),
                                    ];
                                })
                                ->values()
                                ->toJson();
                        @endphp
                        <tr>
                            <td>{{ $berita->judul }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($berita->deskripsi, 90) }}</td>
                            <td>{{ $berita->created_at ? $berita->created_at->format('d M, Y H:i') : '-' }}</td>
                            <td>{{ $berita->images->count() }}</td>
                            <td>
                                <div class="action-group">
                                    <button
                                        type="button"
                                        class="btn-action read js-read-btn"
                                        data-judul="{{ $berita->judul }}"
                                        data-deskripsi="{{ $berita->deskripsi }}"
                                        data-created="{{ $berita->created_at ? $berita->created_at->format('d M, Y H:i') : '-' }}"
                                        data-images="{{ e($imagePayload) }}"
                                    >
                                        Read
                                    </button>
                                    <button
                                        type="button"
                                        class="btn-action update js-update-btn"
                                        data-id="{{ $berita->id }}"
                                        data-judul="{{ $berita->judul }}"
                                        data-deskripsi="{{ $berita->deskripsi }}"
                                        data-update-url="{{ route('admin.berita.update', $berita->id) }}"
                                        data-images="{{ e($imagePayload) }}"
                                    >
                                        Update
                                    </button>
                                    <form method="POST" action="{{ route('admin.berita.destroy', $berita->id) }}" class="js-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data berita.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="popup-overlay" id="beritaPopupOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="beritaPopupTitle">
            <h4 id="beritaPopupTitle">Tambah Berita</h4>
            <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <input type="text" class="popup-input" id="beritaPopupInput" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul berita" required>
                <textarea class="popup-textarea" name="deskripsi" placeholder="Masukkan deskripsi berita" required>{{ old('deskripsi') }}</textarea>
                <div class="image-input-list" id="createImageInputList"></div>
                <button type="button" class="btn-add-image-input" id="addCreateImageInput">+ Tambah Input Gambar</button>
                <div class="upload-preview-list" id="createUploadPreviewList"></div>
                <span class="popup-help">Upload 1 gambar per input. Tambah input jika gambar lebih dari 1.</span>
                <div class="popup-actions">
                    <button type="submit" class="btn-tambah">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="readBeritaOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="readBeritaTitle">
            <h4 id="readBeritaTitle">Detail Berita</h4>
            <p class="read-meta" id="readBeritaCreated">-</p>
            <p class="read-desc" id="readBeritaDescription"></p>
            <div class="read-images" id="readBeritaImages"></div>
            <div class="popup-actions" style="margin-top: 12px;">
                <button type="button" class="btn-tambah" data-close-overlay="readBeritaOverlay">Tutup</button>
            </div>
        </div>
    </div>

    <div class="popup-overlay" id="updateBeritaOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="updateBeritaTitle">
            <h4 id="updateBeritaTitle">Update Berita</h4>
            <form method="POST" id="updateBeritaForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="update">
                <input type="hidden" name="berita_id" id="updateBeritaId">
                <input type="text" class="popup-input" id="updateBeritaJudul" name="judul" placeholder="Masukkan judul berita" required>
                <textarea class="popup-textarea" id="updateBeritaDeskripsi" name="deskripsi" placeholder="Masukkan deskripsi berita" required></textarea>
                <div id="existingImageList" class="existing-image-list"></div>
                <div class="image-input-list" id="updateImageInputList"></div>
                <button type="button" class="btn-add-image-input" id="addUpdateImageInput">+ Tambah Input Gambar</button>
                <div class="upload-preview-list" id="updateUploadPreviewList"></div>
                <span class="popup-help">Upload 1 gambar per input untuk menambah gambar baru.</span>
                <div class="popup-actions">
                    <button type="submit" class="btn-tambah">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const createOpenButton = document.getElementById('openBeritaPopup');
            const createOverlay = document.getElementById('beritaPopupOverlay');
            const createInput = document.getElementById('beritaPopupInput');
            const readOverlay = document.getElementById('readBeritaOverlay');
            const updateOverlay = document.getElementById('updateBeritaOverlay');
            const readTitle = document.getElementById('readBeritaTitle');
            const readCreated = document.getElementById('readBeritaCreated');
            const readDescription = document.getElementById('readBeritaDescription');
            const readImages = document.getElementById('readBeritaImages');
            const updateForm = document.getElementById('updateBeritaForm');
            const updateId = document.getElementById('updateBeritaId');
            const updateJudul = document.getElementById('updateBeritaJudul');
            const updateDeskripsi = document.getElementById('updateBeritaDeskripsi');
            const existingImageList = document.getElementById('existingImageList');

            if (!createOpenButton || !createOverlay || !createInput) return;

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

            function parseImages(raw) {
                if (!raw) return [];
                try {
                    const parsed = JSON.parse(raw);
                    return Array.isArray(parsed) ? parsed : [];
                } catch (error) {
                    return [];
                }
            }

            function createImagePicker(options) {
                const inputList = document.getElementById(options.inputListId);
                const addButton = document.getElementById(options.addButtonId);
                const previewList = document.getElementById(options.previewListId);
                const minOne = options.minOne === true;
                const requireFirst = options.requireFirst === true;

                if (!inputList || !addButton || !previewList) {
                    return {
                        reset: function () {}
                    };
                }

                function updateRemoveButtonState() {
                    const rows = inputList.querySelectorAll('.image-input-row');
                    rows.forEach(function (row) {
                        const removeButton = row.querySelector('.btn-remove-image-input');
                        if (!removeButton) return;
                        removeButton.disabled = minOne && rows.length <= 1;
                    });
                }

                function renderPreview() {
                    previewList.innerHTML = '';
                    const files = [];

                    inputList.querySelectorAll('input[type="file"]').forEach(function (input) {
                        if (input.files && input.files[0]) {
                            files.push(input.files[0]);
                        }
                    });

                    if (!files.length) {
                        previewList.innerHTML = '<p class="read-meta" style="grid-column:1/-1;margin:0;">Belum ada gambar dipilih.</p>';
                        return;
                    }

                    files.forEach(function (file, index) {
                        const item = document.createElement('div');
                        item.className = 'upload-preview-item';
                        const imageUrl = URL.createObjectURL(file);
                        item.innerHTML = '<img src="' + imageUrl + '" alt="Preview ' + (index + 1) + '">';
                        const img = item.querySelector('img');
                        if (img) {
                            img.addEventListener('load', function () {
                                URL.revokeObjectURL(imageUrl);
                            });
                        }
                        previewList.appendChild(item);
                    });
                }

                function addRow(isRequired) {
                    const row = document.createElement('div');
                    row.className = 'image-input-row';
                    row.innerHTML =
                        '<input type="file" class="popup-input" name="images[]" accept=".jpg,.jpeg,.png,.webp,image/*"' + (isRequired ? ' required' : '') + '>' +
                        '<button type="button" class="btn-remove-image-input">Hapus</button>';

                    const input = row.querySelector('input[type="file"]');
                    const removeButton = row.querySelector('.btn-remove-image-input');

                    if (input) {
                        input.addEventListener('change', renderPreview);
                    }

                    if (removeButton) {
                        removeButton.addEventListener('click', function () {
                            row.remove();
                            if (minOne && !inputList.querySelector('.image-input-row')) {
                                addRow(requireFirst);
                            }
                            updateRemoveButtonState();
                            renderPreview();
                        });
                    }

                    inputList.appendChild(row);
                    updateRemoveButtonState();
                    renderPreview();
                }

                addButton.addEventListener('click', function () {
                    addRow(false);
                });

                function reset() {
                    inputList.innerHTML = '';
                    addRow(requireFirst);
                }

                reset();

                return {
                    reset: reset
                };
            }

            const createImagePickerController = createImagePicker({
                inputListId: 'createImageInputList',
                addButtonId: 'addCreateImageInput',
                previewListId: 'createUploadPreviewList',
                minOne: true,
                requireFirst: true
            });

            const updateImagePickerController = createImagePicker({
                inputListId: 'updateImageInputList',
                addButtonId: 'addUpdateImageInput',
                previewListId: 'updateUploadPreviewList',
                minOne: true,
                requireFirst: false
            });

            createOpenButton.addEventListener('click', function () {
                createImagePickerController.reset();
                openOverlay(createOverlay, createInput);
            });

            document.querySelectorAll('.js-read-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const images = parseImages(button.dataset.images);
                    readTitle.textContent = button.dataset.judul || 'Detail Berita';
                    readCreated.textContent = 'Tanggal dibuat: ' + (button.dataset.created || '-');
                    readDescription.textContent = button.dataset.deskripsi || '-';

                    readImages.innerHTML = '';
                    if (!images.length) {
                        readImages.innerHTML = '<p class="read-meta" style="grid-column:1/-1;margin:0;">Tidak ada gambar.</p>';
                    } else {
                        images.forEach(function (image) {
                            const img = document.createElement('img');
                            img.src = image.url;
                            img.alt = button.dataset.judul || 'Gambar berita';
                            readImages.appendChild(img);
                        });
                    }

                    openOverlay(readOverlay);
                });
            });

            document.querySelectorAll('.js-update-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const images = parseImages(button.dataset.images);
                    updateForm.action = button.dataset.updateUrl || '';
                    updateId.value = button.dataset.id || '';
                    updateJudul.value = button.dataset.judul || '';
                    updateDeskripsi.value = button.dataset.deskripsi || '';
                    updateImagePickerController.reset();

                    existingImageList.innerHTML = '';
                    if (images.length) {
                        images.forEach(function (image, index) {
                            const item = document.createElement('div');
                            item.className = 'existing-image-item';
                            item.innerHTML =
                                '<img src="' + image.url + '" alt="Gambar ' + (index + 1) + '">' +
                                '<label><input type="checkbox" name="remove_image_ids[]" value="' + image.id + '"> Hapus gambar</label>';
                            existingImageList.appendChild(item);
                        });
                    } else {
                        existingImageList.innerHTML = '<p class="read-meta" style="grid-column:1/-1;margin:0 0 6px;">Belum ada gambar.</p>';
                    }

                    openOverlay(updateOverlay, updateJudul);
                });
            });

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus berita ini beserta semua gambarnya?')) {
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
                openOverlay(createOverlay, createInput);
            @endif
        })();
    </script>
@endsection

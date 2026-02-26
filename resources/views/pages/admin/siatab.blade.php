@extends('master.admin.app')

@section('title', 'Admin SIATAB')

@section('content')
    <style>
        .head { display:flex; align-items:center; justify-content:space-between; gap:12px; width:100%; }
        .head h3 { margin:0; font-size:clamp(34px,7vw,40px); line-height:1.15; min-width:0; flex:1; }
        .btn-plus { width:44px; height:44px; border-radius:12px; border:1px solid #d9d9d9; background:#fff; font-size:30px; line-height:1; color:#14161b; cursor:pointer; transition:background-color .2s ease,color .2s ease,border-color .2s ease; }
        .btn-plus:hover { background:#111217; color:#fff; border-color:#111217; }
        .flash-success { margin:12px 0 0; border:1px solid #b8e2c3; background:#eaf9ee; color:#1f6b35; border-radius:10px; padding:10px 12px; font-size:14px; }
        .flash-error { margin:12px 0 0; border:1px solid #f3c2c2; background:#fff0f0; color:#9c2f2f; border-radius:10px; padding:10px 12px; font-size:14px; }
        .table-item { width:100%; table-layout:fixed; }
        .table-item th:nth-child(1), .table-item td:nth-child(1) { width:45%; }
        .table-item th:nth-child(2), .table-item td:nth-child(2) { width:15%; }
        .table-item th:nth-child(3), .table-item td:nth-child(3) { width:15%; }
        .table-item th:nth-child(4), .table-item td:nth-child(4) { width:25%; }
        .action-group { display:flex; gap:6px; flex-wrap:wrap; white-space:nowrap; }
        .btn-action { border:1px solid #d2d2d2; background:#fff; color:#1a1a1a; border-radius:8px; padding:6px 10px; font-size:12px; font-weight:700; cursor:pointer; }
        .btn-action.read { border-color:#b9d2ff; background:#ecf3ff; color:#1e4b95; }
        .btn-action.update { border-color:#cde8cd; background:#ecf8ec; color:#1f6b35; }
        .btn-action.delete { border-color:#f2c6c6; background:#fff1f1; color:#a72c2c; }
        .popup-overlay { position:fixed; inset:0; background:rgba(10,12,18,0.45); display:none; align-items:center; justify-content:center; z-index:1400; padding:16px; }
        .popup-overlay.is-open { display:flex; }
        .popup-card { width:min(100%,520px); background:#fff; border:1px solid #e5e5e5; border-radius:14px; padding:18px; box-shadow:0 20px 40px rgba(17,18,23,0.18); }
        .popup-card h4 { margin:0 0 12px; font-size:20px; line-height:1.2; }
        .popup-input { width:100%; border:1px solid #d4d4d4; border-radius:10px; padding:10px 12px; font:inherit; color:#161616; outline:none; margin-bottom:12px; }
        .popup-input:focus { border-color:#111217; box-shadow:0 0 0 3px rgba(17,18,23,0.08); }
        .popup-help { display:block; margin:-4px 0 10px; color:#666; font-size:12px; }
        .popup-actions { display:flex; justify-content:flex-end; gap:8px; }
        .btn-primary { border:1px solid #111217; background:#111217; color:#fff; border-radius:10px; padding:9px 16px; font:inherit; font-weight:600; cursor:pointer; }
        .read-images { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:8px; margin-top:12px; }
        .read-images img { width:100%; aspect-ratio:16 / 10; object-fit:cover; border-radius:10px; border:1px solid #e4e4e4; }
        .existing-image-list { display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:8px; margin:0 0 12px; }
        .existing-image-item { border:1px solid #e4e4e4; border-radius:10px; padding:8px; }
        .existing-image-item img { width:100%; aspect-ratio:16 / 10; object-fit:cover; border-radius:8px; margin-bottom:6px; }
        .existing-image-item label { font-size:12px; color:#4a4a4a; }
        .image-input-list { display:grid; gap:8px; margin-bottom:8px; }
        .image-input-row { display:flex; gap:8px; align-items:center; }
        .image-input-row .popup-input { margin-bottom:0; }
        .btn-remove-image-input { border:1px solid #f2c6c6; background:#fff1f1; color:#a72c2c; border-radius:10px; padding:8px 10px; font:inherit; font-size:12px; font-weight:700; cursor:pointer; white-space:nowrap; }
        .btn-remove-image-input:disabled { opacity:0.45; cursor:not-allowed; }
        .btn-add-image-input { border:1px solid #b9d2ff; background:#ecf3ff; color:#1e4b95; border-radius:10px; padding:8px 12px; font:inherit; font-size:12px; font-weight:700; cursor:pointer; margin-bottom:10px; }
        .upload-preview-list { display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:8px; margin:0 0 10px; }
        .upload-preview-item { border:1px solid #e4e4e4; border-radius:10px; overflow:hidden; background:#f8f8f8; }
        .upload-preview-item img { width:100%; aspect-ratio:1 / 1; object-fit:cover; display:block; }
    </style>

    <section>
        <div class="panel full-card">
            <div class="head">
                <h3>SIATAB</h3>
                <button type="button" class="btn-plus" id="openPopup" aria-label="Tambah SIATAB">+</button>
            </div>
            @if (session('success'))<div class="flash-success">{{ session('success') }}</div>@endif
            @if ($errors->any())<div class="flash-error">{{ $errors->first() }}</div>@endif

            <div class="table-wrap">
                <table class="table-item">
                    <thead><tr><th>Judul</th><th>Jumlah Gambar</th><th>Tanggal</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($siatabs as $item)
                        @php
                            $imagePayload = $item->images
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
                            <td>{{ $item->judul }}</td>
                            <td>{{ $item->images->count() }}</td>
                            <td>{{ $item->created_at ? $item->created_at->format('d M, Y H:i') : '-' }}</td>
                            <td>
                                <div class="action-group">
                                    <button type="button" class="btn-action read js-read-btn" data-judul="{{ $item->judul }}" data-images="{{ e($imagePayload) }}">Read</button>
                                    <button type="button" class="btn-action update js-update-btn" data-id="{{ $item->id }}" data-judul="{{ $item->judul }}" data-update-url="{{ route('admin.siatab.update', $item->id) }}" data-images="{{ e($imagePayload) }}">Update</button>
                                    <form method="POST" action="{{ route('admin.siatab.destroy', $item->id) }}" class="js-delete-form">@csrf @method('DELETE')<button type="submit" class="btn-action delete">Delete</button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Belum ada data SIATAB.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="popup-overlay" id="createOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4>Tambah SIATAB</h4>
            <form method="POST" action="{{ route('admin.siatab.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <input type="text" class="popup-input" id="createTitleInput" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul" required>
                <div class="image-input-list" id="createImageInputList"></div>
                <button type="button" class="btn-add-image-input" id="addCreateImageInput">+ Tambah Input Gambar</button>
                <div class="upload-preview-list" id="createUploadPreviewList"></div>
                <span class="popup-help">Upload 1 gambar per input. Tambah input jika gambar lebih dari 1.</span>
                <div class="popup-actions"><button type="submit" class="btn-primary">Tambah</button></div>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="readOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4 id="readTitle">Detail SIATAB</h4>
            <div class="read-images" id="readImages"></div>
            <div class="popup-actions" style="margin-top:12px;"><button type="button" class="btn-primary" data-close-overlay="readOverlay">Tutup</button></div>
        </div>
    </div>

    <div class="popup-overlay" id="updateOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4>Update SIATAB</h4>
            <form method="POST" id="updateForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="update">
                <input type="hidden" name="siatab_id" id="updateSiatabId">
                <input type="text" class="popup-input" id="updateTitleInput" name="judul" placeholder="Masukkan judul" required>
                <div id="existingImageList" class="existing-image-list"></div>
                <div class="image-input-list" id="updateImageInputList"></div>
                <button type="button" class="btn-add-image-input" id="addUpdateImageInput">+ Tambah Input Gambar</button>
                <div class="upload-preview-list" id="updateUploadPreviewList"></div>
                <span class="popup-help">Upload 1 gambar per input untuk menambah gambar baru.</span>
                <div class="popup-actions"><button type="submit" class="btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const openButton = document.getElementById('openPopup');
            const createOverlay = document.getElementById('createOverlay');
            const createTitleInput = document.getElementById('createTitleInput');
            const readOverlay = document.getElementById('readOverlay');
            const updateOverlay = document.getElementById('updateOverlay');
            const readTitle = document.getElementById('readTitle');
            const readImages = document.getElementById('readImages');
            const updateForm = document.getElementById('updateForm');
            const updateId = document.getElementById('updateSiatabId');
            const updateTitleInput = document.getElementById('updateTitleInput');
            const existingImageList = document.getElementById('existingImageList');
            if (!openButton || !createOverlay || !createTitleInput) return;

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
                    return { reset: function () {} };
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
                        previewList.innerHTML = '<p style="grid-column:1/-1;margin:0;color:#666;font-size:12px;">Belum ada gambar dipilih.</p>';
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
                return { reset: reset };
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
                minOne: false,
                requireFirst: false
            });

            openButton.addEventListener('click', function () {
                createTitleInput.value = '';
                createImagePickerController.reset();
                openOverlay(createOverlay, createTitleInput);
            });

            document.querySelectorAll('.js-read-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const images = parseImages(button.dataset.images);
                    readTitle.textContent = button.dataset.judul || 'Detail SIATAB';
                    readImages.innerHTML = '';
                    if (!images.length) {
                        readImages.innerHTML = '<p style="grid-column:1/-1;margin:0;color:#666;font-size:12px;">Tidak ada gambar.</p>';
                    } else {
                        images.forEach(function (image) {
                            const img = document.createElement('img');
                            img.src = image.url;
                            img.alt = button.dataset.judul || 'SIATAB';
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
                    updateTitleInput.value = button.dataset.judul || '';
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
                        existingImageList.innerHTML = '<p style="grid-column:1/-1;margin:0;color:#666;font-size:12px;">Belum ada gambar.</p>';
                    }

                    openOverlay(updateOverlay, updateTitleInput);
                });
            });

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus data SIATAB ini beserta semua gambarnya?')) {
                        event.preventDefault();
                    }
                });
            });

            document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) closeOverlay(overlay);
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
                if (event.key === 'Escape') closeAllOverlays();
            });

            @if ($errors->any() && old('form_type') === 'create')
                openOverlay(createOverlay, createTitleInput);
            @endif
        })();
    </script>
@endsection

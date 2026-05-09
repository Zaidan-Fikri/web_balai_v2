@extends('master.admin.app')

@section('title', 'Admin SIATAB')

@section('content')

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
                <span class="popup-help">Bisa pilih banyak gambar sekaligus di satu input (JPG/JPEG/PNG/WEBP, maks 5MB per gambar).</span>
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
                <span class="popup-help">Bisa pilih banyak gambar sekaligus di satu input untuk menambah gambar baru.</span>
                <div class="popup-actions"><button type="submit" class="btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
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
                        if (input.files && input.files.length) {
                            Array.from(input.files).forEach(function (file) {
                                files.push(file);
                            });
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
                        '<input type="file" class="popup-input" name="images[]" accept=".jpg,.jpeg,.png,.webp,image/*" multiple' + (isRequired ? ' required' : '') + '>' +
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
@endpush

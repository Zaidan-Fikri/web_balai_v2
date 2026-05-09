@extends('master.admin.app')

@section('title', 'Admin Berita')

@section('content')

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
@endsection

@push('scripts')
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
@endpush

@extends('master.admin.app')

@section('title', 'Admin Thumbnail')

@section('content')

    <section>
        <div class="panel full-card">
            <div class="thumbnail-head">
                <h3>Thumbnail</h3>
                <button type="button" class="btn-plus" id="openThumbnailPopup" aria-label="Tambah thumbnail">+</button>
            </div>

            @if (session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="flash-error">{{ $errors->first() }}</div>
            @endif

            <div class="table-wrap">
                <table class="thumbnail-table">
                    <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Tampil di Home</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($thumbnails as $thumbnail)
                        @php
                            $imageUrl = asset('storage/' . $thumbnail->image_path);
                        @endphp
                        <tr>
                            <td>
                                <div class="thumb-preview">
                                    <img src="{{ $imageUrl }}" alt="Thumbnail {{ $thumbnail->id }}">
                                </div>
                            </td>
                            <td>
                                <p class="desc-text">{{ $thumbnail->title ?: '-' }}</p>
                            </td>
                            <td>
                                <p class="desc-text">{{ $thumbnail->description ?: '-' }}</p>
                            </td>
                            <td>
                                <input type="checkbox" class="js-thumbnail-visible" value="{{ $thumbnail->id }}" {{ $thumbnail->show_on_home ? 'checked' : '' }}>
                            </td>
                            <td>
                                <div class="action-group">
                                    <button type="button" class="btn-action read js-read-btn" data-image="{{ $imageUrl }}" data-title="{{ $thumbnail->title }}" data-description="{{ $thumbnail->description }}">Read</button>
                                    <button type="button" class="btn-action update js-update-btn" data-update-url="{{ route('admin.thumbnail.update', $thumbnail->id) }}" data-image="{{ $imageUrl }}" data-title="{{ $thumbnail->title }}" data-description="{{ $thumbnail->description }}">Update</button>
                                    <form method="POST" action="{{ route('admin.thumbnail.destroy', $thumbnail->id) }}" class="js-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data thumbnail.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="visibility-actions">
                <form method="POST" action="{{ route('admin.thumbnail.visibility') }}" id="thumbnailVisibilityForm">
                    @csrf
                    <button type="submit" class="btn-primary">Simpan Pilihan Tampil</button>
                </form>
            </div>
        </div>
    </section>

    <div class="popup-overlay" id="createThumbnailOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="createThumbnailTitle">
            <h4 id="createThumbnailTitle">Tambah Thumbnail</h4>
            <form method="POST" action="{{ route('admin.thumbnail.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <input type="text" class="popup-input" id="createTitleInput" name="title" value="{{ old('title') }}" placeholder="Masukkan judul thumbnail">
                <input type="file" class="popup-input" id="createThumbnailInput" name="image" accept=".jpg,.jpeg,.png,.webp,image/*" required>
                <div class="upload-preview" id="createThumbnailPreview"></div>
                <textarea class="popup-textarea" id="createDescriptionInput" name="description" placeholder="Masukkan deskripsi thumbnail">{{ old('description') }}</textarea>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="readThumbnailOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="readThumbnailTitle">
            <h4 id="readThumbnailTitle">Detail Thumbnail</h4>
            <div class="read-description" id="readThumbnailTitleText">-</div>
            <div class="read-image" id="readThumbnailImage"></div>
            <div class="read-description" id="readThumbnailDescription">-</div>
            <div class="popup-actions" style="margin-top: 12px;">
                <button type="button" class="btn-primary" data-close-overlay="readThumbnailOverlay">Tutup</button>
            </div>
        </div>
    </div>

    <div class="popup-overlay" id="updateThumbnailOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="updateThumbnailTitle">
            <h4 id="updateThumbnailTitle">Update Thumbnail</h4>
            <form method="POST" id="updateThumbnailForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="update">
                <input type="text" class="popup-input" id="updateTitleInput" name="title" placeholder="Masukkan judul thumbnail">
                <div class="upload-preview" id="currentThumbnailPreview"></div>
                <input type="file" class="popup-input" id="updateThumbnailInput" name="image" accept=".jpg,.jpeg,.png,.webp,image/*">
                <div class="upload-preview" id="updateThumbnailPreview"></div>
                <textarea class="popup-textarea" id="updateDescriptionInput" name="description" placeholder="Masukkan deskripsi thumbnail"></textarea>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function () {
            const openButton = document.getElementById('openThumbnailPopup');
            const createOverlay = document.getElementById('createThumbnailOverlay');
            const readOverlay = document.getElementById('readThumbnailOverlay');
            const updateOverlay = document.getElementById('updateThumbnailOverlay');
            const createInput = document.getElementById('createThumbnailInput');
            const createPreview = document.getElementById('createThumbnailPreview');
            const createTitleInput = document.getElementById('createTitleInput');
            const readImage = document.getElementById('readThumbnailImage');
            const readTitleText = document.getElementById('readThumbnailTitleText');
            const readDescription = document.getElementById('readThumbnailDescription');
            const updateForm = document.getElementById('updateThumbnailForm');
            const currentPreview = document.getElementById('currentThumbnailPreview');
            const updateInput = document.getElementById('updateThumbnailInput');
            const updatePreview = document.getElementById('updateThumbnailPreview');
            const updateTitleInput = document.getElementById('updateTitleInput');
            const createDescriptionInput = document.getElementById('createDescriptionInput');
            const updateDescriptionInput = document.getElementById('updateDescriptionInput');
            const visibilityForm = document.getElementById('thumbnailVisibilityForm');

            if (!openButton || !createOverlay || !readOverlay || !updateOverlay) return;

            function openOverlay(overlay, focusTarget) {
                overlay.classList.add('is-open');
                overlay.setAttribute('aria-hidden', 'false');
                if (focusTarget) {
                    window.setTimeout(function () {
                        focusTarget.focus();
                    }, 0);
                }
            }

            function closeOverlay(overlay) {
                overlay.classList.remove('is-open');
                overlay.setAttribute('aria-hidden', 'true');
            }

            function closeAllOverlays() {
                document.querySelectorAll('.popup-overlay.is-open').forEach(function (overlay) {
                    closeOverlay(overlay);
                });
            }

            function renderPreview(container, file, fallbackUrl) {
                if (!container) return;
                container.innerHTML = '';

                if (file) {
                    const url = URL.createObjectURL(file);
                    container.innerHTML = '<img src="' + url + '" alt="Preview thumbnail">';
                    const img = container.querySelector('img');
                    if (img) {
                        img.addEventListener('load', function () {
                            URL.revokeObjectURL(url);
                        });
                    }
                    return;
                }

                if (fallbackUrl) {
                    container.innerHTML = '<img src="' + fallbackUrl + '" alt="Thumbnail">';
                } else {
                    container.innerHTML = '<p class="read-meta" style="margin:10px 12px;">Belum ada gambar.</p>';
                }
            }

            openButton.addEventListener('click', function () {
                if (createInput) createInput.value = '';
                if (createTitleInput) createTitleInput.value = '';
                if (createDescriptionInput) createDescriptionInput.value = '';
                renderPreview(createPreview, null, null);
                openOverlay(createOverlay, createInput);
            });

            if (createInput) {
                createInput.addEventListener('change', function () {
                    const file = createInput.files && createInput.files[0] ? createInput.files[0] : null;
                    renderPreview(createPreview, file, null);
                });
            }

            document.querySelectorAll('.js-read-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    readImage.innerHTML = '<img src="' + (button.dataset.image || '') + '" alt="Detail thumbnail">';
                    if (readTitleText) {
                        readTitleText.textContent = button.dataset.title || '-';
                    }
                    if (readDescription) {
                        readDescription.textContent = button.dataset.description || '-';
                    }
                    openOverlay(readOverlay);
                });
            });

            document.querySelectorAll('.js-update-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    if (updateForm) {
                        updateForm.action = button.dataset.updateUrl || '';
                    }
                    if (updateInput) {
                        updateInput.value = '';
                    }
                    if (updateTitleInput) {
                        updateTitleInput.value = button.dataset.title || '';
                    }
                    if (updateDescriptionInput) {
                        updateDescriptionInput.value = button.dataset.description || '';
                    }
                    renderPreview(currentPreview, null, button.dataset.image || null);
                    renderPreview(updatePreview, null, null);
                    openOverlay(updateOverlay, updateInput);
                });
            });

            if (updateInput) {
                updateInput.addEventListener('change', function () {
                    const file = updateInput.files && updateInput.files[0] ? updateInput.files[0] : null;
                    renderPreview(updatePreview, file, null);
                });
            }

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus thumbnail ini?')) {
                        event.preventDefault();
                    }
                });
            });

            if (visibilityForm) {
                visibilityForm.addEventListener('submit', function () {
                    visibilityForm.querySelectorAll('input[name="selected_thumbnail_ids[]"]').forEach(function (input) {
                        input.remove();
                    });

                    const selectedIds = [];
                    document.querySelectorAll('.js-thumbnail-visible:checked').forEach(function (checkbox) {
                        selectedIds.push(checkbox.value);
                    });

                    selectedIds.forEach(function (id) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected_thumbnail_ids[]';
                        input.value = id;
                        visibilityForm.appendChild(input);
                    });
                });
            }

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
                    const overlay = document.getElementById(overlayId);
                    if (overlay) closeOverlay(overlay);
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

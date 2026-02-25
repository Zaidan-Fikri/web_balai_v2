@extends('master.admin.app')

@section('title', 'Admin Thumbnail')

@section('content')
    <style>
        .thumbnail-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            width: 100%;
        }

        .thumbnail-head h3 {
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

        .thumbnail-table {
            width: 100%;
            table-layout: fixed;
        }

        .thumbnail-table th:nth-child(1),
        .thumbnail-table td:nth-child(1) {
            width: 60%;
        }

        .thumbnail-table th:nth-child(2),
        .thumbnail-table td:nth-child(2) {
            width: 16%;
        }

        .thumbnail-table th:nth-child(3),
        .thumbnail-table td:nth-child(3) {
            width: 24%;
        }

        .thumb-preview {
            width: min(100%, 280px);
            border-radius: 12px;
            border: 1px solid #dedede;
            overflow: hidden;
            background: #f9f9f9;
        }

        .thumb-preview img {
            width: 100%;
            aspect-ratio: 16 / 10;
            object-fit: cover;
            display: block;
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
            width: min(100%, 480px);
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

        .upload-preview {
            width: 100%;
            border: 1px solid #e4e4e4;
            border-radius: 10px;
            overflow: hidden;
            background: #f8f8f8;
            margin-bottom: 12px;
        }

        .upload-preview img {
            width: 100%;
            aspect-ratio: 16 / 10;
            object-fit: contain;
            display: block;
            background: #0f1b30;
        }

        .read-image {
            width: 100%;
            border-radius: 12px;
            border: 1px solid #dedede;
            overflow: hidden;
            background: #0f1b30;
        }

        .read-image img {
            width: 100%;
            max-height: min(70vh, 640px);
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .visibility-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }
    </style>

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
                                <input type="checkbox" class="js-thumbnail-visible" value="{{ $thumbnail->id }}" {{ $thumbnail->show_on_home ? 'checked' : '' }}>
                            </td>
                            <td>
                                <div class="action-group">
                                    <button type="button" class="btn-action read js-read-btn" data-image="{{ $imageUrl }}">Read</button>
                                    <button type="button" class="btn-action update js-update-btn" data-update-url="{{ route('admin.thumbnail.update', $thumbnail->id) }}" data-image="{{ $imageUrl }}">Update</button>
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
                            <td colspan="3">Belum ada data thumbnail.</td>
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
                <input type="file" class="popup-input" id="createThumbnailInput" name="image" accept=".jpg,.jpeg,.png,.webp,image/*" required>
                <div class="upload-preview" id="createThumbnailPreview"></div>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="readThumbnailOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="readThumbnailTitle">
            <h4 id="readThumbnailTitle">Detail Thumbnail</h4>
            <div class="read-image" id="readThumbnailImage"></div>
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
                <div class="upload-preview" id="currentThumbnailPreview"></div>
                <input type="file" class="popup-input" id="updateThumbnailInput" name="image" accept=".jpg,.jpeg,.png,.webp,image/*" required>
                <div class="upload-preview" id="updateThumbnailPreview"></div>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const openButton = document.getElementById('openThumbnailPopup');
            const createOverlay = document.getElementById('createThumbnailOverlay');
            const readOverlay = document.getElementById('readThumbnailOverlay');
            const updateOverlay = document.getElementById('updateThumbnailOverlay');
            const createInput = document.getElementById('createThumbnailInput');
            const createPreview = document.getElementById('createThumbnailPreview');
            const readImage = document.getElementById('readThumbnailImage');
            const updateForm = document.getElementById('updateThumbnailForm');
            const currentPreview = document.getElementById('currentThumbnailPreview');
            const updateInput = document.getElementById('updateThumbnailInput');
            const updatePreview = document.getElementById('updateThumbnailPreview');
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
@endsection

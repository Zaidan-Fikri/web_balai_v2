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
            <div class="popup-actions has-gap">
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

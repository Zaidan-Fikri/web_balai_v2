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
            <div class="popup-actions has-gap"><button type="button" class="btn-primary" data-close-overlay="readOverlay">Tutup</button></div>
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

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
            <div class="popup-actions has-gap">
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

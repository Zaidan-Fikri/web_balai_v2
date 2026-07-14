@extends('master.admin.app')

@section('title', 'Admin Berita')

@section('content')

    <section>
        <div class="panel full-card">
            <div class="berita-head">
                <h3>Berita</h3>
                <button type="button" class="btn-plus" id="openBeritaPopup" data-item-label="Berita" aria-label="Tambah berita">+</button>
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
                        <th>Tanggal Publikasi</th>
                        <th>Views</th>
                        <th>User Posting</th>
                        <th>Gambar</th>
                        <th>Video</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($beritas as $berita)
                        @php
                            $imagePayload = $berita->images
                                ->map(fn ($image) => ['id' => $image->id, 'url' => asset('storage/' . $image->image_path)])
                                ->values()
                                ->toJson();
                        @endphp
                        <tr>
                            <td>{{ $berita->judul }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($berita->deskripsi, 90) }}</td>
                            <td>{{ $berita->tanggal_publish ? $berita->tanggal_publish->format('d M Y') : $berita->created_at->format('d M Y') }}</td>
                            <td>{{ number_format($berita->views) }}</td>
                            <td>{{ $berita->author?->email ?? '-' }}</td>
                            <td>{{ $berita->images->count() }}</td>
                            <td>
                                @if ($berita->video_path)
                                    <span style="color:#1a6bcc;font-weight:700;font-size:.8rem;">
                                        {{ $berita->video_orientasi === 'portrait' ? 'Portrait' : 'Landscape' }}
                                    </span>
                                @else
                                    <span style="color:#aaa;font-size:.8rem;">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-group">
                                    <button
                                        type="button"
                                        class="btn-action read js-read-btn"
                                        data-judul="{{ $berita->judul }}"
                                        data-deskripsi="{{ $berita->deskripsi }}"
                                        data-created="{{ $berita->tanggal_publish ? $berita->tanggal_publish->format('d M Y') : $berita->created_at->format('d M Y') }}"
                                        data-images="{{ e($imagePayload) }}"
                                        data-video-url="{{ $berita->video_path ? asset('storage/' . $berita->video_path) : '' }}"
                                        data-video-orientasi="{{ $berita->video_orientasi ?? 'landscape' }}"
                                    >Read</button>
                                    <button
                                        type="button"
                                        class="btn-action update js-update-btn"
                                        data-id="{{ $berita->id }}"
                                        data-judul="{{ $berita->judul }}"
                                        data-deskripsi="{{ $berita->deskripsi }}"
                                        data-tanggal="{{ $berita->tanggal_publish ? $berita->tanggal_publish->format('Y-m-d') : $berita->created_at->format('Y-m-d') }}"
                                        data-update-url="{{ route('admin.berita.update', $berita->id) }}"
                                        data-images="{{ e($imagePayload) }}"
                                        data-video-url="{{ $berita->video_path ? asset('storage/' . $berita->video_path) : '' }}"
                                        data-video-orientasi="{{ $berita->video_orientasi ?? 'landscape' }}"
                                    >Update</button>
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
                            <td colspan="8">Belum ada data berita.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- CREATE POPUP --}}
    <div class="popup-overlay" id="beritaPopupOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="beritaPopupTitle">
            <h4 id="beritaPopupTitle">Tambah Berita</h4>
            <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <input type="text" class="popup-input" id="beritaPopupInput" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul berita" required>
                <textarea class="popup-textarea" name="deskripsi" placeholder="Masukkan deskripsi berita" required>{{ old('deskripsi') }}</textarea>

                <label class="popup-label-sm">Tanggal Publikasi</label>
                <input type="date" class="popup-input" name="tanggal_publish" value="{{ old('tanggal_publish', now()->format('Y-m-d')) }}">

                {{-- Video --}}
                <div class="video-upload-block">
                    <p class="popup-label-sm">Video (Opsional)</p>
                    <select name="video_orientasi" class="popup-input popup-select" id="createVideoOrientasi">
                        <option value="landscape">Landscape (Horizontal 16:9)</option>
                        <option value="portrait">Portrait (Vertikal 9:16)</option>
                    </select>
                    <input type="file" name="video" class="popup-input" id="createVideoInput" accept="video/mp4,video/webm,video/quicktime,video/*">
                    <span class="popup-help">Format: MP4, WebM, MOV. Maks 800 MB.</span>
                    <div class="video-preview-wrap" id="createVideoPreview" style="display:none;">
                        <video id="createVideoEl" controls></video>
                        <button type="button" class="btn-remove-video" id="clearCreateVideo">
                            <i class="fa-solid fa-xmark fa-xs"></i> Hapus Video
                        </button>
                    </div>
                </div>

                {{-- Images --}}
                <div class="image-input-list" id="createImageInputList"></div>
                <button type="button" class="btn-add-image-input" id="addCreateImageInput">+ Tambah Input Gambar</button>
                <div class="upload-preview-list" id="createUploadPreviewList"></div>
                <span class="popup-help">Gambar opsional. Upload 1 gambar per input. Tambah input jika gambar lebih dari 1.</span>
                <div class="popup-actions">
                    <button type="submit" class="btn-tambah">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- READ POPUP --}}
    <div class="popup-overlay" id="readBeritaOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="readBeritaTitle">
            <h4 id="readBeritaTitle">Detail Berita</h4>
            <p class="read-meta" id="readBeritaCreated">-</p>
            <p class="read-desc" id="readBeritaDescription"></p>
            <div id="readBeritaVideo" class="read-video-wrap" style="display:none;">
                <p class="popup-label-sm" style="margin-bottom:6px;">Video</p>
                <video id="readBeritaVideoEl" controls style="width:100%;border-radius:10px;"></video>
            </div>
            <div class="read-images" id="readBeritaImages"></div>
            <div class="popup-actions has-gap">
                <button type="button" class="btn-tambah" data-close-overlay="readBeritaOverlay">Tutup</button>
            </div>
        </div>
    </div>

    {{-- UPDATE POPUP --}}
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

                <label class="popup-label-sm">Tanggal Publikasi</label>
                <input type="date" class="popup-input" id="updateBeritaTanggal" name="tanggal_publish">

                {{-- Existing video --}}
                <div id="existingVideoBlock" class="video-upload-block" style="display:none;">
                    <p class="popup-label-sm">Video Saat Ini</p>
                    <video id="existingVideoEl" controls style="width:100%;border-radius:10px;margin-bottom:8px;"></video>
                    <label class="remove-video-label">
                        <input type="checkbox" name="remove_video" value="1" id="removeVideoCheckbox">
                        Hapus video ini
                    </label>
                </div>

                {{-- New video upload --}}
                <div class="video-upload-block" id="newVideoBlock">
                    <p class="popup-label-sm" id="newVideoLabel">Unggah Video Baru (Opsional)</p>
                    <select name="video_orientasi" class="popup-input popup-select" id="updateVideoOrientasi">
                        <option value="landscape">Landscape (Horizontal 16:9)</option>
                        <option value="portrait">Portrait (Vertikal 9:16)</option>
                    </select>
                    <input type="file" name="video" class="popup-input" id="updateVideoInput" accept="video/mp4,video/webm,video/quicktime,video/*">
                    <span class="popup-help">Format: MP4, WebM, MOV. Maks 800 MB.</span>
                    <div class="video-preview-wrap" id="updateVideoPreview" style="display:none;">
                        <video id="updateVideoEl" controls></video>
                        <button type="button" class="btn-remove-video" id="clearUpdateVideo">
                            <i class="fa-solid fa-xmark fa-xs"></i> Hapus Video
                        </button>
                    </div>
                </div>

                {{-- Existing images --}}
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

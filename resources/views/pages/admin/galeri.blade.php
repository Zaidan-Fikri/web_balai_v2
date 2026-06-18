@extends('master.admin.app')

@section('title', 'Admin Galeri')

@push('styles')
<style>
    /* ── Upload progress overlay ── */
    #uploadProgressOverlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0,12,44,0.72);
        backdrop-filter: blur(6px);
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 20px;
    }
    #uploadProgressOverlay.is-active { display: flex; }
    .upload-progress-card {
        background: #fff;
        border-radius: 22px;
        padding: 32px 36px;
        min-width: 320px;
        max-width: 90vw;
        box-shadow: 0 28px 60px rgba(0,26,102,0.22);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }
    .upload-progress-title {
        font-family: var(--bat-font-title);
        font-size: 15px;
        font-weight: 900;
        color: #001a66;
        text-align: center;
    }
    .upload-progress-sub {
        font-size: 12px;
        color: #667085;
        text-align: center;
        line-height: 1.5;
    }
    .upload-progress-bar-wrap {
        width: 100%;
        height: 10px;
        background: #e8eeff;
        border-radius: 999px;
        overflow: hidden;
    }
    .upload-progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #0047cc, #0b2b5c);
        border-radius: 999px;
        width: 0%;
        transition: width 0.2s ease;
    }
    .upload-progress-pct {
        display: none;
    }
    .upload-progress-info {
        font-size: 12px;
        color: #748094;
        text-align: center;
    }
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 11px 18px;
        border: 1px solid rgba(0, 51, 153, 0.22);
        border-radius: 14px;
        background: #ffffff;
        color: var(--navy-dark);
        font-size: 14px;
        font-weight: 900;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.2s ease, background-color 0.2s ease, border-color 0.2s ease;
    }
    .btn-secondary:hover {
        background: var(--blue-light, #E8EEFF);
        border-color: rgba(0, 71, 204, 0.35);
        transform: translateY(-1px);
    }
    .badge-type {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 900;
        letter-spacing: .04em;
        text-transform: uppercase;
    }
    .badge-type.foto {
        background: #e8f4ff;
        color: #0047cc;
    }
    .badge-type.video {
        background: #fff3e0;
        color: #b86200;
    }
    .color-swatch-wrap {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .color-swatch {
        display: inline-block;
        width: 18px;
        height: 18px;
        border-radius: 4px;
        border: 1px solid rgba(0,0,0,.15);
        vertical-align: middle;
        flex-shrink: 0;
    }
    .color-hex {
        font-size: 12px;
        font-family: monospace;
        color: #555;
    }
    .color-picker-wrap {
        margin-top: 12px;
        margin-bottom: 4px;
    }
    .color-picker-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--navy-dark);
        margin-bottom: 8px;
    }
    .color-picker-hint {
        font-weight: 400;
        font-size: 11px;
        color: #888;
        margin-left: 4px;
    }
    .color-picker-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .color-input {
        width: 48px;
        height: 38px;
        padding: 2px;
        border: 1px solid rgba(0,51,153,.2);
        border-radius: 8px;
        cursor: pointer;
        background: none;
    }
    .color-hex-live {
        font-size: 13px;
        font-family: monospace;
        color: #444;
    }
    .popup-label-sm { display:block; font-size:12px; font-weight:700; color:#555; margin:10px 0 6px; }
    .extra-images-list { display:flex; flex-wrap:wrap; gap:8px; margin:6px 0 10px; }
    .extra-img-item { position:relative; }
    .extra-img-item img { width:70px; height:70px; object-fit:cover; border-radius:8px; border:1px solid #dde; display:block; }
    .extra-img-del { position:absolute; top:-6px; right:-6px; width:20px; height:20px; border-radius:50%;
        background:#e74c3c; color:#fff; border:none; cursor:pointer; font-size:11px;
        display:flex; align-items:center; justify-content:center; line-height:1; }
    .galeri-extra-input { margin-bottom:8px; }
    .galeri-popup .popup-input { min-height:38px; padding:8px 12px; border-radius:10px; }
    .galeri-popup input[type="file"].popup-input { padding:7px 10px; }
    .galeri-popup .popup-textarea { min-height:74px; padding:10px 12px; border-radius:10px; }
    .galeri-main-preview { margin:8px 0 8px; }
    .galeri-main-preview img {
        aspect-ratio:16 / 7;
        max-height:180px;
        object-fit:cover;
    }
    .galeri-current-preview img { max-height:150px; }
    @media (max-width: 640px) {
        .galeri-main-preview img { aspect-ratio:16 / 9; max-height:150px; }
    }

    /* ── Read popup ── */
    .galeri-read-card { padding: 0; overflow: hidden; }
    .galeri-read-card .read-image { margin: 0; border-radius: 0; }
    .galeri-read-card .read-image img {
        width: 100%; max-height: 280px; object-fit: cover;
        border-radius: 0; display: block;
    }
    .read-extra-photos {
        display: flex; gap: 6px; padding: 8px 16px 0;
        overflow-x: auto; flex-wrap: nowrap;
    }
    .read-extra-photos:empty { display: none; }
    .read-extra-photos img {
        width: 64px; height: 64px; object-fit: cover;
        border-radius: 8px; border: 2px solid #e8eeff;
        flex-shrink: 0; cursor: pointer; transition: border-color 0.15s;
    }
    .read-extra-photos img:hover { border-color: #0047cc; }
    .read-info-body { padding: 14px 20px 4px; }
    .read-badges { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 10px; }
    .read-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 10px; border-radius: 999px;
        font-size: 11px; font-weight: 900; letter-spacing: .04em; text-transform: uppercase;
    }
    .read-badge.tipe-foto { background: #e8f4ff; color: #0047cc; }
    .read-badge.tipe-video { background: #fff3e0; color: #b86200; }
    .read-badge.kategori { background: #f0f0ff; color: #4b3fa0; }
    .read-judul {
        margin: 0 0 8px; font-family: var(--bat-font-title);
        font-size: 18px; font-weight: 900; color: #001a66; line-height: 1.25;
    }
    .read-desc {
        margin: 0 0 8px; font-size: 13px; color: #4a5568;
        line-height: 1.6; white-space: pre-wrap;
    }
    .read-desc:empty { display: none; }
    .read-tanggal {
        margin: 0; font-size: 11.5px; color: #98a2b3; font-weight: 700;
    }
    .galeri-read-card .popup-actions { padding: 12px 20px 20px; }
</style>
@endpush

@section('content')

    {{-- Upload progress overlay --}}
    <div id="uploadProgressOverlay" role="alertdialog" aria-label="Sedang mengupload">
        <div class="upload-progress-card">
            <div class="upload-progress-pct" id="uploadProgressPct">0%</div>
            <div class="upload-progress-bar-wrap">
                <div class="upload-progress-bar-fill" id="uploadProgressFill"></div>
            </div>
            <div class="upload-progress-title" id="uploadProgressTitle">Sedang mengupload...</div>
            <div class="upload-progress-sub" id="uploadProgressSub">Mohon tunggu, jangan tutup halaman ini.</div>
            <div class="upload-progress-info" id="uploadProgressInfo"></div>
        </div>
    </div>

    <section>
        <div class="panel full-card">
            <div class="thumbnail-head">
                <h3>Galeri Foto &amp; Video</h3>
                <button type="button" class="btn-plus" id="openGaleriPopup" aria-label="Tambah item galeri">+</button>
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
                            <th>Foto</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Tipe</th>
                            <th>Background</th>
                            <th>Diupload Oleh</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($galeris as $item)
                            @php $imageUrl = $item->image_url; @endphp
                            <tr>
                                <td>
                                    <div class="thumb-preview">
                                        <img src="{{ $imageUrl }}" alt="{{ $item->judul }}">
                                    </div>
                                </td>
                                <td>
                                    <p class="desc-text">{{ $item->judul }}</p>
                                </td>
                                <td>
                                    <p class="desc-text">{{ $item->deskripsi ?: '-' }}</p>
                                </td>
                                <td>
                                    <span class="badge-type {{ $item->type }}">{{ ucfirst($item->type) }}</span>
                                </td>
                                <td>
                                    @if ($item->background_color)
                                        <div class="color-swatch-wrap">
                                            <span class="color-swatch" style="background:{{ $item->background_color }}"></span>
                                            <span class="color-hex">{{ $item->background_color }}</span>
                                        </div>
                                    @else
                                        <span class="desc-text">-</span>
                                    @endif
                                </td>
                                <td>
                                    <p class="desc-text">{{ $item->author?->email ?? '-' }}</p>
                                </td>
                                <td>
                                    <p class="desc-text">{{ $item->tanggal_publish ? $item->tanggal_publish->format('d/m/Y H:i') : $item->created_at->format('d/m/Y H:i') }}</p>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <button type="button" class="btn-action read js-galeri-read-btn"
                                            data-image="{{ $imageUrl }}"
                                            data-images="{{ json_encode($item->images->map(fn($i) => $i->image_url)->values()) }}"
                                            data-judul="{{ $item->judul }}"
                                            data-deskripsi="{{ $item->deskripsi }}"
                                            data-type="{{ $item->type }}"
                                            data-kategori="{{ $item->kategori }}"
                                            data-tanggal="{{ $item->tanggal_publish ? $item->tanggal_publish->format('d M Y H:i') : $item->created_at->format('d M Y H:i') }}"
                                            data-bg="{{ $item->background_color }}">Read</button>
                                        <button type="button" class="btn-action update js-galeri-update-btn"
                                            data-update-url="{{ route('admin.galeri.update', $item->id) }}"
                                            data-image="{{ $imageUrl }}"
                                            data-video-url="{{ $item->video_path ? asset('storage/' . $item->video_path) : '' }}"
                                            data-kategori="{{ $item->kategori }}"
                                            data-judul="{{ $item->judul }}"
                                            data-deskripsi="{{ $item->deskripsi }}"
                                            data-type="{{ $item->type }}"
                                            data-tanggal="{{ $item->tanggal_publish ? $item->tanggal_publish->format('Y-m-d\TH:i') : '' }}"
                                            data-bg="{{ $item->background_color }}"
                                            data-extra-images="{{ json_encode($item->images->map(fn($i) => ['id' => $i->id, 'url' => $i->image_url, 'delete_url' => route('admin.galeri.destroy-image', [$item->id, $i->id])])->values()) }}">Update</button>
                                        <form method="POST" action="{{ route('admin.galeri.destroy', $item->id) }}" class="js-galeri-delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action delete">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Belum ada data galeri.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Popup: Tambah --}}
    <div class="popup-overlay" id="createGaleriOverlay" aria-hidden="true">
        <div class="popup-card galeri-popup" role="dialog" aria-modal="true" aria-labelledby="createGaleriTitle">
            <h4 id="createGaleriTitle">Tambah Galeri</h4>
            <form method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data">
                @csrf
                <label class="popup-label-sm">Kategori</label>
                <select class="popup-input" name="kategori" id="createGaleriKategori">
                    <option value="">-- Tanpa Kategori --</option>
                    @foreach (['Geolistrik 1D', 'Geolistrik 2D', 'Pumping Test', 'Borehole Camera', 'Logger', 'Kegiatan Balai Air Tanah', 'Laboratorium'] as $opt)
                        <option value="{{ $opt }}" {{ old('kategori') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
                <select class="popup-input" name="type" id="createGaleriType">
                    <option value="foto" {{ old('type') === 'video' ? '' : 'selected' }}>Foto</option>
                    <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video</option>
                </select>

                {{-- Foto section --}}
                <div id="createFotoSection">
                    <label class="popup-label-sm">Foto Galeri</label>
                    <input type="file" class="popup-input" id="createGaleriImage" name="images[]"
                        accept=".jpg,.jpeg,.png,.webp,image/*" multiple required>
                    <div class="upload-preview galeri-main-preview" id="createGaleriPreview"></div>
                    <span class="popup-help">Pilih 1 atau banyak foto. Foto pertama otomatis menjadi foto utama.</span>
                </div>

                {{-- Video section --}}
                <div id="createVideoSection" style="display:none;">
                    <div class="video-upload-block" style="margin-top:10px;">
                        <p class="popup-label-sm" style="margin-top:0;">File Video <span style="color:#e74c3c;">*</span></p>
                        <input type="file" class="popup-input" id="createGaleriVideo" name="video"
                            accept="video/mp4,video/webm,video/quicktime,video/*">
                        <span class="popup-help">Format: MP4, WebM, MOV. Maks 800 MB.</span>
                        <div class="video-preview-wrap" id="createGaleriVideoPreview" style="display:none;">
                            <video id="createGaleriVideoEl" controls></video>
                            <button type="button" class="btn-remove-video" id="clearCreateGaleriVideo">
                                <i class="fa-solid fa-xmark fa-xs"></i> Hapus
                            </button>
                        </div>
                    </div>
                    <label class="popup-label-sm">Thumbnail <span style="font-weight:400;color:#888">(opsional — tampil di tile galeri)</span></label>
                    <input type="file" class="popup-input" id="createGaleriImageOpt" name="image"
                        accept=".jpg,.jpeg,.png,.webp,image/*">
                    <div class="upload-preview galeri-main-preview" id="createGaleriPreviewOpt"></div>
                </div>
                <label class="popup-label-sm">Judul</label>
                <input type="text" class="popup-input" id="createGaleriJudul" name="judul"
                    placeholder="Judul galeri" value="{{ old('judul') }}" required>
                <textarea class="popup-textarea" id="createGaleriDeskripsi" name="deskripsi"
                    placeholder="Deskripsi (opsional)">{{ old('deskripsi') }}</textarea>
                <label class="popup-label-sm">Tanggal &amp; Jam Publikasi</label>
                <input type="datetime-local" class="popup-input" id="createGaleriTanggal" name="tanggal_publish"
                    value="{{ old('tanggal_publish', now()->format('Y-m-d\TH:i')) }}">
                <div class="color-picker-wrap">
                    <label class="color-picker-label" for="createGaleriBg">
                        <i class="fa-solid fa-palette"></i> Warna Background Tile
                        <span class="color-picker-hint">(dipakai saat belum ada foto)</span>
                    </label>
                    <div class="color-picker-row">
                        <input type="color" class="color-input" id="createGaleriBg" name="background_color"
                            value="{{ old('background_color', '#0d2d5e') }}">
                        <span class="color-hex-live" id="createGaleriBgHex">{{ old('background_color', '#0d2d5e') }}</span>
                    </div>
                </div>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Tambah</button>
                    <button type="button" class="btn-secondary" data-close-overlay="createGaleriOverlay">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Popup: Detail --}}
    <div class="popup-overlay" id="readGaleriOverlay" aria-hidden="true">
        <div class="popup-card galeri-read-card" role="dialog" aria-modal="true" aria-labelledby="readGaleriTitle">

            {{-- Foto utama --}}
            <div class="read-image" id="readGaleriImage"></div>

            {{-- Foto tambahan --}}
            <div class="read-extra-photos" id="readGaleriExtraPhotos"></div>

            {{-- Info --}}
            <div class="read-info-body">
                {{-- Badge baris atas --}}
                <div class="read-badges" id="readGaleriBadges"></div>

                {{-- Judul --}}
                <h4 class="read-judul" id="readGaleriTitle">-</h4>

                {{-- Deskripsi --}}
                <p class="read-desc" id="readGaleriDeskripsi"></p>

                {{-- Tanggal --}}
                <p class="read-tanggal" id="readGaleriTanggal"></p>
            </div>

            <div class="popup-actions has-gap">
                <button type="button" class="btn-primary" data-close-overlay="readGaleriOverlay">Tutup</button>
            </div>

            {{-- Elemen lama disembunyikan (untuk kompatibilitas JS lama) --}}
            <span id="readGaleriJudul" hidden></span>
            <span id="readGaleriType" hidden></span>
            <span id="readGaleriBgWrap" hidden></span>
            <span id="readGaleriBgSwatch" hidden></span>
            <span id="readGaleriBgHex" hidden></span>
        </div>
    </div>

    {{-- Popup: Update --}}
    <div class="popup-overlay" id="updateGaleriOverlay" aria-hidden="true">
        <div class="popup-card galeri-popup" role="dialog" aria-modal="true" aria-labelledby="updateGaleriTitle">
            <h4 id="updateGaleriTitle">Update Galeri</h4>
            <form method="POST" id="updateGaleriForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <label class="popup-label-sm">Kategori</label>
                <select class="popup-input" name="kategori" id="updateGaleriKategori">
                    <option value="">-- Tanpa Kategori --</option>
                    @foreach (['Geolistrik 1D', 'Geolistrik 2D', 'Pumping Test', 'Borehole Camera', 'Logger', 'Kegiatan Balai Air Tanah', 'Laboratorium'] as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
                <select class="popup-input" name="type" id="updateGaleriType">
                    <option value="foto">Foto</option>
                    <option value="video">Video</option>
                </select>

                {{-- Foto section --}}
                <div id="updateFotoSection">
                    <div class="upload-preview galeri-main-preview galeri-current-preview" id="updateGaleriCurrentPreview"></div>
                    <label class="popup-label-sm">Ganti Foto Utama <span style="font-weight:400;color:#888">(opsional)</span></label>
                    <input type="file" class="popup-input" id="updateGaleriImage" name="image"
                        accept=".jpg,.jpeg,.png,.webp,image/*">
                    <div class="upload-preview galeri-main-preview" id="updateGaleriNewPreview"></div>
                    <div id="updateGaleriExtraList" class="extra-images-list"></div>
                    <label class="popup-label-sm">Tambah Foto Lagi <span style="font-weight:400;color:#888">(opsional)</span></label>
                    <input type="file" class="popup-input galeri-extra-input" name="extra_images[]"
                        accept=".jpg,.jpeg,.png,.webp,image/*" multiple>
                </div>

                {{-- Video section --}}
                <div id="updateVideoSection" style="display:none;">
                    <div id="updateGaleriExistingVideo" class="video-upload-block" style="display:none;margin-top:10px;">
                        <p class="popup-label-sm" style="margin-top:0;">Video Saat Ini</p>
                        <video id="updateGaleriVideoEl" controls style="width:100%;border-radius:10px;max-height:180px;background:#000;margin-bottom:8px;"></video>
                        <label class="remove-video-label">
                            <input type="checkbox" name="remove_video" value="1" id="galeriRemoveVideoCheck">
                            Hapus video ini
                        </label>
                    </div>
                    <div class="video-upload-block" style="margin-top:10px;">
                        <p class="popup-label-sm" id="updateGaleriVideoLabel" style="margin-top:0;">Unggah Video Baru</p>
                        <input type="file" class="popup-input" id="updateGaleriVideoInput" name="video"
                            accept="video/mp4,video/webm,video/quicktime,video/*">
                        <span class="popup-help">Format: MP4, WebM, MOV. Maks 800 MB.</span>
                        <div class="video-preview-wrap" id="updateGaleriVideoPreview" style="display:none;">
                            <video id="updateGaleriVideoNewEl" controls></video>
                            <button type="button" class="btn-remove-video" id="clearUpdateGaleriVideo">
                                <i class="fa-solid fa-xmark fa-xs"></i> Hapus
                            </button>
                        </div>
                    </div>
                    <label class="popup-label-sm">Ganti Thumbnail <span style="font-weight:400;color:#888">(opsional)</span></label>
                    <div class="upload-preview galeri-main-preview galeri-current-preview" id="updateGaleriCurrentPreviewVideo"></div>
                    <input type="file" class="popup-input" id="updateGaleriImageVideo" name="image"
                        accept=".jpg,.jpeg,.png,.webp,image/*">
                    <div class="upload-preview galeri-main-preview" id="updateGaleriNewPreviewVideo"></div>
                </div>
                <label class="popup-label-sm">Judul</label>
                <input type="text" class="popup-input" id="updateGaleriJudul" name="judul"
                    placeholder="Judul galeri" required>
                <textarea class="popup-textarea" id="updateGaleriDeskripsi" name="deskripsi"
                    placeholder="Deskripsi (opsional)"></textarea>
                <label class="popup-label-sm">Tanggal &amp; Jam Publikasi</label>
                <input type="datetime-local" class="popup-input" id="updateGaleriTanggal" name="tanggal_publish">
                <div class="color-picker-wrap">
                    <label class="color-picker-label" for="updateGaleriBg">
                        <i class="fa-solid fa-palette"></i> Warna Background Tile
                        <span class="color-picker-hint">(dipakai saat belum ada foto)</span>
                    </label>
                    <div class="color-picker-row">
                        <input type="color" class="color-input" id="updateGaleriBg" name="background_color"
                            value="#0d2d5e">
                        <span class="color-hex-live" id="updateGaleriBgHex">#0d2d5e</span>
                    </div>
                </div>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Simpan</button>
                    <button type="button" class="btn-secondary" data-close-overlay="updateGaleriOverlay">Batal</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
(function () {

    /* ── Helper: toggle foto/video sections ─────────────────────────── */
    function applyTypeToggle(type, fotoSection, videoSection, imageInput) {
        var isVideo = type === 'video';
        fotoSection.style.display  = isVideo ? 'none' : '';
        videoSection.style.display = isVideo ? '' : 'none';
        // disable inputs in hidden section so they're not submitted
        fotoSection.querySelectorAll('input,select,textarea').forEach(function(el) {
            el.disabled = isVideo;
        });
        videoSection.querySelectorAll('input,select,textarea').forEach(function(el) {
            el.disabled = !isVideo;
        });
    }

    /* ── CREATE: type toggle ─────────────────────────────────────────── */
    var createType    = document.getElementById('createGaleriType');
    var createFoto    = document.getElementById('createFotoSection');
    var createVideo   = document.getElementById('createVideoSection');
    var createImgMain = document.getElementById('createGaleriImage');

    if (createType && createFoto && createVideo) {
        applyTypeToggle(createType.value, createFoto, createVideo, createImgMain);
        createType.addEventListener('change', function () {
            applyTypeToggle(this.value, createFoto, createVideo, createImgMain);
        });

        /* video file preview */
        var cvInput   = document.getElementById('createGaleriVideo');
        var cvPreview = document.getElementById('createGaleriVideoPreview');
        var cvEl      = document.getElementById('createGaleriVideoEl');
        var cvClear   = document.getElementById('clearCreateGaleriVideo');
        if (cvInput && cvPreview && cvEl) {
            cvInput.addEventListener('change', function () {
                var file = cvInput.files && cvInput.files[0];
                if (file) { cvEl.src = URL.createObjectURL(file); cvPreview.style.display = ''; }
                else { cvPreview.style.display = 'none'; cvEl.src = ''; }
            });
        }
        if (cvClear && cvInput && cvEl && cvPreview) {
            cvClear.addEventListener('click', function () {
                cvInput.value = ''; cvEl.src = ''; cvPreview.style.display = 'none';
            });
        }
    }

    /* ── UPDATE: type toggle + populate fields ───────────────────────── */
    var updateType        = document.getElementById('updateGaleriType');
    var updateFoto        = document.getElementById('updateFotoSection');
    var updateVideo       = document.getElementById('updateVideoSection');
    var updateExistVideo  = document.getElementById('updateGaleriExistingVideo');
    var updateVideoEl     = document.getElementById('updateGaleriVideoEl');
    var updateVideoLabel  = document.getElementById('updateGaleriVideoLabel');
    var removeVideoCheck  = document.getElementById('galeriRemoveVideoCheck');
    var uvInput           = document.getElementById('updateGaleriVideoInput');
    var uvPreview         = document.getElementById('updateGaleriVideoPreview');
    var uvEl              = document.getElementById('updateGaleriVideoNewEl');
    var uvClear           = document.getElementById('clearUpdateGaleriVideo');

    if (updateType && updateFoto && updateVideo) {
        updateType.addEventListener('change', function () {
            applyTypeToggle(this.value, updateFoto, updateVideo, null);
        });
        /* new video preview */
        if (uvInput && uvPreview && uvEl) {
            uvInput.addEventListener('change', function () {
                var file = uvInput.files && uvInput.files[0];
                if (file) { uvEl.src = URL.createObjectURL(file); uvPreview.style.display = ''; }
                else { uvPreview.style.display = 'none'; uvEl.src = ''; }
            });
        }
        if (uvClear && uvInput && uvEl && uvPreview) {
            uvClear.addEventListener('click', function () {
                uvInput.value = ''; uvEl.src = ''; uvPreview.style.display = 'none';
            });
        }
    }

    /* ── UPDATE: populate fields when button clicked ─────────────────── */
    document.querySelectorAll('.js-galeri-update-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {

            /* type toggle */
            if (updateType) {
                updateType.value = btn.dataset.type || 'foto';
                applyTypeToggle(updateType.value, updateFoto, updateVideo, null);
            }

            /* current thumbnail */
            var curPreview = document.getElementById('updateGaleriCurrentPreview');
            var curPreviewVid = document.getElementById('updateGaleriCurrentPreviewVideo');
            [curPreview, curPreviewVid].forEach(function(el) {
                if (!el) return;
                el.innerHTML = btn.dataset.image
                    ? '<img src="' + btn.dataset.image + '" alt="thumbnail" style="border-radius:8px;max-height:150px;">'
                    : '';
            });

            /* existing video */
            var videoUrl = btn.dataset.videoUrl || '';
            if (updateExistVideo && updateVideoEl && updateVideoLabel) {
                if (videoUrl) {
                    updateVideoEl.src = videoUrl;
                    updateExistVideo.style.display = '';
                    if (updateVideoLabel) updateVideoLabel.textContent = 'Ganti dengan Video Baru (Opsional)';
                } else {
                    updateVideoEl.src = '';
                    updateExistVideo.style.display = 'none';
                    if (updateVideoLabel) updateVideoLabel.textContent = 'Unggah Video';
                }
            }
            if (removeVideoCheck) removeVideoCheck.checked = false;
            if (uvInput) uvInput.value = '';
            if (uvEl) uvEl.src = '';
            if (uvPreview) uvPreview.style.display = 'none';

            /* extra images */
            var listEl = document.getElementById('updateGaleriExtraList');
            if (listEl) {
                listEl.innerHTML = '';
                var extras = [];
                try { extras = JSON.parse(btn.dataset.extraImages || '[]'); } catch(e) {}
                extras.forEach(function (item) {
                    var wrap = document.createElement('div');
                    wrap.className = 'extra-img-item';
                    var img = document.createElement('img');
                    img.src = item.url; img.alt = 'foto tambahan';
                    var del = document.createElement('button');
                    del.type = 'button'; del.className = 'extra-img-del';
                    del.innerHTML = '&times;'; del.title = 'Hapus foto ini';
                    del.addEventListener('click', function () {
                        if (!confirm('Hapus foto tambahan ini?')) return;
                        var f = document.createElement('form');
                        f.method = 'POST'; f.action = item.delete_url;
                        f.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">';
                        document.body.appendChild(f); f.submit();
                    });
                    wrap.appendChild(img); wrap.appendChild(del); listEl.appendChild(wrap);
                });
            }
        }, true);
    });

})();

/* ── Loading overlay saat form submit (native submit, bukan XHR) ── */
(function () {
    var overlay = document.getElementById('uploadProgressOverlay');
    var titleEl = document.getElementById('uploadProgressTitle');
    var subEl   = document.getElementById('uploadProgressSub');
    var pctEl   = document.getElementById('uploadProgressPct');
    var fillEl  = document.getElementById('uploadProgressFill');
    var infoEl  = document.getElementById('uploadProgressInfo');

    function countFiles(form) {
        var total = 0;
        form.querySelectorAll('input[type="file"]').forEach(function (inp) {
            total += inp.files ? inp.files.length : 0;
        });
        return total;
    }

    function showOverlay(form) {
        var n = countFiles(form);
        pctEl.textContent   = '';
        fillEl.style.width  = '0%';
        fillEl.style.transition = 'none';
        titleEl.textContent = 'Sedang mengupload' + (n > 0 ? ' ' + n + ' file' : '') + '...';
        subEl.textContent   = 'Mohon tunggu, jangan tutup halaman ini.';
        infoEl.textContent  = 'Proses ini mungkin memakan waktu beberapa menit.';
        overlay.classList.add('is-active');

        /* Animasi bar indeterminate selama tunggu */
        var pct = 0;
        var timer = setInterval(function () {
            pct = Math.min(pct + (pct < 70 ? 1.5 : 0.3), 90);
            fillEl.style.transition = 'width 0.8s ease';
            fillEl.style.width = pct + '%';
        }, 800);

        /* Simpan timer di window agar bisa dibersihkan jika perlu */
        window._uploadTimer = timer;
    }

    var createForm = document.querySelector('#createGaleriOverlay form');
    if (createForm) {
        createForm.addEventListener('submit', function () {
            showOverlay(this);
            /* Biarkan form submit berjalan normal (tidak ada preventDefault) */
        });
    }

    var updateForm = document.getElementById('updateGaleriForm');
    if (updateForm) {
        updateForm.addEventListener('submit', function () {
            showOverlay(this);
        });
    }

    /* Sembunyikan overlay saat halaman baru dimuat (navigasi berhasil) */
    window.addEventListener('pageshow', function () {
        if (overlay) overlay.classList.remove('is-active');
        if (window._uploadTimer) clearInterval(window._uploadTimer);
    });
})();
</script>
@endpush

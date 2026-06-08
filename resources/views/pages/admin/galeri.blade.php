@extends('master.admin.app')

@section('title', 'Admin Galeri')

@push('styles')
<style>
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
</style>
@endpush

@section('content')

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
                                    <p class="desc-text">{{ $item->created_at->format('d/m/Y') }}</p>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <button type="button" class="btn-action read js-galeri-read-btn"
                                            data-image="{{ $imageUrl }}"
                                            data-images="{{ json_encode($item->images->map(fn($i) => $i->image_url)->values()) }}"
                                            data-judul="{{ $item->judul }}"
                                            data-deskripsi="{{ $item->deskripsi }}"
                                            data-type="{{ $item->type }}"
                                            data-bg="{{ $item->background_color }}">Read</button>
                                        <button type="button" class="btn-action update js-galeri-update-btn"
                                            data-update-url="{{ route('admin.galeri.update', $item->id) }}"
                                            data-image="{{ $imageUrl }}"
                                            data-judul="{{ $item->judul }}"
                                            data-deskripsi="{{ $item->deskripsi }}"
                                            data-type="{{ $item->type }}"
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
                <select class="popup-input" id="createGaleriJudul" name="judul" required>
                    <option value="" disabled {{ old('judul') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                    @foreach (['Geolistrik 1D', 'Geolistrik 2D', 'Pumping Test', 'Borehole Camera', 'Logger'] as $opt)
                        <option value="{{ $opt }}" {{ old('judul') === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                    @endforeach
                </select>
                <select class="popup-input" name="type" id="createGaleriType">
                    <option value="foto" {{ old('type') === 'video' ? '' : 'selected' }}>Foto</option>
                    <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video</option>
                </select>
                <label class="popup-label-sm">Foto Utama</label>
                <input type="file" class="popup-input" id="createGaleriImage" name="image"
                    accept=".jpg,.jpeg,.png,.webp,image/*" required>
                <div class="upload-preview galeri-main-preview" id="createGaleriPreview"></div>
                <label class="popup-label-sm">Foto Tambahan <span style="font-weight:400;color:#888">(opsional)</span></label>
                <input type="file" class="popup-input galeri-extra-input" name="extra_images[]"
                    accept=".jpg,.jpeg,.png,.webp,image/*" multiple>
                <textarea class="popup-textarea" id="createGaleriDeskripsi" name="deskripsi"
                    placeholder="Deskripsi (opsional)">{{ old('deskripsi') }}</textarea>
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
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="readGaleriTitle">
            <h4 id="readGaleriTitle">Detail Galeri</h4>
            <div class="read-image" id="readGaleriImage"></div>
            <p class="read-meta"><strong id="readGaleriJudul">-</strong></p>
            <p class="read-meta" id="readGaleriType" style="margin-bottom:.4rem"></p>
            <p class="read-meta" id="readGaleriBgWrap" style="display:none">
                Background: <span class="color-swatch" id="readGaleriBgSwatch"></span>
                <span class="color-hex" id="readGaleriBgHex"></span>
            </p>
            <div class="read-description" id="readGaleriDeskripsi">-</div>
            <div class="popup-actions has-gap">
                <button type="button" class="btn-primary" data-close-overlay="readGaleriOverlay">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Popup: Update --}}
    <div class="popup-overlay" id="updateGaleriOverlay" aria-hidden="true">
        <div class="popup-card galeri-popup" role="dialog" aria-modal="true" aria-labelledby="updateGaleriTitle">
            <h4 id="updateGaleriTitle">Update Galeri</h4>
            <form method="POST" id="updateGaleriForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <select class="popup-input" id="updateGaleriJudul" name="judul" required>
                    <option value="" disabled>-- Pilih Kategori --</option>
                    @foreach (['Geolistrik 1D', 'Geolistrik 2D', 'Pumping Test', 'Borehole Camera', 'Logger'] as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
                <select class="popup-input" name="type" id="updateGaleriType">
                    <option value="foto">Foto</option>
                    <option value="video">Video</option>
                </select>
                <div class="upload-preview galeri-main-preview galeri-current-preview" id="updateGaleriCurrentPreview"></div>
                <label class="popup-label-sm">Ganti Foto Utama <span style="font-weight:400;color:#888">(opsional)</span></label>
                <input type="file" class="popup-input" id="updateGaleriImage" name="image"
                    accept=".jpg,.jpeg,.png,.webp,image/*">
                <div class="upload-preview galeri-main-preview" id="updateGaleriNewPreview"></div>
                <div id="updateGaleriExtraList" class="extra-images-list"></div>
                <label class="popup-label-sm">Tambah Foto Lagi <span style="font-weight:400;color:#888">(opsional)</span></label>
                <input type="file" class="popup-input galeri-extra-input" name="extra_images[]"
                    accept=".jpg,.jpeg,.png,.webp,image/*" multiple>
                <textarea class="popup-textarea" id="updateGaleriDeskripsi" name="deskripsi"
                    placeholder="Deskripsi (opsional)"></textarea>
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
    /* Tampilkan foto tambahan saat popup update dibuka */
    document.querySelectorAll('.js-galeri-update-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var listEl = document.getElementById('updateGaleriExtraList');
            if (!listEl) return;
            listEl.innerHTML = '';
            var extras = [];
            try { extras = JSON.parse(btn.dataset.extraImages || '[]'); } catch(e) {}
            extras.forEach(function (item) {
                var wrap = document.createElement('div');
                wrap.className = 'extra-img-item';

                var img = document.createElement('img');
                img.src = item.url;
                img.alt = 'foto tambahan';

                var del = document.createElement('button');
                del.type = 'button';
                del.className = 'extra-img-del';
                del.innerHTML = '&times;';
                del.title = 'Hapus foto ini';
                del.addEventListener('click', function () {
                    if (!confirm('Hapus foto tambahan ini?')) return;
                    var f = document.createElement('form');
                    f.method = 'POST';
                    f.action = item.delete_url;
                    f.innerHTML = '@csrf @method("DELETE")'.replace('@csrf','<input type="hidden" name="_token" value="{{ csrf_token() }}">').replace('@method("DELETE")','<input type="hidden" name="_method" value="DELETE">');
                    document.body.appendChild(f);
                    f.submit();
                });

                wrap.appendChild(img);
                wrap.appendChild(del);
                listEl.appendChild(wrap);
            });
        }, true); /* capture phase agar jalan sebelum handler lain */
    });
})();
</script>
@endpush

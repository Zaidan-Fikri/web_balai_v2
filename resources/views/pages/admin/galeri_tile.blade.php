@extends('master.admin.app')

@section('title', 'Admin Tile Landing Page')

@push('styles')
<style>
    .tile-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 8px;
    }
    .tile-card {
        border-radius: 14px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 2px 10px rgba(0,30,80,.08);
        border: 1px solid rgba(0,51,153,.08);
    }
    .tile-card-thumb {
        position: relative;
        aspect-ratio: 4/3;
        overflow: hidden;
    }
    .tile-card-thumb img {
        width: 100%; height: 100%;
        object-fit: cover; display: block;
    }
    .tile-card-placeholder {
        width: 100%; height: 100%;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center; gap: 6px;
    }
    .tile-card-placeholder i { font-size: 28px; color: rgba(255,255,255,.4); }
    .tile-card-placeholder span { font-size: 11px; color: rgba(255,255,255,.5); font-weight: 700; letter-spacing: .06em; }
    .tile-card-body {
        padding: 14px 16px 16px;
    }
    .tile-card-kategori {
        font-size: 13px; font-weight: 800;
        color: #0a1f44; margin: 0 0 12px;
    }
    .tile-card-meta {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 12px;
    }
    .color-swatch {
        display: inline-block; width: 18px; height: 18px;
        border-radius: 4px; border: 1px solid rgba(0,0,0,.15);
        flex-shrink: 0;
    }
    .color-hex { font-size: 12px; font-family: monospace; color: #666; }
    .tile-no-image { font-size: 11px; color: #aaa; font-style: italic; }

    .btn-secondary {
        display: inline-flex; align-items: center; justify-content: center;
        min-height: 36px; padding: 8px 16px;
        border: 1px solid rgba(0,51,153,.22); border-radius: 10px;
        background: #fff; color: var(--navy-dark);
        font-size: 13px; font-weight: 900; cursor: pointer;
        text-decoration: none;
        transition: transform .2s, background-color .2s, border-color .2s;
    }
    .btn-secondary:hover {
        background: var(--blue-light, #E8EEFF);
        border-color: rgba(0,71,204,.35);
        transform: translateY(-1px);
    }

    .color-picker-wrap { margin-top: 12px; margin-bottom: 4px; }
    .color-picker-label {
        display: block; font-size: 13px; font-weight: 700;
        color: var(--navy-dark); margin-bottom: 8px;
    }
    .color-picker-hint { font-weight: 400; font-size: 11px; color: #888; margin-left: 4px; }
    .color-picker-row { display: flex; align-items: center; gap: 10px; }
    .color-input {
        width: 48px; height: 38px; padding: 2px;
        border: 1px solid rgba(0,51,153,.2); border-radius: 8px;
        cursor: pointer; background: none;
    }
    .color-hex-live { font-size: 13px; font-family: monospace; color: #444; }
</style>
@endpush

@section('content')

    <section>
        <div class="panel full-card">
            <div class="thumbnail-head">
                <h3>Tile Galeri Landing Page</h3>
            </div>

            @if (session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="flash-error">{{ $errors->first() }}</div>
            @endif

            <p style="color:#666;font-size:13px;margin:0 0 20px">
                5 tile foto di bagian "Foto dan Video" pada landing page. Klik <strong>Ubah Foto</strong> untuk mengganti gambar masing-masing tile.
            </p>

            <div class="tile-grid">
                @foreach ($tiles as $tile)
                    <div class="tile-card">
                        <div class="tile-card-thumb"
                            style="background: {{ $tile->background_color ?? '#0d2d5e' }}">
                            @if ($tile->hasImage())
                                <img src="{{ $tile->image_url }}" alt="{{ $tile->kategori }}">
                            @else
                                <div class="tile-card-placeholder">
                                    <i class="fa-solid fa-image"></i>
                                    <span>Belum ada foto</span>
                                </div>
                            @endif
                        </div>
                        <div class="tile-card-body">
                            <p class="tile-card-kategori">{{ $tile->kategori }}</p>
                            @if ($tile->background_color)
                                <div class="tile-card-meta">
                                    <span class="color-swatch" style="background:{{ $tile->background_color }}"></span>
                                    <span class="color-hex">{{ $tile->background_color }}</span>
                                </div>
                            @endif
                            @if (!$tile->hasImage())
                                <p class="tile-no-image">Belum ada foto diunggah</p>
                            @endif
                            <button type="button" class="btn-primary js-tile-update-btn"
                                data-id="{{ $tile->id }}"
                                data-kategori="{{ $tile->kategori }}"
                                data-image="{{ $tile->hasImage() ? $tile->image_url : '' }}"
                                data-bg="{{ $tile->background_color ?? '#0d2d5e' }}"
                                data-update-url="{{ route('admin.galeri-tile.update', $tile->id) }}"
                                style="width:100%;margin-top:4px">
                                <i class="fa-solid fa-pen fa-xs"></i> Ubah Foto
                            </button>
                            @if ($tile->hasImage() || ($tile->background_color && $tile->background_color !== '#0d2d5e'))
                                <form method="POST"
                                    action="{{ route('admin.galeri-tile.destroy-image', $tile->id) }}"
                                    class="js-tile-delete-form"
                                    style="margin-top:8px">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-secondary"
                                        style="width:100%;color:#c0392b;border-color:rgba(192,57,43,.3)">
                                        <i class="fa-solid fa-trash fa-xs"></i> Hapus &amp; Reset
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Popup: Update Tile --}}
    <div class="popup-overlay" id="tileUpdateOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="tileUpdateTitle">
            <h4 id="tileUpdateTitle">Ubah Foto Tile</h4>
            <form method="POST" id="tileUpdateForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <p style="font-size:13px;color:#666;margin:0 0 14px" id="tileUpdateKategori"></p>
                <div class="upload-preview" id="tileUpdateCurrentPreview"></div>
                <input type="file" class="popup-input" id="tileUpdateImage" name="image"
                    accept=".jpg,.jpeg,.png,.webp,image/*">
                <div class="upload-preview" id="tileUpdateNewPreview"></div>
                <div class="color-picker-wrap">
                    <label class="color-picker-label" for="tileUpdateBg">
                        <i class="fa-solid fa-palette"></i> Warna Background
                        <span class="color-picker-hint">(tampil saat belum ada foto)</span>
                    </label>
                    <div class="color-picker-row">
                        <input type="color" class="color-input" id="tileUpdateBg" name="background_color" value="#0d2d5e">
                        <span class="color-hex-live" id="tileUpdateBgHex">#0d2d5e</span>
                    </div>
                </div>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Simpan</button>
                    <button type="button" class="btn-secondary" data-close-overlay="tileUpdateOverlay">Batal</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
(function () {
    var overlay     = document.getElementById('tileUpdateOverlay');
    var form        = document.getElementById('tileUpdateForm');
    var kategoriEl  = document.getElementById('tileUpdateKategori');
    var curPrev     = document.getElementById('tileUpdateCurrentPreview');
    var newPrev     = document.getElementById('tileUpdateNewPreview');
    var imageInput  = document.getElementById('tileUpdateImage');
    var bgColor     = document.getElementById('tileUpdateBg');
    var bgHex       = document.getElementById('tileUpdateBgHex');

    if (!overlay || !form) return;

    function openOverlay() { overlay.classList.add('is-open'); overlay.setAttribute('aria-hidden','false'); }
    function closeOverlay() { overlay.classList.remove('is-open'); overlay.setAttribute('aria-hidden','true'); }

    function renderPreview(container, file, fallbackUrl) {
        if (!container) return;
        container.innerHTML = '';
        if (file) {
            var url = URL.createObjectURL(file);
            container.innerHTML = '<img src="' + url + '" alt="Preview">';
            var img = container.querySelector('img');
            if (img) img.addEventListener('load', function () { URL.revokeObjectURL(url); });
            return;
        }
        if (fallbackUrl) {
            container.innerHTML = '<img src="' + fallbackUrl + '" alt="Foto tile">';
        } else {
            container.innerHTML = '<p class="read-meta thumb-empty">Belum ada gambar.</p>';
        }
    }

    document.querySelectorAll('.js-tile-update-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            form.action = btn.dataset.updateUrl;
            if (kategoriEl) kategoriEl.textContent = 'Kategori: ' + btn.dataset.kategori;
            if (imageInput) imageInput.value = '';
            var bg = btn.dataset.bg || '#0d2d5e';
            if (bgColor) { bgColor.value = bg; if (bgHex) bgHex.textContent = bg; }
            renderPreview(curPrev, null, btn.dataset.image || null);
            renderPreview(newPrev, null, null);
            openOverlay();
        });
    });

    if (imageInput) {
        imageInput.addEventListener('change', function () {
            renderPreview(newPrev, imageInput.files[0] || null, null);
        });
    }

    if (bgColor) {
        bgColor.addEventListener('input', function () {
            if (bgHex) bgHex.textContent = bgColor.value;
        });
    }

    overlay.addEventListener('click', function (e) { if (e.target === overlay) closeOverlay(); });

    document.querySelectorAll('[data-close-overlay]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var id = btn.getAttribute('data-close-overlay');
            if (id) { var el = document.getElementById(id); if (el) { el.classList.remove('is-open'); el.setAttribute('aria-hidden','true'); } }
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeOverlay();
    });

    document.querySelectorAll('.js-tile-delete-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!window.confirm('Hapus foto tile ini? Tile akan kembali tampil sebagai placeholder.')) {
                e.preventDefault();
            }
        });
    });
})();
</script>
@endpush

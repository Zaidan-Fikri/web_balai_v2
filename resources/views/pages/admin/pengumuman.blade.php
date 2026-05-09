@extends('master.admin.app')

@section('title', 'Admin Pengumuman')

@section('content')

    <section>
        <div class="panel full-card">
            <div class="page-head">
                <h3>Pengumuman</h3>
                <button type="button" class="btn-plus" id="openPopup" aria-label="Tambah pengumuman">+</button>
            </div>
            @if (session('success'))<div class="flash-success">{{ session('success') }}</div>@endif
            @if ($errors->any())<div class="flash-error">{{ $errors->first() }}</div>@endif

            <div class="table-wrap">
                <table class="item-table">
                    <thead><tr><th>Gambar</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($pengumumans as $item)
                        @php $imageUrl = asset('storage/' . $item->image_path); @endphp
                        <tr>
                            <td><div class="thumb-preview"><img src="{{ $imageUrl }}" alt="Pengumuman {{ $item->id }}"></div></td>
                            <td>
                                <div class="action-group">
                                    <button type="button" class="btn-action read js-read-btn" data-image="{{ $imageUrl }}">Read</button>
                                    <button type="button" class="btn-action update js-update-btn" data-update-url="{{ route('admin.pengumuman.update', $item->id) }}" data-image="{{ $imageUrl }}">Update</button>
                                    <form method="POST" action="{{ route('admin.pengumuman.destroy', $item->id) }}" class="js-delete-form">@csrf @method('DELETE')<button type="submit" class="btn-action delete">Delete</button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="2">Belum ada data pengumuman.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="popup-overlay" id="createOverlay" aria-hidden="true"><div class="popup-card"><h4>Tambah Pengumuman</h4><form method="POST" action="{{ route('admin.pengumuman.store') }}" enctype="multipart/form-data">@csrf<input type="hidden" name="form_type" value="create"><input type="file" class="popup-input" id="createInput" name="image" accept=".jpg,.jpeg,.png,.webp,image/*" required><div class="upload-preview" id="createPreview"></div><div class="popup-actions"><button type="submit" class="btn-primary">Tambah</button></div></form></div></div>
    <div class="popup-overlay" id="readOverlay" aria-hidden="true"><div class="popup-card"><h4>Detail Pengumuman</h4><div class="read-image" id="readImage"></div><div class="popup-actions" style="margin-top:12px;"><button type="button" class="btn-primary" data-close-overlay="readOverlay">Tutup</button></div></div></div>
    <div class="popup-overlay" id="updateOverlay" aria-hidden="true"><div class="popup-card"><h4>Update Pengumuman</h4><form method="POST" id="updateForm" enctype="multipart/form-data">@csrf @method('PUT')<div class="upload-preview" id="currentPreview"></div><input type="file" class="popup-input" id="updateInput" name="image" accept=".jpg,.jpeg,.png,.webp,image/*" required><div class="upload-preview" id="updatePreview"></div><div class="popup-actions"><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection

@push('scripts')
<script>
(function () {
            const openButton = document.getElementById('openPopup');
            const createOverlay = document.getElementById('createOverlay');
            const readOverlay = document.getElementById('readOverlay');
            const updateOverlay = document.getElementById('updateOverlay');
            const createInput = document.getElementById('createInput');
            const createPreview = document.getElementById('createPreview');
            const readImage = document.getElementById('readImage');
            const updateForm = document.getElementById('updateForm');
            const currentPreview = document.getElementById('currentPreview');
            const updateInput = document.getElementById('updateInput');
            const updatePreview = document.getElementById('updatePreview');
            if (!openButton || !createOverlay || !readOverlay || !updateOverlay) return;

            function openOverlay(el, focusTarget){ el.classList.add('is-open'); el.setAttribute('aria-hidden','false'); if(focusTarget){ setTimeout(function(){ focusTarget.focus(); },0);} }
            function closeOverlay(el){ el.classList.remove('is-open'); el.setAttribute('aria-hidden','true'); }
            function closeAllOverlays(){ document.querySelectorAll('.popup-overlay.is-open').forEach(function(el){ closeOverlay(el); }); }
            function renderPreview(container, file, fallbackUrl){
                if (!container) return;
                container.innerHTML = '';
                if (file) {
                    const url = URL.createObjectURL(file);
                    container.innerHTML = '<img src="' + url + '" alt="Preview">';
                    const img = container.querySelector('img');
                    if (img) img.addEventListener('load', function () { URL.revokeObjectURL(url); });
                    return;
                }
                if (fallbackUrl) container.innerHTML = '<img src="' + fallbackUrl + '" alt="Gambar">';
            }

            openButton.addEventListener('click', function () {
                createInput.value = '';
                renderPreview(createPreview, null, null);
                openOverlay(createOverlay, createInput);
            });

            createInput.addEventListener('change', function () {
                const file = createInput.files && createInput.files[0] ? createInput.files[0] : null;
                renderPreview(createPreview, file, null);
            });

            document.querySelectorAll('.js-read-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    readImage.innerHTML = '<img src="' + (btn.dataset.image || '') + '" alt="Detail pengumuman">';
                    openOverlay(readOverlay);
                });
            });

            document.querySelectorAll('.js-update-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    updateForm.action = btn.dataset.updateUrl || '';
                    updateInput.value = '';
                    renderPreview(currentPreview, null, btn.dataset.image || null);
                    renderPreview(updatePreview, null, null);
                    openOverlay(updateOverlay, updateInput);
                });
            });

            updateInput.addEventListener('change', function () {
                const file = updateInput.files && updateInput.files[0] ? updateInput.files[0] : null;
                renderPreview(updatePreview, file, null);
            });

            document.querySelectorAll('.js-delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!window.confirm('Hapus pengumuman ini?')) event.preventDefault();
                });
            });

            document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
                overlay.addEventListener('click', function (event) {
                    if (event.target === overlay) closeOverlay(overlay);
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
                if (event.key === 'Escape') closeAllOverlays();
            });

            @if ($errors->any() && old('form_type') === 'create')
                openOverlay(createOverlay, createInput);
            @endif
        })();
</script>
@endpush

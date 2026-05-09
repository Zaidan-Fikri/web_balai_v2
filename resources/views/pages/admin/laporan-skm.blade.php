@extends('master.admin.app')

@section('title', 'Admin Laporan SKM')

@section('content')

    <section>
        <div class="panel full-card">
            <div class="item-head">
                <h3>Laporan SKM</h3>
                <button type="button" class="btn-plus" id="openItemPopup" aria-label="Tambah Laporan SKM">+</button>
            </div>
            @if (session('success'))<div class="flash-success">{{ session('success') }}</div>@endif
            @if ($errors->any())<div class="flash-error">{{ $errors->first() }}</div>@endif

            <div class="table-wrap">
                <table class="item-table">
                    <thead>
                    <tr><th>Thumbnail</th><th>Judul</th><th>Deskripsi</th><th>Upload PDF</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                    @forelse ($laporanSkms as $item)
                        @php $thumbnailUrl = $item->thumbnail_path ? asset('storage/' . $item->thumbnail_path) : ''; $pdfUrl = asset('storage/' . $item->pdf_path); $pdfName = basename($item->pdf_path); @endphp
                        <tr>
                            <td>@if ($thumbnailUrl)<div class="thumb-box"><img src="{{ $thumbnailUrl }}" alt="Thumbnail {{ $item->judul }}"></div>@else - @endif</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->deskripsi, 120) }}</td>
                            <td><a class="pdf-link" href="{{ $pdfUrl }}" target="_blank" rel="noopener">{{ $pdfName }}</a></td>
                            <td>
                                <div class="action-group">
                                    <button type="button" class="btn-action read js-read-btn" data-judul="{{ $item->judul }}" data-deskripsi="{{ $item->deskripsi }}" data-thumbnail-url="{{ $thumbnailUrl }}" data-pdf-url="{{ $pdfUrl }}" data-pdf-name="{{ $pdfName }}">Read</button>
                                    <button type="button" class="btn-action update js-update-btn" data-update-url="{{ route('admin.laporan-skm.update', $item->id) }}" data-judul="{{ $item->judul }}" data-deskripsi="{{ $item->deskripsi }}" data-thumbnail-url="{{ $thumbnailUrl }}" data-pdf-url="{{ $pdfUrl }}" data-pdf-name="{{ $pdfName }}">Update</button>
                                    <form method="POST" action="{{ route('admin.laporan-skm.destroy', $item->id) }}" class="js-delete-form">@csrf @method('DELETE')<button type="submit" class="btn-action delete">Delete</button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Belum ada data laporan SKM.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="popup-overlay" id="createOverlay" aria-hidden="true"><div class="popup-card"><h4>Tambah Laporan SKM</h4><form method="POST" action="{{ route('admin.laporan-skm.store') }}" enctype="multipart/form-data">@csrf<input type="hidden" name="form_type" value="create"><input type="text" class="popup-input" id="createJudul" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul" required><textarea class="popup-textarea" name="deskripsi" placeholder="Masukkan deskripsi" required>{{ old('deskripsi') }}</textarea><input type="file" class="popup-input" name="thumbnail" accept=".jpg,.jpeg,.png,.webp,image/*" required><span class="popup-help">Thumbnail: JPG/JPEG/PNG/WEBP (maks 5MB).</span><input type="file" class="popup-input" name="pdf" accept=".pdf,application/pdf" required><span class="popup-help">Format file: PDF (maks 10MB).</span><div class="popup-actions"><button type="submit" class="btn-primary">Tambah</button></div></form></div></div>
    <div class="popup-overlay" id="readOverlay" aria-hidden="true"><div class="popup-card"><h4 id="readTitle">Detail Laporan SKM</h4><div class="read-thumb" id="readThumb"></div><p class="read-desc" id="readDesc"></p><p class="read-meta">PDF: <a class="pdf-link" id="readPdf" href="#" target="_blank" rel="noopener">-</a></p><div class="popup-actions"><button type="button" class="btn-primary" data-close-overlay="readOverlay">Tutup</button></div></div></div>
    <div class="popup-overlay" id="updateOverlay" aria-hidden="true"><div class="popup-card"><h4>Update Laporan SKM</h4><form method="POST" id="updateForm" enctype="multipart/form-data">@csrf @method('PUT')<input type="hidden" name="form_type" value="update"><input type="text" class="popup-input" id="updateJudul" name="judul" required><textarea class="popup-textarea" id="updateDeskripsi" name="deskripsi" required></textarea><p class="read-meta">Thumbnail saat ini:</p><div class="thumb-preview" id="updateCurrentThumb"></div><input type="file" class="popup-input" name="thumbnail" accept=".jpg,.jpeg,.png,.webp,image/*"><span class="popup-help">Kosongkan jika tidak ingin mengganti thumbnail.</span><p class="read-meta">PDF saat ini: <a class="pdf-link" id="updateCurrentPdf" href="#" target="_blank" rel="noopener">-</a></p><input type="file" class="popup-input" name="pdf" accept=".pdf,application/pdf"><span class="popup-help">Kosongkan jika tidak ingin mengganti PDF.</span><div class="popup-actions"><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection

@push('scripts')
<script>
(function () {
            const openButton = document.getElementById('openItemPopup');
            const createOverlay = document.getElementById('createOverlay');
            const createJudul = document.getElementById('createJudul');
            const readOverlay = document.getElementById('readOverlay');
            const readTitle = document.getElementById('readTitle');
            const readThumb = document.getElementById('readThumb');
            const readDesc = document.getElementById('readDesc');
            const readPdf = document.getElementById('readPdf');
            const updateOverlay = document.getElementById('updateOverlay');
            const updateForm = document.getElementById('updateForm');
            const updateJudul = document.getElementById('updateJudul');
            const updateDeskripsi = document.getElementById('updateDeskripsi');
            const updateCurrentThumb = document.getElementById('updateCurrentThumb');
            const updateCurrentPdf = document.getElementById('updateCurrentPdf');
            if (!openButton || !createOverlay) return;
            function openOverlay(el, focusTarget){ if(!el) return; el.classList.add('is-open'); el.setAttribute('aria-hidden','false'); if(focusTarget){ setTimeout(function(){focusTarget.focus();},0);} }
            function closeOverlay(el){ if(!el) return; el.classList.remove('is-open'); el.setAttribute('aria-hidden','true'); }
            function closeAll(){ document.querySelectorAll('.popup-overlay.is-open').forEach(function(el){ closeOverlay(el); }); }
            openButton.addEventListener('click', function(){ openOverlay(createOverlay, createJudul); });
            document.querySelectorAll('.js-read-btn').forEach(function(btn){ btn.addEventListener('click', function(){ readTitle.textContent = btn.dataset.judul || 'Detail Laporan SKM'; readThumb.innerHTML = btn.dataset.thumbnailUrl ? '<img src="'+btn.dataset.thumbnailUrl+'" alt="Thumbnail">' : '<p class="read-meta" style="margin:8px 10px;">Thumbnail belum tersedia.</p>'; readDesc.textContent = btn.dataset.deskripsi || '-'; readPdf.textContent = btn.dataset.pdfName || '-'; readPdf.href = btn.dataset.pdfUrl || '#'; openOverlay(readOverlay); }); });
            document.querySelectorAll('.js-update-btn').forEach(function(btn){ btn.addEventListener('click', function(){ updateForm.action = btn.dataset.updateUrl || ''; updateJudul.value = btn.dataset.judul || ''; updateDeskripsi.value = btn.dataset.deskripsi || ''; updateCurrentThumb.innerHTML = btn.dataset.thumbnailUrl ? '<img src="'+btn.dataset.thumbnailUrl+'" alt="Thumbnail saat ini">' : '<p class="read-meta" style="margin:8px 10px;">Thumbnail belum tersedia.</p>'; updateCurrentPdf.textContent = btn.dataset.pdfName || '-'; updateCurrentPdf.href = btn.dataset.pdfUrl || '#'; openOverlay(updateOverlay, updateJudul); }); });
            document.querySelectorAll('.js-delete-form').forEach(function(form){ form.addEventListener('submit', function(e){ if(!window.confirm('Hapus laporan SKM ini?')) e.preventDefault(); }); });
            document.querySelectorAll('.popup-overlay').forEach(function(overlay){ overlay.addEventListener('click', function(e){ if(e.target===overlay) closeOverlay(overlay); }); });
            document.querySelectorAll('[data-close-overlay]').forEach(function(btn){ btn.addEventListener('click', function(){ const id = btn.getAttribute('data-close-overlay'); if(id) closeOverlay(document.getElementById(id)); }); });
            document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeAll(); });
            @if ($errors->any() && old('form_type') === 'create') openOverlay(createOverlay, createJudul); @endif
        })();
</script>
@endpush

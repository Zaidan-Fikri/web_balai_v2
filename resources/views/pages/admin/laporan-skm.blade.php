@extends('master.admin.app')

@section('title', 'Admin Laporan SKM')

@section('content')
    <style>
        .item-head { display:flex; align-items:center; justify-content:space-between; gap:12px; width:100%; }
        .item-head h3 { margin:0; font-size:clamp(34px,7vw,40px); line-height:1.15; min-width:0; flex:1; }
        .btn-plus { width:44px; height:44px; border-radius:12px; border:1px solid #d9d9d9; background:#fff; font-size:30px; line-height:1; color:#14161b; cursor:pointer; transition:background-color .2s ease,color .2s ease,border-color .2s ease; }
        .btn-plus:hover { background:#111217; color:#fff; border-color:#111217; }
        .flash-success { margin:12px 0 0; border:1px solid #b8e2c3; background:#eaf9ee; color:#1f6b35; border-radius:10px; padding:10px 12px; font-size:14px; }
        .flash-error { margin:12px 0 0; border:1px solid #f3c2c2; background:#fff0f0; color:#9c2f2f; border-radius:10px; padding:10px 12px; font-size:14px; }
        .item-table { width:100%; table-layout:fixed; }
        .item-table th, .item-table td { white-space:normal; word-break:break-word; vertical-align:top; }
        .item-table th:nth-child(1), .item-table td:nth-child(1) { width:17%; }
        .item-table th:nth-child(2), .item-table td:nth-child(2) { width:22%; }
        .item-table th:nth-child(3), .item-table td:nth-child(3) { width:29%; }
        .item-table th:nth-child(4), .item-table td:nth-child(4) { width:15%; }
        .item-table th:nth-child(5), .item-table td:nth-child(5) { width:17%; }
        .thumb-box { width:min(100%,160px); border-radius:10px; border:1px solid #e0e0e0; overflow:hidden; background:#f7f7f7; }
        .thumb-box img { width:100%; aspect-ratio:16/10; object-fit:cover; display:block; }
        .thumb-preview { width:100%; border:1px solid #e4e4e4; border-radius:10px; overflow:hidden; background:#f8f8f8; margin-bottom:12px; }
        .thumb-preview img { width:100%; max-height:220px; object-fit:contain; display:block; background:#0f1b30; }
        .read-thumb { width:100%; border-radius:10px; border:1px solid #e0e0e0; overflow:hidden; background:#f7f7f7; margin-bottom:12px; }
        .read-thumb img { width:100%; max-height:280px; object-fit:contain; display:block; background:#0f1b30; }
        .pdf-link { font-weight:700; color:#1e4b95; text-decoration:none; }
        .action-group { display:flex; gap:6px; flex-wrap:wrap; white-space:nowrap; }
        .btn-action { border:1px solid #d2d2d2; background:#fff; color:#1a1a1a; border-radius:8px; padding:6px 10px; font-size:12px; font-weight:700; cursor:pointer; }
        .btn-action.read { border-color:#b9d2ff; background:#ecf3ff; color:#1e4b95; }
        .btn-action.update { border-color:#cde8cd; background:#ecf8ec; color:#1f6b35; }
        .btn-action.delete { border-color:#f2c6c6; background:#fff1f1; color:#a72c2c; }
        .popup-overlay { position:fixed; inset:0; background:rgba(10,12,18,0.45); display:none; align-items:center; justify-content:center; z-index:1400; padding:16px; }
        .popup-overlay.is-open { display:flex; }
        .popup-card { width:min(100%,560px); background:#fff; border:1px solid #e5e5e5; border-radius:14px; padding:18px; box-shadow:0 20px 40px rgba(17,18,23,0.18); max-height:88vh; overflow:auto; }
        .popup-card h4 { margin:0 0 12px; font-size:20px; line-height:1.2; }
        .popup-input { width:100%; border:1px solid #d4d4d4; border-radius:10px; padding:10px 12px; font:inherit; color:#161616; outline:none; margin-bottom:12px; }
        .popup-textarea { width:100%; min-height:120px; resize:vertical; border:1px solid #d4d4d4; border-radius:10px; padding:10px 12px; font:inherit; color:#161616; outline:none; margin-bottom:12px; }
        .popup-help { display:block; margin:-4px 0 10px; color:#666; font-size:12px; }
        .popup-actions { display:flex; justify-content:flex-end; gap:8px; }
        .btn-primary { border:1px solid #111217; background:#111217; color:#fff; border-radius:10px; padding:9px 16px; font:inherit; font-weight:600; cursor:pointer; }
        .read-meta { margin:0 0 10px; font-size:12px; color:#666; }
        .read-desc { margin:0 0 12px; color:#222; line-height:1.5; white-space:pre-wrap; word-break:break-word; }
    </style>

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
@endsection

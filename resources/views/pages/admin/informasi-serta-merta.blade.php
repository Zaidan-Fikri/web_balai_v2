@extends('master.admin.app')

@section('title', 'Admin Informasi Serta Merta')

@section('content')

    <section>
        <div class="panel full-card">
            <div class="item-head">
                <h3>Informasi Serta Merta</h3>
                <button type="button" class="btn-plus" id="openItemPopup" aria-label="Tambah Dokumen">+</button>
            </div>
            @if (session('success'))<div class="flash-success">{{ session('success') }}</div>@endif
            @if ($errors->any())<div class="flash-error">{{ $errors->first() }}</div>@endif

            <div class="table-wrap">
                <table class="item-table">
                    <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Judul</th>
                        <th>File PDF</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($items as $item)
                        @php
                            $pdfUrl  = asset('storage/' . $item->pdf_path);
                            $pdfName = basename($item->pdf_path);
                        @endphp
                        <tr>
                            <td>{{ $item->tahun }}</td>
                            <td>{{ $item->judul }}</td>
                            <td><a class="pdf-link" href="{{ $pdfUrl }}" target="_blank" rel="noopener">{{ $pdfName }}</a></td>
                            <td>
                                <div class="action-group">
                                    <button type="button" class="btn-action update js-update-btn"
                                        data-update-url="{{ route('admin.informasi-serta-merta.update', $item->id) }}"
                                        data-tahun="{{ $item->tahun }}"
                                        data-judul="{{ $item->judul }}"
                                        data-pdf-url="{{ $pdfUrl }}"
                                        data-pdf-name="{{ $pdfName }}">Update</button>
                                    <form method="POST" action="{{ route('admin.informasi-serta-merta.destroy', $item->id) }}" class="js-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Belum ada dokumen informasi serta merta.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Create Popup --}}
    <div class="popup-overlay" id="createOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4>Tambah Dokumen</h4>
            <form method="POST" action="{{ route('admin.informasi-serta-merta.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="number" class="popup-input" name="tahun" value="{{ old('tahun', date('Y')) }}" placeholder="Tahun (contoh: 2025)" min="2000" max="2100" required>
                <input type="text" class="popup-input" name="judul" value="{{ old('judul') }}" placeholder="Judul dokumen" required>
                <input type="file" class="popup-input" name="pdf" accept=".pdf,application/pdf" required>
                <span class="popup-help">Format: PDF (maks 10MB).</span>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Update Popup --}}
    <div class="popup-overlay" id="updateOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4>Update Dokumen</h4>
            <form method="POST" id="updateForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="number" class="popup-input" id="updateTahun" name="tahun" placeholder="Tahun" min="2000" max="2100" required>
                <input type="text" class="popup-input" id="updateJudul" name="judul" placeholder="Judul dokumen" required>
                <p class="read-meta">PDF saat ini: <a class="pdf-link" id="updateCurrentPdf" href="#" target="_blank" rel="noopener">-</a></p>
                <input type="file" class="popup-input" name="pdf" accept=".pdf,application/pdf">
                <span class="popup-help">Kosongkan jika tidak ingin mengganti PDF.</span>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
(function () {
    const createOverlay = document.getElementById('createOverlay');
    const updateOverlay = document.getElementById('updateOverlay');

    document.getElementById('openItemPopup').addEventListener('click', function () {
        createOverlay.setAttribute('aria-hidden', 'false');
        createOverlay.style.display = 'flex';
    });

    document.querySelectorAll('.js-update-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('updateForm').action = btn.dataset.updateUrl;
            document.getElementById('updateTahun').value = btn.dataset.tahun;
            document.getElementById('updateJudul').value = btn.dataset.judul;
            var pdfLink = document.getElementById('updateCurrentPdf');
            pdfLink.href        = btn.dataset.pdfUrl;
            pdfLink.textContent = btn.dataset.pdfName;
            updateOverlay.setAttribute('aria-hidden', 'false');
            updateOverlay.style.display = 'flex';
        });
    });

    document.querySelectorAll('.popup-overlay').forEach(function (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.setAttribute('aria-hidden', 'true');
                overlay.style.display = 'none';
            }
        });
    });

    document.querySelectorAll('.js-delete-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!confirm('Yakin ingin menghapus dokumen ini?')) { e.preventDefault(); }
        });
    });
}());
</script>
@endpush

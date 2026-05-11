@extends('master.admin.app')

@section('title', 'Admin Karya Ilmiah')

@section('content')

    <section>
        <div class="panel full-card">
            <div class="karya-head">
                <h3>Karya Ilmiah</h3>
                <button type="button" class="btn-plus" id="openKaryaPopup" aria-label="Tambah karya ilmiah">+</button>
            </div>

            @if (session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="flash-error">{{ $errors->first() }}</div>
            @endif

            <div class="table-wrap">
                <table class="karya-table">
                    <thead>
                    <tr>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Upload PDF</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($karyaIlmiahs as $karya)
                        @php
                            $thumbnailUrl = $karya->thumbnail_path ? asset('storage/' . $karya->thumbnail_path) : '';
                            $pdfUrl = asset('storage/' . $karya->pdf_path);
                            $pdfName = basename($karya->pdf_path);
                        @endphp
                        <tr>
                            <td>
                                @if ($thumbnailUrl)
                                    <div class="thumb-box">
                                        <img src="{{ $thumbnailUrl }}" alt="Thumbnail {{ $karya->judul }}">
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $karya->judul }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($karya->deskripsi, 120) }}</td>
                            <td>
                                <a class="pdf-link" href="{{ $pdfUrl }}" target="_blank" rel="noopener">{{ $pdfName }}</a>
                            </td>
                            <td>
                                <div class="action-group">
                                    <button
                                        type="button"
                                        class="btn-action read js-read-btn"
                                        data-judul="{{ $karya->judul }}"
                                        data-deskripsi="{{ $karya->deskripsi }}"
                                        data-thumbnail-url="{{ $thumbnailUrl }}"
                                        data-pdf-url="{{ $pdfUrl }}"
                                        data-pdf-name="{{ $pdfName }}"
                                    >Read</button>
                                    <button
                                        type="button"
                                        class="btn-action update js-update-btn"
                                        data-update-url="{{ route('admin.karya-ilmiah.update', $karya->id) }}"
                                        data-judul="{{ $karya->judul }}"
                                        data-deskripsi="{{ $karya->deskripsi }}"
                                        data-thumbnail-url="{{ $thumbnailUrl }}"
                                        data-pdf-url="{{ $pdfUrl }}"
                                        data-pdf-name="{{ $pdfName }}"
                                    >Update</button>
                                    <form method="POST" action="{{ route('admin.karya-ilmiah.destroy', $karya->id) }}" class="js-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada data karya ilmiah.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="popup-overlay" id="createKaryaOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="createKaryaTitle">
            <h4 id="createKaryaTitle">Tambah Karya Ilmiah</h4>
            <form method="POST" action="{{ route('admin.karya-ilmiah.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <input type="text" class="popup-input" id="createKaryaJudul" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul" required>
                <textarea class="popup-textarea" name="deskripsi" placeholder="Masukkan deskripsi" required>{{ old('deskripsi') }}</textarea>
                <input type="file" class="popup-input" name="thumbnail" accept=".jpg,.jpeg,.png,.webp,image/*" required>
                <span class="popup-help">Thumbnail: JPG/JPEG/PNG/WEBP (maks 5MB).</span>
                <input type="file" class="popup-input" name="pdf" accept=".pdf,application/pdf" required>
                <span class="popup-help">Format file: PDF (maks 10MB).</span>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="readKaryaOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="readKaryaTitle">
            <h4 id="readKaryaTitle">Detail Karya Ilmiah</h4>
            <div class="read-thumb" id="readKaryaThumb"></div>
            <p class="read-desc" id="readKaryaDesc"></p>
            <p class="read-meta">
                PDF: <a class="pdf-link" id="readKaryaPdf" href="#" target="_blank" rel="noopener">-</a>
            </p>
            <div class="popup-actions">
                <button type="button" class="btn-primary" data-close-overlay="readKaryaOverlay">Tutup</button>
            </div>
        </div>
    </div>

    <div class="popup-overlay" id="updateKaryaOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="updateKaryaTitle">
            <h4 id="updateKaryaTitle">Update Karya Ilmiah</h4>
            <form method="POST" id="updateKaryaForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="update">
                <input type="text" class="popup-input" id="updateKaryaJudul" name="judul" placeholder="Masukkan judul" required>
                <textarea class="popup-textarea" id="updateKaryaDeskripsi" name="deskripsi" placeholder="Masukkan deskripsi" required></textarea>
                <p class="read-meta">Thumbnail saat ini:</p>
                <div class="thumb-preview" id="updateKaryaCurrentThumb"></div>
                <input type="file" class="popup-input" name="thumbnail" accept=".jpg,.jpeg,.png,.webp,image/*">
                <span class="popup-help">Kosongkan jika tidak ingin mengganti thumbnail.</span>
                <p class="read-meta">
                    PDF saat ini: <a class="pdf-link" id="updateKaryaCurrentPdf" href="#" target="_blank" rel="noopener">-</a>
                </p>
                <input type="file" class="popup-input" name="pdf" accept=".pdf,application/pdf">
                <span class="popup-help">Kosongkan jika tidak ingin mengganti PDF.</span>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@extends('master.admin.app')

@section('title', 'Admin Edukasi')

@section('content')
    <section>
        <div class="panel full-card">
            <div class="berita-head">
                <div>
                    <p class="page-kicker">Publikasi</p>
                    <h3>Edukasi</h3>
                </div>
                <button type="button" class="btn-plus" id="openBuletinPopup" aria-label="Tambah edukasi">+</button>
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
                        <th>Status</th>
                        <th>Tanggal Publish</th>
                        <th>Views</th>
                        <th>User Posting</th>
                        <th>Gambar</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($buletins as $buletin)
                        @php
                            $imagePayload = $buletin->images
                                ->map(function ($image) {
                                    return [
                                        'id' => $image->id,
                                        'url' => asset('storage/' . $image->image_path),
                                    ];
                                })
                                ->values()
                                ->toJson();
                            $statusLabel = $buletin->status === \App\Models\Buletin::STATUS_PUBLISHED ? 'Publish' : 'Draft';
                            $statusClass = $buletin->status === \App\Models\Buletin::STATUS_PUBLISHED ? 'good' : 'warn';
                            $publishedValue = $buletin->published_at ? $buletin->published_at->format('Y-m-d\\TH:i') : '';
                        @endphp
                        <tr>
                            <td>{{ $buletin->judul }}</td>
                            <td><span class="status {{ $statusClass }}">{{ $statusLabel }}</span></td>
                            <td>{{ $buletin->published_at ? $buletin->published_at->format('d M, Y H:i') : '-' }}</td>
                            <td>{{ number_format($buletin->views) }}</td>
                            <td>{{ $buletin->author?->email ?? '-' }}</td>
                            <td>{{ $buletin->images->count() }}</td>
                            <td>
                                <div class="action-group">
                                    <button
                                        type="button"
                                        class="btn-action read js-buletin-read-btn"
                                        data-judul="{{ $buletin->judul }}"
                                        data-isi="{{ $buletin->isi }}"
                                        data-status="{{ $statusLabel }}"
                                        data-published="{{ $buletin->published_at ? $buletin->published_at->format('d M, Y H:i') : '-' }}"
                                        data-views="{{ number_format($buletin->views) }}"
                                        data-author="{{ $buletin->author?->email ?? '-' }}"
                                        data-images="{{ e($imagePayload) }}"
                                    >
                                        Read
                                    </button>
                                    <button
                                        type="button"
                                        class="btn-action update js-buletin-update-btn"
                                        data-id="{{ $buletin->id }}"
                                        data-judul="{{ $buletin->judul }}"
                                        data-isi="{{ $buletin->isi }}"
                                        data-status="{{ $buletin->status }}"
                                        data-published-value="{{ $publishedValue }}"
                                        data-update-url="{{ route('admin.buletin.update', $buletin->id) }}"
                                        data-images="{{ e($imagePayload) }}"
                                    >
                                        Update
                                    </button>
                                    <form method="POST" action="{{ route('admin.buletin.destroy', $buletin->id) }}" class="js-buletin-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Belum ada data edukasi.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="popup-overlay" id="buletinPopupOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="buletinPopupTitle">
            <h4 id="buletinPopupTitle">Tambah Edukasi</h4>
            <form method="POST" action="{{ route('admin.buletin.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <input type="text" class="popup-input" id="buletinPopupInput" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul edukasi" required>
                <textarea class="popup-textarea" name="isi" placeholder="Masukkan isi edukasi" required>{{ old('isi') }}</textarea>
                <select class="popup-input js-buletin-status" name="status" required>
                    <option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option>
                    <option value="published" @selected(old('status') === 'published')>Publish</option>
                </select>
                <input type="datetime-local" class="popup-input js-buletin-published-at" name="published_at" value="{{ old('published_at') }}">
                <span class="popup-help">Kosongkan tanggal publish jika ingin otomatis memakai waktu saat data dipublish.</span>
                <div class="image-input-list" id="createBuletinImageInputList"></div>
                <button type="button" class="btn-add-image-input" id="addCreateBuletinImageInput">+ Tambah Input Gambar</button>
                <div class="upload-preview-list" id="createBuletinUploadPreviewList"></div>
                <span class="popup-help">Upload 1 gambar per input. Tambah input jika gambar slideshow lebih dari 1.</span>
                <div class="popup-actions">
                    <button type="submit" class="btn-tambah">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="readBuletinOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="readBuletinTitle">
            <h4 id="readBuletinTitle">Detail Edukasi</h4>
            <p class="read-meta" id="readBuletinMeta">-</p>
            <div class="read-images" id="readBuletinImages"></div>
            <p class="read-desc" id="readBuletinIsi"></p>
            <div class="popup-actions has-gap">
                <button type="button" class="btn-tambah" data-close-overlay="readBuletinOverlay">Tutup</button>
            </div>
        </div>
    </div>

    <div class="popup-overlay" id="updateBuletinOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="updateBuletinTitle">
            <h4 id="updateBuletinTitle">Update Edukasi</h4>
            <form method="POST" id="updateBuletinForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="update">
                <input type="hidden" name="buletin_id" id="updateBuletinId">
                <input type="text" class="popup-input" id="updateBuletinJudul" name="judul" placeholder="Masukkan judul edukasi" required>
                <textarea class="popup-textarea" id="updateBuletinIsi" name="isi" placeholder="Masukkan isi edukasi" required></textarea>
                <select class="popup-input js-buletin-status" id="updateBuletinStatus" name="status" required>
                    <option value="draft">Draft</option>
                    <option value="published">Publish</option>
                </select>
                <input type="datetime-local" class="popup-input js-buletin-published-at" id="updateBuletinPublishedAt" name="published_at">
                <span class="popup-help">Tanggal publish hanya dipakai saat status Publish.</span>
                <div id="existingBuletinImageList" class="existing-image-list"></div>
                <div class="image-input-list" id="updateBuletinImageInputList"></div>
                <button type="button" class="btn-add-image-input" id="addUpdateBuletinImageInput">+ Tambah Input Gambar</button>
                <div class="upload-preview-list" id="updateBuletinUploadPreviewList"></div>
                <span class="popup-help">Upload 1 gambar per input untuk menambah gambar slideshow baru.</span>
                <div class="popup-actions">
                    <button type="submit" class="btn-tambah">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

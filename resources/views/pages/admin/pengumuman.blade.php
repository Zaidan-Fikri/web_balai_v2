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
    <div class="popup-overlay" id="readOverlay" aria-hidden="true"><div class="popup-card"><h4>Detail Pengumuman</h4><div class="read-image" id="readImage"></div><div class="popup-actions has-gap"><button type="button" class="btn-primary" data-close-overlay="readOverlay">Tutup</button></div></div></div>
    <div class="popup-overlay" id="updateOverlay" aria-hidden="true"><div class="popup-card"><h4>Update Pengumuman</h4><form method="POST" id="updateForm" enctype="multipart/form-data">@csrf @method('PUT')<div class="upload-preview" id="currentPreview"></div><input type="file" class="popup-input" id="updateInput" name="image" accept=".jpg,.jpeg,.png,.webp,image/*" required><div class="upload-preview" id="updatePreview"></div><div class="popup-actions"><button type="submit" class="btn-primary">Simpan</button></div></form></div></div>
@endsection

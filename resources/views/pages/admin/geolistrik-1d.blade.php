@extends('master.admin.app')

@section('title', 'Geolistrik 1D')

@section('content')

    <section>
        <div class="panel full-card">
            <div class="item-head">
                <h3>Geolistrik 1D</h3>
                <button type="button" class="btn-plus" id="openGeolistrikPopup" aria-label="Tambah Geolistrik 1D">+</button>
            </div>
            @if (session('success'))<div class="flash-success">{{ session('success') }}</div>@endif
            @if (session('error'))<div class="flash-error">{{ session('error') }}</div>@endif
            @if ($errors->any())<div class="flash-error">{{ $errors->first() }}</div>@endif

            <div class="table-wrap">
                <table class="item-table">
                    <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Tanggal</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($geolistrik1ds as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ number_format($item->latitude, 7, '.', '') }}</td>
                            <td>{{ number_format($item->longitude, 7, '.', '') }}</td>
                            <td>{{ $item->created_at ? $item->created_at->format('d M, Y H:i') : '-' }}</td>
                            <td>
                                <div class="action-group">
                                    <button
                                        type="button"
                                        class="btn-action read js-geolistrik-read-btn"
                                        data-nama="{{ $item->nama }}"
                                        data-latitude="{{ number_format($item->latitude, 7, '.', '') }}"
                                        data-longitude="{{ number_format($item->longitude, 7, '.', '') }}"
                                    >Read</button>
                                    <button
                                        type="button"
                                        class="btn-action update js-geolistrik-update-btn"
                                        data-update-url="{{ route('admin.geolistrik-1d.update', $item->id) }}"
                                        data-nama="{{ $item->nama }}"
                                        data-latitude="{{ number_format($item->latitude, 7, '.', '') }}"
                                        data-longitude="{{ number_format($item->longitude, 7, '.', '') }}"
                                    >Update</button>
                                    <form method="POST" action="{{ route('admin.geolistrik-1d.destroy', $item->id) }}" class="js-geolistrik-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Belum ada data Geolistrik 1D.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="popup-overlay" id="geolistrikCreateOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4>Tambah Geolistrik 1D</h4>
            <form method="POST" action="{{ route('admin.geolistrik-1d.store') }}">
                @csrf
                <input type="hidden" name="form_type" value="create">
                <input type="text" class="popup-input" id="createGeolistrikNama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lokasi" required>
                <input type="number" class="popup-input" name="latitude" value="{{ old('latitude') }}" placeholder="Latitude, contoh: -6.2088000" min="-11.2" max="6.2" step="0.0000001" required>
                <input type="number" class="popup-input" name="longitude" value="{{ old('longitude') }}" placeholder="Longitude, contoh: 106.8456000" min="94.6" max="141.1" step="0.0000001" required>
                <span class="popup-help">Koordinat dibatasi dalam wilayah Indonesia.</span>
                <div class="popup-actions"><button type="submit" class="btn-primary">Tambah</button></div>
            </form>
        </div>
    </div>

    <div class="popup-overlay" id="geolistrikReadOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4 id="readGeolistrikNama">Detail Geolistrik 1D</h4>
            <p class="read-meta">Latitude: <strong id="readGeolistrikLatitude">-</strong></p>
            <p class="read-meta">Longitude: <strong id="readGeolistrikLongitude">-</strong></p>
            <div class="popup-actions"><button type="button" class="btn-primary" data-close-overlay="geolistrikReadOverlay">Tutup</button></div>
        </div>
    </div>

    <div class="popup-overlay" id="geolistrikUpdateOverlay" aria-hidden="true">
        <div class="popup-card">
            <h4>Update Geolistrik 1D</h4>
            <form method="POST" id="geolistrikUpdateForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="form_type" value="update">
                <input type="text" class="popup-input" id="updateGeolistrikNama" name="nama" placeholder="Masukkan nama lokasi" required>
                <input type="number" class="popup-input" id="updateGeolistrikLatitude" name="latitude" placeholder="Latitude" min="-11.2" max="6.2" step="0.0000001" required>
                <input type="number" class="popup-input" id="updateGeolistrikLongitude" name="longitude" placeholder="Longitude" min="94.6" max="141.1" step="0.0000001" required>
                <span class="popup-help">Kosongkan tidak diperbolehkan karena marker peta membutuhkan koordinat.</span>
                <div class="popup-actions"><button type="submit" class="btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>
@endsection

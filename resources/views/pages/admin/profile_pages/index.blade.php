@extends('master.admin.app')

@section('title', 'Admin Profil')

@push('styles')
<style>
    .profile-admin-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: 11px 18px;
        border: 1px solid rgba(0, 51, 153, .22);
        border-radius: 14px;
        background: #fff;
        color: var(--navy-dark);
        font-size: 14px;
        font-weight: 900;
        cursor: pointer;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
    <section>
        <div class="panel full-card">
            <div class="page-head">
                <h3>Profil</h3>
                <button type="button" class="btn-plus" id="openProfileCreate" aria-label="Tambah halaman profil">+</button>
            </div>

            @if (session('success'))<div class="flash-success">{{ session('success') }}</div>@endif
            @if ($errors->any())<div class="flash-error">{{ $errors->first() }}</div>@endif

            <div class="table-wrap">
                <table class="item-table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Slug</th>
                            <th>Urutan</th>
                            <th>Konten</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($profilePages as $page)
                            <tr>
                                <td><p class="desc-text">{{ $page->title }}</p></td>
                                <td><p class="desc-text">{{ $page->slug }}</p></td>
                                <td><p class="desc-text">{{ $page->sort_order }}</p></td>
                                <td><p class="desc-text">{{ $page->content ? \Illuminate\Support\Str::limit(strip_tags($page->content), 90) : '-' }}</p></td>
                                <td>
                                    <div class="action-group">
                                        <a class="btn-action update" href="{{ route('admin.profile-pages.edit', $page) }}">Update</a>
                                        @unless ($page->isDefaultPage())
                                            <form method="POST" action="{{ route('admin.profile-pages.destroy', $page) }}" class="js-delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action delete">Delete</button>
                                            </form>
                                        @endunless
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5">Belum ada halaman profil.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="popup-overlay" id="profileCreateOverlay" aria-hidden="true">
        <div class="popup-card" role="dialog" aria-modal="true" aria-labelledby="profileCreateTitle">
            <h4 id="profileCreateTitle">Tambah Halaman Profil</h4>
            <form method="POST" action="{{ route('admin.profile-pages.store') }}">
                @csrf
                <input type="text" class="popup-input" name="title" value="{{ old('title') }}" placeholder="Judul" required>
                <input type="text" class="popup-input" name="slug" value="{{ old('slug') }}" placeholder="Slug (opsional)">
                <input type="number" class="popup-input" name="sort_order" value="{{ old('sort_order', 99) }}" placeholder="Urutan" min="0" max="999">
                <textarea class="popup-textarea" name="content" placeholder="Konten halaman">{{ old('content') }}</textarea>
                <div class="popup-actions">
                    <button type="submit" class="btn-primary">Tambah</button>
                    <button type="button" class="profile-admin-secondary" data-close-overlay="profileCreateOverlay">Batal</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function () {
    var openBtn = document.getElementById('openProfileCreate');
    var overlay = document.getElementById('profileCreateOverlay');
    if (!openBtn || !overlay) return;

    function closeOverlay() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
    }

    openBtn.addEventListener('click', function () {
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
    });

    overlay.addEventListener('click', function (event) {
        if (event.target === overlay) closeOverlay();
    });

    document.querySelectorAll('[data-close-overlay="profileCreateOverlay"]').forEach(function (button) {
        button.addEventListener('click', closeOverlay);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && overlay.classList.contains('is-open')) closeOverlay();
    });
})();
</script>
@endpush

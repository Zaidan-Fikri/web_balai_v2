@extends('master.admin.app')

@section('title', 'Manajemen Akun')

@section('content')
<section>
    <div class="panel full-card">
        <div class="berita-head">
            <div>
                <p class="page-kicker">Superadmin</p>
                <h3>Manajemen Akun</h3>
            </div>
            <button type="button" class="btn-plus" id="openCreatePopup" aria-label="Tambah akun">+</button>
        </div>

        @if (session('success'))
            <div class="flash-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="flash-error">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="flash-error">{{ $errors->first() }}</div>
        @endif

        <div class="table-wrap berita-table-wrap">
            <table class="berita-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        @php
                            $roleLabels = [
                                'superadmin'     => 'Superadmin',
                                'kompu'          => 'Komputerisasi',
                                'layanan_teknis' => 'Layanan Teknis',
                            ];
                            $roleLabel = $roleLabels[$user->role] ?? $user->role;
                        @endphp
                        <tr>
                            <td>{{ $user->name ?? '-' }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="status {{ $user->role === 'superadmin' ? 'bad' : ($user->role === 'layanan_teknis' ? 'warn' : 'good') }}">
                                    {{ $roleLabel }}
                                </span>
                            </td>
                            <td>
                                <span class="status {{ $user->is_active ? 'good' : 'bad' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</td>
                            <td>
                                <div class="action-group">
                                    <button
                                        type="button"
                                        class="btn-action update js-user-edit-btn"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ $user->role }}"
                                        data-update-url="{{ route('admin.users.update', $user) }}"
                                    >Edit</button>

                                    <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-action {{ $user->is_active ? 'delete' : 'read' }}">
                                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline"
                                          onsubmit="return confirm('Hapus akun {{ addslashes($user->email) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:2rem">Belum ada akun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- Create Popup --}}
<div class="popup-overlay" id="createPopupOverlay" aria-hidden="true">
    <div class="popup-card" role="dialog" aria-modal="true" style="max-width:480px">
        <h4>Tambah Akun Baru</h4>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <label class="popup-label-sm">Nama Lengkap</label>
            <input type="text" name="name" class="popup-input" placeholder="Nama lengkap" required>

            <label class="popup-label-sm">Email</label>
            <input type="email" name="email" class="popup-input" placeholder="email@example.com" required>

            <label class="popup-label-sm">Password</label>
            <input type="password" name="password" class="popup-input" placeholder="Minimal 8 karakter" required>

            <label class="popup-label-sm">Role</label>
            <select name="role" class="popup-input" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->label }}</option>
                @endforeach
                <option value="superadmin">Superadmin</option>
            </select>

            <div class="popup-actions has-gap">
                <button type="submit" class="btn-primary">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Popup --}}
<div class="popup-overlay" id="editPopupOverlay" aria-hidden="true">
    <div class="popup-card" role="dialog" aria-modal="true" style="max-width:480px">
        <h4>Edit Akun</h4>
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')

            <label class="popup-label-sm">Nama Lengkap</label>
            <input type="text" name="name" id="editName" class="popup-input" required>

            <label class="popup-label-sm">Email</label>
            <input type="email" name="email" id="editEmail" class="popup-input" required>

            <label class="popup-label-sm">Password Baru</label>
            <input type="password" name="password" class="popup-input" placeholder="Kosongkan jika tidak diubah">
            <span class="popup-help">Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.</span>

            <label class="popup-label-sm">Role</label>
            <select name="role" id="editRole" class="popup-input" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->label }}</option>
                @endforeach
                <option value="superadmin">Superadmin</option>
            </select>

            <div class="popup-actions has-gap">
                <button type="submit" class="btn-primary">Perbarui Akun</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const createOverlay = document.getElementById('createPopupOverlay');
    document.getElementById('openCreatePopup').addEventListener('click', () => {
        createOverlay.style.display = 'flex';
        createOverlay.setAttribute('aria-hidden', 'false');
    });
    createOverlay.addEventListener('click', e => {
        if (e.target === createOverlay) {
            createOverlay.style.display = 'none';
            createOverlay.setAttribute('aria-hidden', 'true');
        }
    });

    const editOverlay = document.getElementById('editPopupOverlay');
    editOverlay.addEventListener('click', e => {
        if (e.target === editOverlay) {
            editOverlay.style.display = 'none';
            editOverlay.setAttribute('aria-hidden', 'true');
        }
    });

    document.querySelectorAll('.js-user-edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editName').value  = btn.dataset.name  ?? '';
            document.getElementById('editEmail').value = btn.dataset.email ?? '';
            document.getElementById('editRole').value  = btn.dataset.role  ?? 'kompu';
            document.getElementById('editUserForm').action = btn.dataset.updateUrl;
            editOverlay.style.display = 'flex';
            editOverlay.setAttribute('aria-hidden', 'false');
        });
    });
</script>
@endpush
@endsection

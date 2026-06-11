@extends('master.admin.app')

@section('title', 'Manajemen Role')

@section('content')
<section>
    <div class="panel full-card">
        <div class="berita-head">
            <div>
                <p class="page-kicker">Superadmin</p>
                <h3>Manajemen Role</h3>
            </div>
            <button type="button" class="btn-plus" id="openCreateRolePopup" aria-label="Tambah role">+</button>
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
                        <th>Nama Role</th>
                        <th>Label</th>
                        <th>Akses Menu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td><code>{{ $role->name }}</code></td>
                            <td>{{ $role->label }}</td>
                            <td>
                                @forelse ($role->permissions ?? [] as $perm)
                                    <span style="display:inline-block;background:#e8f0fe;color:#0047cc;border-radius:999px;padding:2px 9px;font-size:.72rem;font-weight:700;margin:2px 2px 2px 0">
                                        {{ $menuKeys[$perm] ?? $perm }}
                                    </span>
                                @empty
                                    <span style="color:#aaa;font-size:.8rem">-</span>
                                @endforelse
                            </td>
                            <td>
                                <div class="action-group">
                                    <button
                                        type="button"
                                        class="btn-action update js-role-edit-btn"
                                        data-id="{{ $role->id }}"
                                        data-label="{{ $role->label }}"
                                        data-permissions="{{ json_encode($role->permissions ?? []) }}"
                                        data-update-url="{{ route('admin.roles.update', $role) }}"
                                    >Edit</button>
                                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display:inline"
                                          onsubmit="return confirm('Hapus role {{ addslashes($role->label) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center;padding:2rem;color:#aaa">Belum ada role.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- Create Popup --}}
<div class="popup-overlay" id="createRoleOverlay" aria-hidden="true">
    <div class="popup-card" style="max-width:520px" role="dialog" aria-modal="true">
        <h4>Tambah Role Baru</h4>
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <label class="popup-label-sm">Nama Role <small style="color:#aaa;font-weight:500">(huruf kecil, angka, underscore)</small></label>
            <input type="text" name="name" class="popup-input" placeholder="contoh: humas" pattern="[a-z0-9_]+" required>

            <label class="popup-label-sm">Label (nama tampilan)</label>
            <input type="text" name="label" class="popup-input" placeholder="contoh: Humas" required>

            <label class="popup-label-sm">Akses Menu</label>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px 16px;margin-bottom:16px">
                @foreach ($menuKeys as $key => $label)
                    <label style="display:flex;align-items:center;gap:8px;font-size:.85rem;font-weight:600;cursor:pointer">
                        <input type="checkbox" name="permissions[]" value="{{ $key }}" style="width:15px;height:15px;accent-color:#0047cc">
                        {{ $label }}
                    </label>
                @endforeach
            </div>

            <div class="popup-actions">
                <button type="submit" class="btn-primary">Simpan Role</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Popup --}}
<div class="popup-overlay" id="editRoleOverlay" aria-hidden="true">
    <div class="popup-card" style="max-width:520px" role="dialog" aria-modal="true">
        <h4>Edit Role</h4>
        <form id="editRoleForm" method="POST">
            @csrf
            @method('PUT')

            <label class="popup-label-sm">Label (nama tampilan)</label>
            <input type="text" name="label" id="editRoleLabel" class="popup-input" required>

            <label class="popup-label-sm">Akses Menu</label>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px 16px;margin-bottom:16px" id="editRolePermissions">
                @foreach ($menuKeys as $key => $label)
                    <label style="display:flex;align-items:center;gap:8px;font-size:.85rem;font-weight:600;cursor:pointer">
                        <input type="checkbox" name="permissions[]" value="{{ $key }}"
                               class="js-edit-perm-check" style="width:15px;height:15px;accent-color:#0047cc">
                        {{ $label }}
                    </label>
                @endforeach
            </div>

            <div class="popup-actions">
                <button type="submit" class="btn-primary">Perbarui Role</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const createOverlay = document.getElementById('createRoleOverlay');
    document.getElementById('openCreateRolePopup').addEventListener('click', () => {
        createOverlay.style.display = 'flex';
        createOverlay.setAttribute('aria-hidden', 'false');
    });
    createOverlay.addEventListener('click', e => {
        if (e.target === createOverlay) { createOverlay.style.display = 'none'; createOverlay.setAttribute('aria-hidden', 'true'); }
    });

    const editOverlay = document.getElementById('editRoleOverlay');
    editOverlay.addEventListener('click', e => {
        if (e.target === editOverlay) { editOverlay.style.display = 'none'; editOverlay.setAttribute('aria-hidden', 'true'); }
    });

    document.querySelectorAll('.js-role-edit-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editRoleLabel').value = btn.dataset.label ?? '';
            document.getElementById('editRoleForm').action = btn.dataset.updateUrl;

            const perms = JSON.parse(btn.dataset.permissions || '[]');
            document.querySelectorAll('.js-edit-perm-check').forEach(cb => {
                cb.checked = perms.includes(cb.value);
            });

            editOverlay.style.display = 'flex';
            editOverlay.setAttribute('aria-hidden', 'false');
        });
    });
</script>
@endpush
@endsection

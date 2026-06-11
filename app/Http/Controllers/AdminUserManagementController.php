<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserManagementController extends Controller
{
    public function index(): View
    {
        $users = AdminUser::orderBy('name')->orderBy('email')->get();
        $roles = Role::orderBy('label')->get();
        return view('pages.admin.users', compact('users', 'roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:admin_users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'string', 'in:superadmin,' . Role::orderBy('name')->pluck('name')->implode(',')],
        ]);

        AdminUser::create($data);

        return back()->with('success', 'Akun berhasil dibuat.');
    }

    public function update(Request $request, AdminUser $user): RedirectResponse
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:admin_users,email,' . $user->id],
            'role'  => ['required', 'string', 'in:superadmin,' . Role::orderBy('name')->pluck('name')->implode(',')],
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['string', 'min:8']]);
            $data['password'] = $request->password;
        }

        $user->update($data);

        return back()->with('success', 'Akun berhasil diperbarui.');
    }

    public function toggleActive(AdminUser $user): RedirectResponse
    {
        $currentId = session('admin_user_id');
        if ($user->id == $currentId) {
            return back()->with('error', 'Tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', $user->is_active ? 'Akun diaktifkan.' : 'Akun dinonaktifkan.');
    }

    public function destroy(AdminUser $user): RedirectResponse
    {
        $currentId = session('admin_user_id');
        if ($user->id == $currentId) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('success', 'Akun berhasil dihapus.');
    }
}

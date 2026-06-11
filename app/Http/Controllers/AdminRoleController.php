<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminRoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::orderBy('label')->get();
        $menuKeys = Role::allMenuKeys();
        return view('pages.admin.roles', compact('roles', 'menuKeys'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:50', 'unique:roles,name', 'regex:/^[a-z0-9_]+$/'],
            'label'       => ['required', 'string', 'max:100'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'in:' . implode(',', array_keys(Role::allMenuKeys()))],
        ]);

        Role::create([
            'name'        => $data['name'],
            'label'       => $data['label'],
            'permissions' => $data['permissions'] ?? [],
        ]);

        return back()->with('success', 'Role berhasil dibuat.');
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $data = $request->validate([
            'label'       => ['required', 'string', 'max:100'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', 'in:' . implode(',', array_keys(Role::allMenuKeys()))],
        ]);

        $role->update([
            'label'       => $data['label'],
            'permissions' => $data['permissions'] ?? [],
        ]);

        return back()->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();
        return back()->with('success', 'Role berhasil dihapus.');
    }
}

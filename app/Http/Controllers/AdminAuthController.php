<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AdminLoginRequest;
use App\Models\AdminUser;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (session()->has('admin_user_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('pages.auth.login');
    }

    public function login(AdminLoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $user = AdminUser::query()
            ->where('email', $credentials['email'])
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->withInput($request->only('email'));
        }

        if (! $user->is_active) {
            return back()
                ->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi superadmin.'])
                ->withInput($request->only('email'));
        }

        $permissions = [];
        if ($user->role !== 'superadmin') {
            $roleModel = Role::where('name', $user->role)->first();
            $permissions = $roleModel?->permissions ?? [];
        }

        $request->session()->regenerate();
        $request->session()->put('admin_user_id', $user->id);
        $request->session()->put('admin_user_email', $user->email);
        $request->session()->put('admin_user_role', $user->role);
        $request->session()->put('admin_user_permissions', $permissions);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['admin_user_id', 'admin_user_email', 'admin_user_role', 'admin_user_permissions']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

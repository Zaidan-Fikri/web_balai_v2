<?php

namespace App\Http\Middleware;

use App\Models\AdminUser;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthenticated
{
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (! $request->session()->has('admin_user_id')) {
            return redirect()->route('login');
        }

        if (! $request->session()->has('admin_user_role')) {
            $adminUser = AdminUser::query()->find($request->session()->get('admin_user_id'));

            if (! $adminUser) {
                $request->session()->forget(['admin_user_id', 'admin_user_email', 'admin_user_role']);

                return redirect()->route('login');
            }

            $request->session()->put('admin_user_role', $adminUser->role);
        }

        return $next($request);
    }
}

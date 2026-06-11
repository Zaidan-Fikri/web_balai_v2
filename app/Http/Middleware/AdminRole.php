<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminRole
{
    public function handle(Request $request, Closure $next, string ...$requiredKeys): Response|RedirectResponse
    {
        $role = $request->session()->get('admin_user_role');

        if ($role === 'superadmin') {
            return $next($request);
        }

        $permissions = $request->session()->get('admin_user_permissions', []);

        foreach ($requiredKeys as $key) {
            if (in_array($key, $permissions, true)) {
                return $next($request);
            }
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('error', 'Anda tidak memiliki akses ke menu tersebut.');
    }
}

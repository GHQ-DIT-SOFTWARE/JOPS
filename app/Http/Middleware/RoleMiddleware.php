<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Auto-login superadmin if not authenticated
        if (!Auth::check()) {
            $superadmin = User::where('role', User::ROLE_SUPERADMIN)->first();
            
            if ($superadmin) {
                Auth::login($superadmin);
            } else {
                return redirect()->route('login');
            }
        }

        $user = Auth::user();

        // Superadmin has access to everything
        if ($user->role == User::ROLE_SUPERADMIN) {
            return $next($request);
        }

        // Check role access for other users
        if ((int)$user->role !== (int)$role) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
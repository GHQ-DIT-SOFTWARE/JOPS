<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ((int)$user->is_role !== (int)$role) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
           if (Auth::guard($guard)->check()) {
    $user = Auth::user();

    switch ($user->is_role) {
        case \App\Models\User::ROLE_SUPERADMIN:
            return redirect()->route('superadmin.dashboard');
        case \App\Models\User::ROLE_DG:
            return redirect()->route('dg.dashboard');
        case \App\Models\User::ROLE_DLAND:
            return redirect()->route('dland.dashboard');
        case \App\Models\User::ROLE_DADMIN:
            return redirect()->route('dadmin.dashboard');
        case \App\Models\User::ROLE_DOFFR:
            return redirect()->route('doffr.dashboard');
        case \App\Models\User::ROLE_DCLERK:
            return redirect()->route('dclerk.dashboard');
        case \App\Models\User::ROLE_DWO:
            return redirect()->route('dwo.dashboard');
        case \App\Models\User::ROLE_DDRIVER:
            return redirect()->route('ddriver.dashboard');
        case \App\Models\User::ROLE_DRADIO:
            return redirect()->route('dradio.dashboard');
        default:
            return redirect('/'); // fallback
    }
}

        }

        return $next($request);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function Login(Request $request)
{
    $request->validate([
        'service_no' => 'required|string',
        'password'   => 'required|string',
    ]);

    $service_no = $request->service_no;
    $password   = $request->password;

    Log::info('Login attempt', [
        'service_no' => $service_no,
        'ip'         => $request->ip()
    ]);

    // Try to find user by service number
    $user = User::where('service_no', $service_no)->first();

    if (!$user) {
        Log::warning('User not found', ['service_no' => $service_no]);
        return redirect()->route('login')->withErrors(['error' => 'Invalid credentials.']);
    }

    // Debug: Check if user has password
    Log::info('User password status', [
        'has_password' => !empty($user->password),
        'password_hash' => $user->password
    ]);

    // Manual password check for debugging
    if (!empty($user->password)) {
        $isPasswordCorrect = Hash::check($password, $user->password);
        Log::info('Manual password check', ['matches' => $isPasswordCorrect]);
        
        if ($isPasswordCorrect) {
            // Manually log the user in
            Auth::login($user);
            
            // Log successful login
            DB::table('activity_logs')->insert([
                'uuid'        => Str::uuid(),
                'name'        => $user->fname,
                'service_no'  => $user->service_no,
                'description' => 'has logged in as ' . $user->roleName(),
                'date_time'   => now(),
            ]);

            return $this->redirectUserByRole($user);
        }
    }

    Log::warning('Login failed', ['service_no' => $service_no]);
    return redirect()->route('login')->withErrors(['error' => 'Invalid credentials.']);
}

    public function Logout()
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('warning', 'You are not logged in.');
        }

        $user = Auth::user();
        $now  = Carbon::now()->toDateTimeString();

        DB::table('activity_logs')->insert([
            'uuid'        => Str::uuid(),
            'name'        => $user->fname ?? $user->name ?? 'Unknown',
            'service_no'  => $user->service_no ?? null,
            'description' => 'has logged out as ' . ($user->roleName() ?? 'user'),
            'date_time'   => $now,
        ]);

        Auth::logout();

        return redirect()->route('login')->with('success', 'User logged out successfully.');
    }

    protected function redirectUserByRole(User $user)
    {
        switch ($user->is_role) {
            case User::ROLE_SUPERADMIN: return redirect()->route('superadmin.dashboard');
            case User::ROLE_DG:         return redirect()->route('dg.dashboard');
            case User::ROLE_DLAND:      return redirect()->route('dland.dashboard');
            case User::ROLE_DADMIN:     return redirect()->route('dadmin.dashboard');
            case User::ROLE_DOFFR:      return redirect()->route('doffr.dashboard');
            case User::ROLE_DCLERK:     return redirect()->route('dclerk.dashboard');
            case User::ROLE_DWO:        return redirect()->route('dwo.dashboard');
            case User::ROLE_DDRIVER:    return redirect()->route('ddriver.dashboard');
            case User::ROLE_DRADIO:     return redirect()->route('dradio.dashboard');
            default:                    return redirect()->route('dashboard'); // fallback
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Carbon\Carbon;
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
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Try to find user by service number
        $user = User::where('service_no', $service_no)->first();

        if (!$user) {
            Log::warning('User not found', ['service_no' => $service_no]);
            
            // Log failed login attempt
            ActivityLog::create([
                'service_no' => $service_no,
                'action' => 'login_failed',
                'description' => "Failed login attempt - user not found",
                'details' => json_encode([
                    'attempted_service_no' => $service_no,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent()
                ]),
                'date_time' => now(),
                'ip_address' => $request->ip()
            ]);
            
            return redirect()->route('login')->withErrors(['error' => 'Invalid credentials.']);
        }

        // Debug: Check if user has password
        Log::info('User password status', [
            'has_password' => !empty($user->password),
            'user_id' => $user->id,
            'service_no' => $user->service_no
        ]);

        // Manual password check for debugging
        if (!empty($user->password)) {
            $isPasswordCorrect = Hash::check($password, $user->password);
            Log::info('Manual password check', ['matches' => $isPasswordCorrect]);
            
            if ($isPasswordCorrect) {
                // Manually log the user in
                Auth::login($user);
                
                // Log successful login using ActivityLog model
                ActivityLog::create([
                    'user_id' => $user->id,
                    'service_no' => $user->service_no,
                    'name' => $user->fname,
                    'action' => 'logged_in',
                    'description' => "has logged in as " . $user->roleName(),
                    'details' => json_encode([
                        'login_method' => 'password',
                        'login_time' => now()->toDateTimeString(),
                        'user_agent' => $request->userAgent(),
                        'session_id' => session()->getId()
                    ]),
                    'date_time' => now(),
                    'ip_address' => $request->ip()
                ]);

                return $this->redirectUserByRole($user);
            }
        }

        // Log failed password attempt
        ActivityLog::create([
            'user_id' => $user->id,
            'service_no' => $user->service_no,
            'name' => $user->fname,
            'action' => 'login_failed',
            'description' => "Failed login attempt - incorrect password",
            'details' => json_encode([
                'attempted_service_no' => $service_no,
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]),
            'date_time' => now(),
            'ip_address' => $request->ip()
        ]);

        Log::warning('Login failed', ['service_no' => $service_no]);
        return redirect()->route('login')->withErrors(['error' => 'Invalid credentials.']);
    }

    public function Logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'You are not logged in.');
        }

        $user = Auth::user();
        
        // Log logout activity
        ActivityLog::create([
            'user_id' => $user->id,
            'service_no' => $user->service_no,
            'name' => $user->fname,
            'action' => 'logged_out',
            'description' => "has logged out as " . $user->roleName(),
            'details' => json_encode([
                'logout_time' => now()->toDateTimeString(),
                'session_id' => session()->getId(),
                'user_agent' => $request->userAgent()
            ]),
            'date_time' => now(),
            'ip_address' => $request->ip()
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

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
            default:                    return redirect()->route('dashboard');
        }
    }
}
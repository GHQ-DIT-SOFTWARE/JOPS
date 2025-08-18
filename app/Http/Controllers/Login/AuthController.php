<?php

declare(strict_types=1);

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        $request->validate([
            'service_no' => 'required|string',
            'password' => 'required|string',
        ]);

        $service_no = $request->service_no;
        $password = $request->password;
        $now = Carbon::now();
        $todayDate = $now->toDateTimeString();

        if (Auth::attempt(['service_no' => $service_no, 'password' => $password])) {
            $user = Auth::user();

            // Log activity
            $activityLog = [
                'uuid' => Str::uuid(),
                'name' => $user->fname, // changed from name to fname
                'service_no' => $user->service_no,
                'description' => 'has logged in as ' . $user->roleName(),
                'date_time' => $todayDate,
            ];
            DB::table('activity_logs')->insert($activityLog);

            // Redirect based on role
            return $this->redirectUserByRole($user);
        }

        return redirect()->route('login')->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }

   public function Logout()
{
    if (! Auth::check()) {
        // Nothing to log — redirect to login
        return redirect()->route('login')->with('warning', 'You are not logged in.');
    }

    $user = Auth::user();
    $now = Carbon::now()->toDateTimeString();

    $activityLog = [
        'uuid'        => Str::uuid(),
        'name'        => $user->fname ?? $user->name ?? 'Unknown',
        'service_no'  => $user->service_no ?? null,
        'description' => 'has logged out as ' . ($user->roleName() ?? 'user'),
        'date_time'   => $now,
    ];

    DB::table('activity_logs')->insert($activityLog);

    Auth::logout();

    return redirect()->route('login')->with('success', 'User logged out successfully.');
}
    /**
     * Redirect user based on role.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectUserByRole(User $user)
    {
        switch ($user->is_role) {
            case User::ROLE_SUPPERADMIN:
                return redirect()->route('superadmin.dashboard');

            case User::ROLE_DG:
                return redirect()->route('dg.dashboard');

            case User::ROLE_DLAND:
                return redirect()->route('dland.dashboard');

            case User::ROLE_DADMIN:
                return redirect()->route('dadmin.dashboard');

            case User::ROLE_DOFFR:
                return redirect()->route('doffr.dashboard');

            case User::ROLE_DCLERK:
                return redirect()->route('dclerk.dashboard');

            case User::ROLE_DWO:
                return redirect()->route('dwo.dashboard');

            case User::ROLE_DDRIVER:
                return redirect()->route('ddriver.dashboard');

            case User::ROLE_DRADIO:
                return redirect()->route('dradio.dashboard');

            default:
                return redirect()->route('dashboard'); // fallback
        }
    }
}

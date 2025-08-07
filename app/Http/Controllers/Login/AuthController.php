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
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $email = $request->email;
        $password = $request->password;
        $now = Carbon::now();
        $todayDate = $now->toDateTimeString();
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $activityLog = [
                'uuid' => Str::uuid(),
                'name' => $user->name,
                'email' => $user->email,
                'description' => 'has logged in',
                'date_time' => $todayDate,
            ];
            DB::table('activity_logs')->insert($activityLog);
            return redirect()->intended('dashboard');
        }
        return redirect()->route('login')->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }

    public function Logout()
    {
        $user = Auth::user();
        $name = $user->name;
        $email = $user->email;
        $dt = Carbon::now();
        $todayDate = $dt->toDateTimeString();
        $activityLog = [
            'uuid' => Str::uuid(),
            'name' => $name,
            'email' => $email,
            'description' => 'has logged out',
            'date_time' => $todayDate,
        ];
        DB::table('activity_logs')->insert($activityLog);
        Auth::logout();
        return redirect()->route('login')->with('success', 'User Logout Successfully');
    }
}

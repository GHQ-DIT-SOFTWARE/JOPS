<?php
// app/Http/Controllers/DclerkController.php
namespace App\Http\Controllers;

use App\Models\DutyOfficerAccount;
use App\Models\User;
use App\Models\DutyRoster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DclerkController extends Controller
{
    /**
     * Display D Clerk dashboard
     */
    public function dashboard()
    {
        $nav_title = "Duty Clerk Dashboard";
        if (!Auth::user()->canCreateAccounts()) {
            abort(403, 'Unauthorized access.');
        }
        
        $month = date('m');
        $year = date('Y');
        $dutyMonth = "$year-$month-01";
        
        // Get account statistics
        $accountStatus = (object) [
    'total' => DutyOfficerAccount::where('duty_month', $dutyMonth)->count(),
    'needed' => DutyOfficerAccount::where('duty_month', $dutyMonth)
                 ->where('needs_account', true)
                 ->where('account_created', false)
                 ->count(),
    'created' => DutyOfficerAccount::where('duty_month', $dutyMonth)
                  ->where('account_created', true)
                  ->count(),
];

        
        // Get recent account activity
        $recentActivity = DutyOfficerAccount::with(['user', 'creator'])
                            ->where('duty_month', $dutyMonth)
                            ->orderBy('created_at', 'desc')
                            ->take(10)
                            ->get();
        
        // Get roster status
        $rosterStatus = DutyRoster::whereYear('duty_date', $year)
                        ->whereMonth('duty_date', $month)
                        ->select('status')
                        ->first();
        
        return view('dclerk.dashboard', compact('accountStatus','nav_title', 'recentActivity', 'rosterStatus', 'month', 'year'));
    }

    /**
     * Display account management page
     */
    public function manageAccounts(Request $request)
    {
         $nav_title = "Account Management";
        if (!Auth::user()->canCreateAccounts()) {
            abort(403, 'Unauthorized access.');
        }
        
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $dutyMonth = "$year-$month-01";
        
        // Get officers needing accounts
        $officersNeedingAccounts = DutyOfficerAccount::with(['user.unit', 'user.rank'])
            ->where('duty_month', $dutyMonth)
            ->where('needs_account', true)
            ->where('account_created', false)
            ->get();
            
        // Get all duty officers
        $allOfficers = User::with(['unit', 'rank'])
            ->where('is_role', User::ROLE_DOFFR)
            ->orderBy('rank_code')
            ->orderBy('fname')
            ->get();
        
        return view('dclerk.accounts', compact('nav_title','officersNeedingAccounts', 'allOfficers', 'month', 'year'));
    }

    public function createAccounts(Request $request)
{

    if (!Auth::user()->canCreateAccounts()) {
        abort(403, 'Unauthorized access.');
    }

    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));
    $dutyMonth = "$year-$month-01";

    // Get officers who need accounts
    $officersNeedingAccounts = DutyOfficerAccount::with(['user.unit'])
        ->where('duty_month', $dutyMonth)
        ->where('needs_account', true)
        ->where('account_created', false)
        ->get();

    $processedCount = 0;
    $passwordList = [];

    foreach ($officersNeedingAccounts as $officer) {
        // Generate secure temporary password
        $tempPassword = Str::random(10);

        // Update user's main password (hashed and secure)
        $officer->user->update([
            'password' => Hash::make($tempPassword)
        ]);

        // Store hashed version only (secure)
        $officer->update([
            'temp_password_hash' => Hash::make($tempPassword),
             'show_temp_password' => $tempPassword,
'temp_password_expires_at' => now()->addMinutes(5),
            'account_created' => true,
            'account_created_at' => now(),
        ]);

        // Add to password list for display
        $passwordList[] = [
            'user' => $officer->user,
            'temp_password' => $tempPassword,
            'expires_at' => now()->addDays(7)
        ];

        $processedCount++;
    }

    if ($processedCount > 0) {
        $notification = [
            'message' => "Successfully created $processedCount temporary account(s)",
            'alert-type' => 'success'
        ];
        
        return redirect()->route('dclerk.password-list', [
            'month' => $month,
            'year' => $year
        ])->with($notification);
    } else {
        $notification = [
            'message' => 'No officers need accounts for the selected month',
            'alert-type' => 'info'
        ];
        
        return redirect()->route('dclerk.accounts')->with($notification);
    }
}

    /**
     * Display officer communication page
     */
    public function officerCommunication()
    {
         $nav_title = "Officer Communication";
        if (!Auth::user()->canCreateAccounts()) {
            abort(403, 'Unauthorized access.');
        }
        
        $month = date('m');
        $year = date('Y');
        $dutyMonth = "$year-$month-01";
        
        // Get officers who recently had accounts created
        $recentAccounts = DutyOfficerAccount::with('user')
            ->where('duty_month', $dutyMonth)
            ->where('account_created', true)
            ->where('account_created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('account_created_at', 'desc')
            ->get();
        
        return view('dclerk.communication', compact('nav_title','recentAccounts', 'month', 'year'));
    }

    /**
     * Display account reports
     */
    public function accountReports(Request $request)
    {
         $nav_title = "Account Report";
        if (!Auth::user()->canCreateAccounts()) {
            abort(403, 'Unauthorized access.');
        }
        
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        
        // Get account creation statistics
        $accountStats = DutyOfficerAccount::with('creator')
            ->whereBetween('account_created_at', [$startDate, $endDate])
            ->selectRaw('count(*) as total, 
                        created_by, 
                        DATE(account_created_at) as created_date')
            ->groupBy('created_by', 'created_date')
            ->orderBy('created_date', 'desc')
            ->get();
        
        // Get monthly summary
        $monthlySummary = DutyOfficerAccount::whereBetween('account_created_at', [$startDate, $endDate])
            ->selectRaw('count(*) as total_created,
                        sum(needs_account) as total_needed,
                        created_by')
            ->groupBy('created_by')
            ->get();
        
        return view('dclerk.reports', compact('nav_title','accountStats', 'monthlySummary', 'month', 'year'));
    }

    /**
     * Display password list
     */
   
public function showPasswords(Request $request)
{
    $nav_title = "Show Passwords";

    if (!Auth::user()->canCreateAccounts()) {
        abort(403, 'Unauthorized access.');
    }

    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));
    $dutyMonth = "$year-$month-01";

    $passwords = DutyOfficerAccount::with('user.unit')
        ->where('duty_month', $dutyMonth)
        ->where('needs_account', true)
        ->where('account_created', true)
        ->get()
        ->map(function ($account) {
    $account->temp_password = $account->show_temp_password;
    $account->expires_at = $account->temp_password_expires_at 
        ? Carbon::parse($account->temp_password_expires_at) 
        : null;

    return $account;
        });

    return view('dclerk.password-list', [
        'passwords' => $passwords,
        'month' => $month,
        'year' => $year,
        'processedCount' => $passwords->count(),
        'nav_title' => $nav_title,
    ]);
}

    /**
     * Display roster view for D Clerk (read-only)
     */
    public function viewRoster(Request $request)
    {

         $nav_title = "Roster Display";
        if (Auth::user()->is_role !== 0 && Auth::user()->is_role !== 5) {
            abort(403, 'Unauthorized access.');
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        
        // Calculate previous and next months for navigation
        $currentDate = Carbon::createFromDate($year, $month, 1);
        $prevMonth = $currentDate->copy()->subMonth()->format('m');
        $prevYear = $currentDate->copy()->subMonth()->format('Y');
        $nextMonth = $currentDate->copy()->addMonth()->format('m');
        $nextYear = $currentDate->copy()->addMonth()->format('Y');

        $startDate = Carbon::createFromDate($year, $month, 1);
        
        // Get duty roster data
        $dutyRosters = DutyRoster::with(['user.unit', 'user.rank'])
            ->whereYear('duty_date', $year)
            ->whereMonth('duty_date', $month)
            ->get()
            ->groupBy(function($item) {
                return $item->duty_date->format('Y-m-d');
            });

        // Get roster status
        $rosterStatus = DutyRoster::whereYear('duty_date', $year)
                        ->whereMonth('duty_date', $month)
                        ->select('status')
                        ->first();

        $status = $rosterStatus->status ?? 'draft';

        return view('dclerk.roster-view', compact(
            'startDate', 'dutyRosters', 'status', 'month', 'year',
            'prevMonth', 'prevYear', 'nextMonth', 'nextYear','nav_title'
        ));
    }

    public function regenerateTempPassword(Request $request, $userId)
{
    if (!Auth::user()->canCreateAccounts()) {
        abort(403, 'Unauthorized access.');
    }

    $user = User::findOrFail($userId);

    $dutyMonth = date('Y-m-01');

    $dutyAccount = DutyOfficerAccount::where('user_id', $user->id)
                    ->where('duty_month', $dutyMonth)
                    ->first();

    if (!$dutyAccount) {
        return redirect()->back()->withErrors(['error' => 'Duty officer account not found for this user and month.']);
    }

    if ($dutyAccount->temp_password_expires_at && Carbon::now()->lt($dutyAccount->temp_password_expires_at)) {
        $notification = [
            'message' => 'Temporary password has not expired yet.',
            'alert-type' => 'info',
        ];
        return redirect()->back()->with($notification);
    }

    $newTempPassword = Str::random(10);

    $user->update([
        'password' => Hash::make($newTempPassword),
    ]);

    $dutyAccount->update([
        'temp_password_hash' => Hash::make($newTempPassword),
        'show_temp_password' => $newTempPassword,
        'temp_password_expires_at' => Carbon::now()->addMinutes(5),
    ]);

    $notification = [
        'message' => "Temporary password regenerated for {$user->fname}.",
        'alert-type' => 'success',
    ];

    return redirect()->route('dclerk.password-list')->with($notification);
}

}

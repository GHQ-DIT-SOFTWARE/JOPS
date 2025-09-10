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
        if (!Auth::user()->canCreateAccounts()) {
            abort(403, 'Unauthorized access.');
        }
        
        $month = date('m');
        $year = date('Y');
        $dutyMonth = "$year-$month-01";
        
        // Get account statistics
        $accountStatus = DutyOfficerAccount::where('duty_month', $dutyMonth)
                         ->selectRaw('count(*) as total, 
                                     sum(needs_account) as needed, 
                                     sum(account_created) as created')
                         ->first();
        
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
        
        return view('dclerk.dashboard', compact('accountStatus', 'recentActivity', 'rosterStatus', 'month', 'year'));
    }

    /**
     * Display account management page
     */
    public function manageAccounts(Request $request)
    {
        if (!Auth::user()->canCreateAccounts()) {
            abort(403, 'Unauthorized access.');
        }
        
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $dutyMonth = "$year-$month-01";
        
        // Get officers needing accounts
        $officersNeedingAccounts = DutyOfficerAccount::with(['user.unit', 'user.rankRelation'])
            ->where('duty_month', $dutyMonth)
            ->where('needs_account', true)
            ->where('account_created', false)
            ->get();
            
        // Get all duty officers
        $allOfficers = User::with(['unit', 'rankRelation'])
            ->where('is_role', User::ROLE_DOFFR)
            ->orderBy('rank')
            ->orderBy('fname')
            ->get();
        
        return view('dclerk.accounts', compact('officersNeedingAccounts', 'allOfficers', 'month', 'year'));
    }

    /**
 * Process account creation
 */
/**
 * Process account creation
 */
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
    
    foreach ($officersNeedingAccounts as $account) {
        $user = $account->user;
        $tempPassword = null;
        
        // Check if user already has a password set
        if (!empty($user->password)) {
            // User already has a password, no need to generate new one
            continue;
        }
        
        // Generate new temporary password
        $tempPassword = Str::random(8);
        
        // Hash the password and save to user
        $user->password = Hash::make($tempPassword);
        $user->save();
        
        // Add to password list to show to D Clerk
        $passwordList[] = [
            'officer' => $user->display_rank . ' ' . $user->fname . ' (' . $user->service_no . ')',
            'temp_password' => $tempPassword, // This is only for display, not stored
            'arm_of_service' => $user->arm_of_service,
            'unit' => $user->unit->unit ?? 'N/A'
        ];
        
        // Mark account as created (DO NOT store plain text password!)
        $account->account_created = true;
        $account->account_created_at = now();
        $account->created_by = Auth::user()->id;
        $account->save();
        
        $processedCount++;
    }
    
    // If we have passwords to show, display the password list
    if (count($passwordList) > 0) {
        return view('dclerk.password-list', [
            'passwords' => $passwordList,
            'month' => $month,
            'year' => $year,
            'processedCount' => $processedCount
        ]);
    }
    
    return redirect()->route('dclerk.accounts')
        ->with('success', "Accounts processed for $processedCount officers. No new passwords needed.");
}

    /**
     * Display officer communication page
     */
    public function officerCommunication()
    {
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
        
        return view('dclerk.communication', compact('recentAccounts', 'month', 'year'));
    }

    /**
     * Display account reports
     */
    public function accountReports(Request $request)
    {
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
        
        return view('dclerk.reports', compact('accountStats', 'monthlySummary', 'month', 'year'));
    }

    /**
     * Display password list
     */
    public function showPasswordList()
    {
        if (!Auth::user()->canCreateAccounts()) {
            abort(403, 'Unauthorized access.');
        }
        
        return view('dclerk.password-list', [
            'passwords' => [],
            'month' => date('m'),
            'year' => date('Y'),
            'processedCount' => 0
        ]);
    }

    /**
 * Display roster view for D Clerk (read-only)
 */
public function viewRoster(Request $request)
{
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
    $dutyRosters = DutyRoster::with('user.unit')
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
        'prevMonth', 'prevYear', 'nextMonth', 'nextYear'
    ));
}
}
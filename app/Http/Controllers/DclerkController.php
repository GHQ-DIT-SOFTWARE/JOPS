<?php
// app/Http/Controllers/DclerkController.php
namespace App\Http\Controllers;



use App\Models\ActivityLog;
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

    $officersNeedingAccounts = DutyOfficerAccount::with(['user.unit'])
        ->where('duty_month', $dutyMonth)
        ->where('needs_account', true)
        ->where('account_created', false)
        ->get();

    $processedCount = 0;
    $passwordList = [];
    $smsResults = [];

    $communicationController = new CommunicationController();

    foreach ($officersNeedingAccounts as $officer) {
        $tempPassword = Str::random(10);

        // Update user password
        $officer->user->update([
            'password' => Hash::make($tempPassword)
        ]);

        $officer->temp_password_hash = Hash::make($tempPassword);
        $officer->show_temp_password = $tempPassword;
        $officer->temp_password_expires_at = now()->addMinutes(5);
        $officer->account_created = true;
        $officer->account_created_at = now();
        $officer->save();

        $passwordList[] = [
            'user' => $officer->user,
            'temp_password' => $tempPassword,
            'expires_at' => now()->addDays(7)
        ];

        $processedCount++;

        // Initialize delivery results
        $smsResults[$officer->user->id] = [
            'name' => $officer->user->full_name ?? $officer->user->fname,
            'sms' => [
                'status' => '❌ SMS Failed',
                'message' => 'Not sent'
            ],
            'email' => [
                'status' => '❌ Email Failed',
                'message' => 'Not sent'
            ]
        ];

        // ✅ Send SMS
        try {
            $response = $communicationController->sendSms($officer->user, $request);

            if (is_a($response, \Illuminate\Http\JsonResponse::class)) {
                $res = $response->getData();
                $smsResults[$officer->user->id]['sms'] = [
                    'status' => $res->success ? '✅ SMS Sent' : '❌ SMS Failed',
                    'message' => $res->message ?? 'Unknown'
                ];
            } else {
                $smsResults[$officer->user->id]['sms'] = [
                    'status' => '❌ SMS Failed',
                    'message' => 'Unexpected response'
                ];
            }
        } catch (\Exception $e) {
            Log::error("❌ SMS send exception for user ID {$officer->user->id}: " . $e->getMessage());
            $smsResults[$officer->user->id]['sms'] = [
                'status' => '❌ SMS Failed',
                'message' => $e->getMessage()
            ];
        }

        // ✅ Send Email
        try {
            $emailResponse = $communicationController->sendEmail($officer->user, $request);

            if (is_a($emailResponse, \Illuminate\Http\JsonResponse::class)) {
                $res = $emailResponse->getData();
                $smsResults[$officer->user->id]['email'] = [
                    'status' => $res->success ? '📧 Email Sent' : '❌ Email Failed',
                    'message' => $res->message ?? 'Unknown'
                ];
            } else {
                $smsResults[$officer->user->id]['email'] = [
                    'status' => '❌ Email Failed',
                    'message' => 'Unexpected response'
                ];
            }
        } catch (\Exception $e) {
            Log::error("❌ Email send exception for user ID {$officer->user->id}: " . $e->getMessage());
            $smsResults[$officer->user->id]['email'] = [
                'status' => '❌ Email Failed',
                'message' => $e->getMessage()
            ];
        }
    }

    if ($processedCount > 0) {
        $notification = [
            'message' => "Successfully created $processedCount temporary account(s)",
            'alert-type' => 'success'
        ];

        return redirect()->route('dclerk.password-list', [
                'month' => $month,
                'year' => $year
            ])
            ->with($notification)
            ->with('sms_summary', array_values($smsResults)); // 🔹 Convert to indexed array for Blade
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
    // In DclerkController.php - officerCommunication method
public function officerCommunication(Request $request)
{
    $nav_title = "Officer Communication";
    if (!Auth::user()->canCreateAccounts()) {
        abort(403, 'Unauthorized access.');
    }
    
    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));
    $dutyMonth = "$year-$month-01";
    
    // Get officers who recently had accounts created (last 30 days)
    $recentAccounts = DutyOfficerAccount::with(['user.unit', 'user.rank'])
        ->where('account_created', true)
        ->where(function($query) {
            $query->where('account_created_at', '>=', Carbon::now()->subDays(30))
                  ->orWhere('created_at', '>=', Carbon::now()->subDays(30));
        })
        ->orderBy('account_created_at', 'desc')
        ->get();
    
    return view('dclerk.communication', compact('nav_title', 'recentAccounts', 'month', 'year'));
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

    // Get accounts with temporary passwords
    $accounts = DutyOfficerAccount::with(['user.unit', 'user.rank'])
        ->where('duty_month', $dutyMonth)
        ->where('needs_account', true)
        ->where('account_created', true)
        ->get();

    // Format the data for the view
    $passwords = $accounts->map(function ($account) {
        return [
            'officer' => $account->user->display_rank . ' ' . $account->user->fname . ' (' . $account->user->service_no . ')',
            'service_no' => $account->user->service_no,
            'arm_of_service' => $account->user->arm_of_service,
            'unit' => $account->user->unit->unit ?? 'N/A',
            'temp_password' => $account->show_temp_password, // This should now work
            'email' => $account->user->email,
            'expires_at' => $account->temp_password_expires_at 
                ? Carbon::parse($account->temp_password_expires_at) 
                : null,
            'is_expired' => $account->temp_password_expires_at 
                ? Carbon::now()->gt($account->temp_password_expires_at)
                : true,
            'user_id' => $account->user_id
        ];
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

    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));
    $dutyMonth = "$year-$month-01";

    $dutyAccount = DutyOfficerAccount::where('user_id', $user->id)
                    ->where('duty_month', $dutyMonth)
                    ->first();

    if (!$dutyAccount) {
        return redirect()->back()->withErrors(['error' => 'Duty officer account not found for this user and month.']);
    }

    // Check if password is still valid (within 5 minutes)
    if ($dutyAccount->temp_password_expires_at && Carbon::now()->lt($dutyAccount->temp_password_expires_at)) {
        $notification = [
            'message' => 'Temporary password for ' . $user->fname . ' is still valid (expires ' . $dutyAccount->temp_password_expires_at->diffForHumans() . ').',
            'alert-type' => 'info',
        ];
        return redirect()->back()->with($notification);
    }

    // Generate new temporary password
    $newTempPassword = Str::random(10);
    $expiresAt = Carbon::now()->addMinutes(5);

    // Update user password
    $user->update([
        'password' => Hash::make($newTempPassword),
    ]);

    // Update duty account record
    $dutyAccount->update([
        'temp_password_hash' => Hash::make($newTempPassword),
        'show_temp_password' => $newTempPassword,
        'temp_password_expires_at' => $expiresAt,
        'password_regenerated_at' => Carbon::now(),
        'regenerated_by' => Auth::id()
    ]);

    // Log the regeneration activity
    ActivityLog::create([
        'user_id' => Auth::user()->id,
        'action' => 'password_regenerated',
        'model_type' => 'DutyOfficerAccount',
        'model_id' => $dutyAccount->id,
        'details' => "Regenerated temporary password for {$user->fname} ({$user->service_no})",
        'ip_address' => $request->ip()
    ]);

    $notification = [
        'message' => "Temporary password regenerated for {$user->fname}. It will expire at {$expiresAt->format('H:i:s')}.",
        'alert-type' => 'success',
    ];

    return redirect()->route('dclerk.password-list', ['month' => $month, 'year' => $year])->with($notification);
}



/**
 * Enhanced publish method with detailed validation
 */
public function publishRoster(Request $request)
 {
    if (!Auth::user()->canCreateAccounts()) {
        abort(403, 'Unauthorized access.');
    }
    
    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));
    $dutyMonth = "$year-$month-01";
    
    // Get current roster status
    $rosterStatus = DutyRoster::whereYear('duty_date', $year)
        ->whereMonth('duty_date', $month)
        ->select('status')
        ->first();
    
    $status = $rosterStatus->status ?? 'draft';
    
    // Check if roster is in correct status for publishing
    if ($status !== 'submitted') {
        $statusMessage = $status === 'published' ? 'already published' : 'not submitted yet';
        $notification = [
            'message' => "Cannot publish roster. Roster is $statusMessage.",
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }
    
    // Check if all necessary accounts have been created
    $accountsNeeded = DutyOfficerAccount::where('duty_month', $dutyMonth)
        ->where('needs_account', true)
        ->where('account_created', false)
        ->count();
    
    if ($accountsNeeded > 0) {
        $notification = [
            'message' => "Cannot publish roster. $accountsNeeded officers still need accounts created.",
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }
    
    // Check if there are any duty assignments
    $assignmentCount = DutyRoster::whereYear('duty_date', $year)
        ->whereMonth('duty_date', $month)
        ->count();
    
    if ($assignmentCount === 0) {
        $notification = [
            'message' => "Cannot publish roster. No duty assignments found for $month/$year.",
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($notification);
    }
    
    // Update roster status to published
    DutyRoster::whereYear('duty_date', $year)
             ->whereMonth('duty_date', $month)
             ->update([
                 'status' => 'published',
                 'published_at' => now(),
                 'published_by' => Auth::user()->id
             ]);
    
    // Log the publication activity
    ActivityLog::create([
    'user_id' => Auth::id(),
    'action' => 'published',
    'model_type' => 'DutyRoster',
    'model_id' => null,
    'details' => "Published duty roster for $month-$year ($assignmentCount assignments). "
                . "Notified {$notifiedCount} duty officers with temp passwords.",
    'ip_address' => $request->ip()
]);

    
    // Send notifications to all duty officers
    $notifiedCount = $this->sendRosterPublishedNotifications($month, $year);
    
    $notification = [
        'message' => "Roster published successfully. $notifiedCount duty officers notified.",
        'alert-type' => 'success'
    ];

    return redirect()->route('dclerk.dashboard')->with($notification);
}

/**
 * Send notifications when roster is published
 */
private function sendRosterPublishedNotifications($month, $year)
{
    $startDate = Carbon::create($year, $month, 1);
    $endDate = Carbon::create($year, $month, 1)->endOfMonth();
    
    // Get all duty assignments for the month
    $assignments = DutyRoster::with('user')
        ->whereBetween('duty_date', [$startDate, $endDate])
        ->get()
        ->groupBy('user_id');
    
    foreach ($assignments as $userId => $userAssignments) {
        $user = $userAssignments->first()->user;
        $dutyDates = $userAssignments->pluck('duty_date')->map(function($date) {
            return Carbon::parse($date)->format('M j, Y');
        })->toArray();
        
        $datesList = implode(', ', $dutyDates);
        
        // Create notification for the officer
        \App\Models\DutyNotification::create([
            'user_id' => $userId,
            'message' => "Your duty schedule for {$month}/{$year} has been published. You are scheduled on: {$datesList}",
            'type' => 'roster_published',
            'related_date' => null,
            'duty_month' => "{$year}-{$month}-01",
            'is_read' => false
        ]);
        
        // Here you could also add email/SMS notifications if needed
    }
}
}

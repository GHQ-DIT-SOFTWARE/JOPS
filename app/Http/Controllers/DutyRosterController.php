<?php
// app/Http/Controllers/DutyRosterController.php
namespace App\Http\Controllers;

use App\Models\DutyRoster;
use App\Models\User;
use App\Models\Unit;
use App\Models\Rank;
use App\Models\AvailableDutyOfficer;
use App\Models\DutyOfficerAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DutyNotification;

class DutyRosterController extends Controller
{
    public function index(Request $request)
    {

        $nav_title = "Duty Schedule";
        if (!Auth::user()->canAccessDutyRoster()) {
            abort(403, 'Unauthorized access.');
        }
        
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        
        $startDate = Carbon::create($year, $month, 1);
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        $dutyMonth = "$year-$month-01";
        
        // Get available duty officers for this month with their units and ranks
        $availableOfficers = AvailableDutyOfficer::with(['user.unit', 'user.rank'])
            ->where('duty_month', $dutyMonth)
            ->where('is_available', true)
            ->get()
            ->pluck('user');
        
        // Get all D Offr users as fallback (for initial setup) with units and ranks
        $allOfficers = User::with(['unit', 'rank'])
            ->where('is_role', User::ROLE_DOFFR)
            ->orderBy('rank_code')
            ->orderBy('fname')
            ->get();
            
        // Use available officers if they exist, otherwise use all D Offr
        $users = $availableOfficers->count() > 0 ? $availableOfficers : $allOfficers;
        
        // FIXED: Group by formatted date string instead of raw date
        $dutyRosters = DutyRoster::with(['user.unit', 'user.rank'])
            ->whereBetween('duty_date', [$startDate, $endDate])
            ->get()
            ->groupBy(function($item) {
                return $item->duty_date->format('Y-m-d');
            });
            
        // Get roster status
        $rosterStatus = DutyRoster::whereYear('duty_date', $year)
            ->whereMonth('duty_date', $month)
            ->select('status')
            ->first();
            
        $status = $rosterStatus ? $rosterStatus->status : 'draft';
        
        // Get all units for filter options if needed
        $units = Unit::all()->keyBy('id');
            
        return view('duty-roster.index', compact('users','nav_title', 'dutyRosters', 'month', 'year', 'startDate', 'status', 'dutyMonth', 'units'));
    }
    
    public function manageOfficers(Request $request)
    {
        $nav_title = "Manage Officers";
        if (!Auth::user()->canManageDutyRoster()) {
            abort(403, 'Unauthorized access.');
        }
        
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $dutyMonth = "$year-$month-01";
        
        // Get all D Offr users with their units and ranks
        $allOfficers = User::with(['unit', 'rank'])
            ->where('is_role', User::ROLE_DOFFR)
            ->orderBy('rank_code')
            ->orderBy('fname')
            ->get();
            
        // Get currently available officers
        $availableOfficers = AvailableDutyOfficer::with('user')
            ->where('duty_month', $dutyMonth)
            ->get()
            ->keyBy('user_id');
            
        // Get all ranks and units for the add officer form
        $ranks = Rank::orderBy('rank_code')->get();
        $units = Unit::orderBy('unit')->get();
            
        return view('duty-roster.manage-officers', compact(
            'allOfficers', 
            'availableOfficers', 
            'month', 
            'year', 
            'dutyMonth',
            'ranks',
            'units',
            'nav_title'
        ));
    }
    
    public function addOfficer(Request $request)
{
    $nav_title = "Add Duty Officers";
    if (!Auth::user()->canManageDutyRoster()) {
        abort(403, 'Unauthorized access.');
    }
    
    \Log::info('Add Officer Request:', $request->all());
    
    try {
        $request->validate([
            'service_no' => 'required|unique:users,service_no',
            'rank_code' => 'required|exists:ranks,rank_code',
            'fname' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'arm_of_service' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'gender' => 'required|in:Male,Female,Other',
        ]);

        // Create the new officer
        $officer = User::create([
            'service_no' => $request->service_no,
            'rank_code' => $request->rank_code,
            'fname' => $request->fname,
            'unit_id' => $request->unit_id,
            'arm_of_service' => $request->arm_of_service,
            'phone' => $request->phone,
            'email' => $request->email,
            'gender' => $request->gender,
            'is_role' => User::ROLE_DOFFR,
        ]);

        \Log::info('Officer created:', $officer->toArray());

        // Store the temporary password in duty_officer_accounts for D Clerk retrieval
        DutyOfficerAccount::create([
            'user_id' => $officer->id,
            'duty_month' => Carbon::now()->startOfMonth()->format('Y-m-d'),
            'needs_account' => true,
            'account_created' => false,
            'created_by' => Auth::user()->id
        ]);

        $notification = [
            'message' => 'Officer added successfully. Temporary password generated for D Clerk to communicate.',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
        
    } catch (\Exception $e) {
        \Log::error('Error adding officer:', ['error' => $e->getMessage()]);
        
        $notification = [
            'message' => 'Error adding officer: ' . $e->getMessage(),
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($notification)->withInput();
    }
}
    
    public function updateAvailableOfficers(Request $request)
    {
        $nav_title = "Update Available Officers";
        if (!Auth::user()->canManageDutyRoster()) {
            abort(403, 'Unauthorized access.');
        }
        
        $request->validate([
            'duty_month' => 'required|date',
            'officers' => 'required|array',
            'officers.*' => 'exists:users,id'
        ]);
        
        $dutyMonth = $request->duty_month;
        
        // Clear existing available officers for this month
        AvailableDutyOfficer::where('duty_month', $dutyMonth)->delete();
        
        // Add new available officers
        foreach ($request->officers as $officerId) {
            AvailableDutyOfficer::create([
                'user_id' => $officerId,
                'duty_month' => $dutyMonth,
                'is_available' => true,
                'added_by' => Auth::user()->id
            ]);
        }
        
        $notification = [
    'message' => 'Available duty officers updated successfully.',
    'alert-type' => 'success'
];

return redirect()->route('duty-roster.index', [
    'month' => Carbon::parse($dutyMonth)->format('m'),
    'year' => Carbon::parse($dutyMonth)->format('Y')
])->with($notification);

    }


public function store(Request $request)
{
    if (!Auth::user()->canManageDutyRoster()) {
        abort(403, 'Unauthorized access.');
    }
    
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'duty_dates' => 'required|array',
        'duty_dates.*' => 'date',
        'is_extra' => 'boolean',
        'replaced_user_id' => 'nullable|exists:users,id' // For extra duty that replaces someone
    ]);
    
    foreach ($request->duty_dates as $date) {
        // Check if this date already has an assignment
        $existingAssignment = DutyRoster::where('duty_date', $date)->first();
        
        if ($existingAssignment) {
            // If this is an extra duty that replaces someone
            if ($request->is_extra && $request->replaced_user_id) {
                // Create notification for the officer being replaced
                DutyNotification::create([
                    'user_id' => $request->replaced_user_id,
                    'message' => "Your duty on " . Carbon::parse($date)->format('M j, Y') . 
                                " has been reassigned to " . User::find($request->user_id)->fname . 
                                " as extra duty assignment",
                    'type' => 'duty_replaced',
                    'related_date' => $date,
                    'duty_month' => Carbon::parse($date)->startOfMonth()->format('Y-m-d')
                ]);
            }
            
            // Update the existing assignment
            $existingAssignment->update([
                'user_id' => $request->user_id,
                'is_extra' => $request->is_extra ?? false
            ]);
        } else {
            // Create new assignment
            DutyRoster::create([
                'user_id' => $request->user_id,
                'duty_date' => $date,
                'is_extra' => $request->is_extra ?? false,
                'status' => 'draft'
            ]);
        }
        
        // Create notification if this is extra duty
        if ($request->is_extra) {
            DutyNotification::create([
                'user_id' => $request->user_id,
                'message' => "You have been assigned " . ($request->is_extra ? "extra " : "") . 
                            "duty on " . Carbon::parse($date)->format('M j, Y'),
                'type' => $request->is_extra ? 'extra_duty' : 'regular_duty',
                'related_date' => $date,
                'duty_month' => Carbon::parse($date)->startOfMonth()->format('Y-m-d')
            ]);
        }
        
        // Mark that this officer needs an account for this month
        $dutyMonth = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
        $this->markOfficerNeedsAccount($request->user_id, $dutyMonth);
    }
    
$notification = [
    'message' => 'Duty roster updated successfully.',
    'alert-type' => 'success'
];

return redirect()->back()->with($notification);
}
    
    private function markOfficerNeedsAccount($userId, $dutyMonth)
    {
        // Check if already marked
        $existingRecord = DutyOfficerAccount::where('user_id', $userId)
                                          ->where('duty_month', $dutyMonth)
                                          ->first();
        
        if (!$existingRecord) {
            DutyOfficerAccount::create([
                'user_id' => $userId,
                'duty_month' => $dutyMonth,
                'needs_account' => true
            ]);
        } elseif (!$existingRecord->account_created) {
            $existingRecord->update(['needs_account' => true]);
        }
    }
    
    public function getAccountStatus(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $dutyMonth = "$year-$month-01";
        
        $accountStatus = DutyOfficerAccount::where('duty_month', $dutyMonth)
                                         ->selectRaw('count(*) as total, 
                                                     sum(needs_account) as needed, 
                                                     sum(account_created) as created')
                                         ->first();
        
        return response()->json([
            'accounts_needed' => $accountStatus->needed ?? 0,
            'accounts_created' => $accountStatus->created ?? 0,
            'accounts_total' => $accountStatus->total ?? 0
        ]);
    }
    
    public function destroy($id)
    {
        if (!Auth::user()->canManageDutyRoster()) {
            abort(403, 'Unauthorized access.');
        }
        
        $dutyRoster = DutyRoster::findOrFail($id);
        
        // Only allow deletion if roster is in draft status
        if ($dutyRoster->status !== 'draft') {
$notification = [
    'message' => 'Cannot delete assignment once roster is submitted.',
    'alert-type' => 'error'
];

return redirect()->back()->with($notification);
        }
        
        $dutyRoster->delete();
        
$notification = [
    'message' => 'Duty assignment removed successfully.',
    'alert-type' => 'success'
];

return redirect()->back()->with($notification);
    }

    public function submitRoster(Request $request)
    {
        if (!Auth::user()->canManageDutyRoster()) {
            abort(403, 'Unauthorized access.');
        }
        
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        
        // Update roster status to submitted
        DutyRoster::whereYear('duty_date', $year)
                 ->whereMonth('duty_date', $month)
                 ->update([
                     'status' => 'submitted',
                     'submitted_at' => now(),
                     'submitted_by' => Auth::user()->id
                 ]);
        
$notification = [
    'message' => 'Roster submitted successfully. D Clerk can now create accounts for duty officers.',
    'alert-type' => 'success'
];

return redirect()->back()->with($notification);
    }
    
    public function publishRoster(Request $request)
    {
        if (!Auth::user()->canManageDutyRoster()) {
            abort(403, 'Unauthorized access.');
        }
        
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        
        // Update roster status to published (no account creation check)
        DutyRoster::whereYear('duty_date', $year)
                 ->whereMonth('duty_date', $month)
                 ->update([
                     'status' => 'published',
                     'published_at' => now(),
                     'published_by' => Auth::user()->id
                 ]);
        
$notification = [
    'message' => 'Roster published successfully. Duty officers can now view their assignments.',
    'alert-type' => 'success'
];

return redirect()->back()->with($notification);
    }


public function addExtraDuty(Request $request)
{
    if (!Auth::user()->canManageDutyRoster()) {
        abort(403, 'Unauthorized access.');
    }
    
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'duty_dates' => 'required|array',
        'duty_dates.*' => 'date',
        'reason' => 'nullable|string|max:500'
    ]);
    
    $extraDaysCount = 0;
    $replacedOfficers = [];
    
    foreach ($request->duty_dates as $date) {
        // Check if this date already has an assignment
        $existingAssignment = DutyRoster::where('duty_date', $date)->first();
        
        if ($existingAssignment) {
            // Store info about the officer being replaced for notification
            $replacedOfficerId = $existingAssignment->user_id;
            $replacedOfficerName = User::find($replacedOfficerId)->fname;
            
            if (!isset($replacedOfficers[$replacedOfficerId])) {
                $replacedOfficers[$replacedOfficerId] = [
                    'name' => $replacedOfficerName,
                    'dates' => []
                ];
            }
            $replacedOfficers[$replacedOfficerId]['dates'][] = $date;
            
            // Delete the existing assignment
            $existingAssignment->delete();
            
            // Create notification for the officer being unassigned
            DutyNotification::create([
                'user_id' => $replacedOfficerId,
                'message' => "Your duty on " . Carbon::parse($date)->format('M j, Y') . 
                            " has been reassigned as extra duty to another officer",
                'type' => 'duty_replaced',
                'related_date' => $date,
                'duty_month' => Carbon::parse($date)->startOfMonth()->format('Y-m-d')
            ]);
        }
        
        // Create new extra duty assignment
        DutyRoster::create([
            'user_id' => User::find($request->user_id)->id,
            'duty_date' => $date,
            'is_extra' => true,
            'extra_reason' => $request->reason,
            'status' => 'draft'
        ]);
        
        $extraDaysCount++;
        
        // Create notification for the officer receiving extra duty
        DutyNotification::create([
            'user_id' => $request->user_id,
            'message' => "You have been assigned extra duty on " . Carbon::parse($date)->format('M j, Y'),
            'type' => 'extra_duty',
            'related_date' => $date,
            'duty_month' => Carbon::parse($date)->startOfMonth()->format('Y-m-d')
        ]);
        
        // Mark that this officer needs an account for this month
        $dutyMonth = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
        $this->markOfficerNeedsAccount($request->user_id, $dutyMonth);
    }
    
    // Create summary notifications
    if ($extraDaysCount > 0) {
        // For officer receiving extra duty
        DutyNotification::create([
            'user_id' => $request->user_id,
            'message' => "You have been given $extraDaysCount days extra duty" . 
                        ($request->reason ? " (Reason: " . substr($request->reason, 0, 100) . ")" : ""),
            'type' => 'extra_duty_summary',
            'duty_month' => Carbon::parse($request->duty_dates[0])->startOfMonth()->format('Y-m-d')
        ]);
        
        // For each replaced officer, create a summary notification
        foreach ($replacedOfficers as $officerId => $info) {
            $dateCount = count($info['dates']);
            $datesList = implode(', ', array_map(function($date) {
                return Carbon::parse($date)->format('M j');
            }, $info['dates']));
            
            DutyNotification::create([
                'user_id' => $officerId,
                'message' => "Your duties on $datesList have been reassigned as extra duty to another officer",
                'type' => 'duty_replaced_summary',
                'duty_month' => Carbon::parse($request->duty_dates[0])->startOfMonth()->format('Y-m-d')
            ]);
        }
    }
    
    $message = "Extra duty assigned successfully. $extraDaysCount days added.";
    if (!empty($replacedOfficers)) {
        $replacedCount = count($replacedOfficers);
        $message .= " $replacedCount officer(s) were unassigned from these dates.";
    }
    
$notification = [
    'message' => $message,
    'alert-type' => 'success'
];

return redirect()->back()->with($notification);
}

public function getNotifications(Request $request)
{
    // Fix the condition - it should check if user is a duty officer
    if (Auth::user()->is_role !== User::ROLE_DOFFR) {
        return response()->json([]);
    }
    
    $month = $request->input('month', date('m'));
    $year = $request->input('year', date('Y'));
    $dutyMonth = "$year-$month-01";
    
    $notifications = DutyNotification::where('user_id', Auth::id())
        ->where('duty_month', $dutyMonth)
        ->orderBy('created_at', 'desc')
        ->limit(10)
        ->get();
        
    return response()->json($notifications);
}

public function markNotificationRead($id)
{
    $notification = DutyNotification::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();
        
    $notification->update(['is_read' => true]);
    
    return response()->json(['success' => true]);
}




private function createExtraDutyNotification($userId, $daysCount, $reason = null)
{
    $month = date('m');
    $year = date('Y');
    $dutyMonth = "$year-$month-01";
    
    DutyNotification::create([
        'user_id' => $userId,
        'message' => "You have been given $daysCount days extra duty" . 
                    ($reason ? " (Reason: " . substr($reason, 0, 100) . ")" : ""),
        'type' => 'extra_duty',
        'duty_month' => $dutyMonth
    ]);
}
}

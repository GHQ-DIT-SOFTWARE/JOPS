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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DutyRosterController extends Controller
{
    public function index(Request $request)
{
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
        
    return view('duty-roster.index', compact('users', 'dutyRosters', 'month', 'year', 'startDate', 'status', 'dutyMonth', 'units'));
}
    
    public function manageOfficers(Request $request)
    {
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
            'units'
        ));
    }
    
    // app/Http/Controllers/DutyRosterController.php
public function addOfficer(Request $request)
{
    if (!Auth::user()->canManageDutyRoster()) {
        abort(403, 'Unauthorized access.');
    }
    
    $request->validate([
        'service_no' => 'required|unique:users,service_no',
        'rank' => 'required|exists:ranks,rank_code',
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
        'rank' => $request->rank,
        'fname' => $request->fname,
        'unit_id' => $request->unit_id,
        'arm_of_service' => $request->arm_of_service,
        'phone' => $request->phone,
        'email' => $request->email,
        'gender' => $request->gender,
        'is_role' => User::ROLE_DOFFR,
    ]);
    
    // Store the temporary password in duty_officer_accounts for D Clerk retrieval
    DutyOfficerAccount::create([
        'user_id' => $officer->id,
        'duty_month' => Carbon::now()->startOfMonth()->format('Y-m-d'),
        'needs_account' => true,
        'account_created' => false,
        'created_by' => Auth::user()->id
    ]);
    
    return redirect()->back()->with('success', 'Officer added successfully. Temporary password generated for D Clerk to communicate.');
}
    
    public function updateAvailableOfficers(Request $request)
{
    if (!Auth::user()->canManageDutyRoster()) {
        abort(403, 'Unauthorized access.');
    }
    
    $request->validate([
        'duty_month' => 'required|date',
        'officers' => 'required|array',
        'officers.*' => 'exists:users,id'
    ]);
    
    $dutyMonth = $request->duty_month;
    
    // Debug: Check what Auth::user()->id returns
    Auth::user()->id = Auth::user()->id;
    $user = Auth::user();
    
    \Log::debug('Auth::user()->id: ' . Auth::user()->id);
    \Log::debug('Auth user: ', $user->toArray());
    
    // Clear existing available officers for this month
    AvailableDutyOfficer::where('duty_month', $dutyMonth)->delete();
    
    // Add new available officers
    foreach ($request->officers as $officerId) {
        \Log::debug('Creating available duty officer:', [
            'user_id' => $officerId,
            'duty_month' => $dutyMonth,
            'added_by' => Auth::user()->id
        ]);
        
        AvailableDutyOfficer::create([
            'user_id' => $officerId,
            'duty_month' => $dutyMonth,
            'is_available' => true,
            'added_by' => Auth::user()->id // Use the authenticated user's ID
        ]);
    }
    
    return redirect()->route('duty-roster.index', [
        'month' => Carbon::parse($dutyMonth)->format('m'),
        'year' => Carbon::parse($dutyMonth)->format('Y')
    ])->with('success', 'Available duty officers updated successfully.');
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
            'is_extra' => 'boolean'
        ]);
        
        foreach ($request->duty_dates as $date) {
            // Check if this date already has an assignment
            $existingAssignment = DutyRoster::where('duty_date', $date)->first();
            
            if ($existingAssignment) {
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
            
            // Mark that this officer needs an account for this month
            $dutyMonth = Carbon::parse($date)->startOfMonth()->format('Y-m-d');
            $this->markOfficerNeedsAccount($request->user_id, $dutyMonth);
        }
        
        return redirect()->back()->with('success', 'Duty roster updated successfully.');
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
            return redirect()->back()->with('error', 'Cannot delete assignment once roster is submitted.');
        }
        
        $dutyRoster->delete();
        
        return redirect()->back()->with('success', 'Duty assignment removed successfully.');
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
        
        return redirect()->back()->with('success', 'Roster submitted successfully. D Clerk can now create accounts for duty officers.');
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
        
        return redirect()->back()->with('success', 'Roster published successfully. Duty officers can now view their assignments.');
    }


    
}
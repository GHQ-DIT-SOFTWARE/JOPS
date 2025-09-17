<?php
namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        // Apply auth middleware to all methods in this controller
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $nav_title = "Activity Log";
        
        // Get authenticated user
        $user = Auth::user();
        
        // Check if user can view activity log
        if (!$user->canViewActivityLog()) {
            abort(403, 'Unauthorized access.');
        }
        
        $query = ActivityLog::latest();
        
        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }
        
        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date_time', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
        
        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }
        
        $activities = $query->paginate(20);
        
        return view('activity-log.index', compact('activities', 'nav_title'));
    }
    
    public function replacements(Request $request)
    {
        $nav_title = "Replacement History";
        
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user->canViewActivityLog()) {
            abort(403, 'Unauthorized access.');
        }
        
        $replacements = ActivityLog::where('action', 'replaced')
            ->latest()
            ->paginate(20);
        
        return view('activity-log.replacements', compact('replacements', 'nav_title'));
    }
    
    public function show($id)
    {
        // Get authenticated user
        $user = Auth::user();
        
        if (!$user->canViewActivityLog()) {
            abort(403, 'Unauthorized access.');
        }
        
        $activity = ActivityLog::findOrFail($id);
        
        return view('activity-log.show', compact('activity'));
    }
}
<?php

namespace App\Http\Controllers\DLAND;

use App\Http\Controllers\Controller;
use App\Models\OpsRoom;
use Illuminate\Http\Request;

class DLANDController extends Controller
{
    /**
     * DLAND Dashboard
     */
    public function dashboard()
    {
        $nav_title = "DLAND Dashboard";

        $pendingCount = OpsRoom::where('status', 'pending_dland')->count();
        $awaitingApprovalCount = OpsRoom::where('status', 'awaiting_approval')->count();
        $approvedCount = OpsRoom::where('status', 'approved')->count();

        $role = 'dland';

        return view('dland.dashboard', compact(
            'nav_title', 
            'pendingCount', 
            'awaitingApprovalCount', 
            'approvedCount', 
            'role'
        ));
    }

    /**
     * List all pending reports for DLAND review
     */
    public function pendingReports()
    {
        $nav_title = "Pending Reports";
        $reports = OpsRoom::where('status', 'pending_dland')
            ->with('user')
            ->orderBy('submitted_at', 'desc')
            ->get();

        return view('dland.reports.pending', compact('reports', 'nav_title'));
    }

    /**
     * List reports awaiting DG approval
     */
    public function awaitingReports()
    {
        $nav_title = "Awaiting DG Approval";
        $reports = OpsRoom::where('status', 'awaiting_approval')
            ->with('user')
            ->orderBy('dland_approved_at', 'desc')
            ->get();

        return view('dland.reports.awaiting', compact('reports', 'nav_title'));
    }

    /**
     * List approved reports
     */
    public function approvedReports()
    {
        $nav_title = "Approved Reports";
        $reports = OpsRoom::where('status', 'approved')
            ->with('user')
            ->orderBy('dg_approved_at', 'desc')
            ->get();

        return view('dland.reports.approved', compact('reports', 'nav_title'));
    }

    /**
     * View a single report
     */
    public function viewReport($id)
    {
        $nav_title = "View Report";
        $report = OpsRoom::with('user')->findOrFail($id);

        return view('dland.reports.view', compact('report', 'nav_title'));
    }

    /**
     * Review report and add comment (Approve)
     */
    public function reviewReport(Request $request, $id)
    {
        $request->validate([
            'd_land_ops_comment' => 'required|string|max:2000',
            'd_land_signature' => 'required|string',
        ]);

        $report = OpsRoom::findOrFail($id);

        // Ensure the report is in the correct status for DLAND review
        if ($report->status !== 'pending_dland') {
            $notification = [
                'message' => 'This report is not pending DLAND review.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $report->update([
            'd_land_ops_comment' => $request->d_land_ops_comment,
            'd_land_signature' => $request->d_land_signature,
            'status' => 'awaiting_approval',
            'dland_approved_at' => now(),
        ]);

        $notification = [
            'message' => 'Report reviewed and sent for DG approval.',
            'alert-type' => 'success'
        ];

        return redirect()->route('dland.reports.pending')->with($notification);
    }

    /**
     * Show review form for a report
     */
    public function showReviewForm($id)
    {
        $nav_title = "Review Report";
        $report = OpsRoom::with('user')->findOrFail($id);

        // Ensure the report is in the correct status for DLAND review
        if ($report->status !== 'pending_dland') {
            $notification = [
                'message' => 'This report is not pending DLAND review.',
                'alert-type' => 'error'
            ];
            return redirect()->route('dland.reports.pending')->with($notification);
        }

        return view('dland.reports.review', compact('report', 'nav_title'));
    }

    /**
     * Get reports statistics for dashboard widgets
     */
    public function getReportsStatistics()
    {
        $today = now()->format('Y-m-d');
        
        $stats = [
            'pending_today' => OpsRoom::where('status', 'pending_dland')
                ->whereDate('submitted_at', $today)
                ->count(),
            'awaiting_today' => OpsRoom::where('status', 'awaiting_approval')
                ->whereDate('dland_approved_at', $today)
                ->count(),
            'total_pending' => OpsRoom::where('status', 'pending_dland')->count(),
            'total_awaiting' => OpsRoom::where('status', 'awaiting_approval')->count(),
            'total_approved' => OpsRoom::where('status', 'approved')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get recent activity (last 5 reports acted upon by DLAND)
     */
    public function getRecentActivity()
    {
        $recentActivity = OpsRoom::whereIn('status', ['awaiting_approval', 'approved'])
            ->whereNotNull('dland_approved_at')
            ->with('user')
            ->orderBy('dland_approved_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($recentActivity);
    }

    /**
     * Update DLAND comment and signature (if needed)
     */
    public function updateComment(Request $request, $id)
    {
        $request->validate([
            'd_land_ops_comment' => 'required|string|max:2000',
            'd_land_signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $report = OpsRoom::findOrFail($id);

        // Update DLAND comment
        $report->d_land_ops_comment = $request->d_land_ops_comment;

        // Handle DLAND signature upload
        if ($request->hasFile('d_land_signature')) {
            $file = $request->file('d_land_signature');
            $filename = time() . '_dland_' . $file->getClientOriginalName();
            $file->move(public_path('upload'), $filename);
            $report->d_land_signature = $filename;
        }

        // Change status to 'awaiting_approval' for DG review
        $report->status = 'awaiting_approval';

        // Record DLAND approval timestamp
        $report->dland_approved_at = now();

        $report->save();

        $notification = [
            'message' => 'Comment and DLAND signature updated. Report sent to DG for approval.',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }


    public function allReports()
{
    $nav_title = "All Duty Reports";

    $reports = OpsRoom::with('user')
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('dland.reports.all', compact('reports', 'nav_title'));
}
}




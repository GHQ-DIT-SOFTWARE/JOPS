<?php

namespace App\Http\Controllers\DG;

use App\Http\Controllers\Controller;
use App\Models\OpsRoom;
use Illuminate\Http\Request;
use App\Models\User;

class DGController extends Controller
{
    /**
     * DG Dashboard
     */
    public function dashboard()
    {
        $nav_title = "DG Dashboard";

        $awaitingApprovalCount = OpsRoom::where('status', 'awaiting_approval')->count();
        $approvedCount = OpsRoom::where('status', 'approved')->count();

        // Get today's statistics
        $today = now()->format('Y-m-d');
        $approvedToday = OpsRoom::where('status', 'approved')
            ->whereDate('dg_approved_at', $today)
            ->count();

        // Determine role for view logic
        $role = auth()->user()->is_role == User::ROLE_SUPERADMIN ? 'superadmin' : 'dg';

        return view('dg.dashboard', compact(
            'nav_title',
            'awaitingApprovalCount',
            'approvedCount',
            'approvedToday',
            'role'
        ));
    }

    /**
     * List all reports awaiting DG approval
     */
    public function awaitingReports()
    {
        $nav_title = "Reports Awaiting Approval";

        $reports = OpsRoom::where('status', 'awaiting_approval')
            ->with('user')
            ->orderBy('dland_approved_at', 'desc')
            ->get();

        $pendingCount = OpsRoom::where('status', 'pending_dland')->count();
        $awaitingApprovalCount = OpsRoom::where('status', 'awaiting_approval')->count();
        $approvedCount = OpsRoom::where('status', 'approved')->count();

        return view('dg.reports.awaiting', compact(
            'reports',
            'nav_title',
            'pendingCount',
            'awaitingApprovalCount',
            'approvedCount'
        ));
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

        return view('dg.reports.approved', compact('reports', 'nav_title'));
    }

    /**
     * View a single report
     */
    public function viewReport($id)
    {
        $nav_title = "Review Report";
        $report = OpsRoom::with('user')->findOrFail($id);

        return view('dg.reports.view', compact('report', 'nav_title'));
    }

    /**
     * Show approval form for a report
     */
    public function showApproveForm($id)
    {
        $nav_title = "Approve Report";
        $report = OpsRoom::with('user')->findOrFail($id);

        if ($report->status !== 'awaiting_approval') {
            $notification = [
                'message' => 'This report is not awaiting DG approval.',
                'alert-type' => 'error'
            ];
            return redirect()->route('dg.reports.awaiting')->with($notification);
        }

        return view('dg.reports.approve', compact('report', 'nav_title'));
    }

    /**
     * Approve report (only for DG role, not superadmin)
     */
    public function approveReport(Request $request, $id)
    {
        if (auth()->user()->is_role == User::ROLE_SUPERADMIN) {
            $notification = [
                'message' => 'Superadmin cannot approve reports. Please log in as DG.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $request->validate([
            'dg_remarks' => 'required|string|max:2000',
            'dg_signature' => 'required|string',
        ]);

        $report = OpsRoom::findOrFail($id);

        if ($report->status !== 'awaiting_approval') {
            $notification = [
                'message' => 'This report is not awaiting DG approval.',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }

        $report->update([
            'dg_remarks' => $request->dg_remarks,
            'dg_signature' => $request->dg_signature,
            'status' => 'approved',
            'dg_approved_at' => now(),
        ]);

        $notification = [
            'message' => 'Report approved successfully.',
            'alert-type' => 'success'
        ];

        return redirect()->route('dg.reports.awaiting')->with($notification);
    }

    /**
     * Update DG comment and signature (optional upload)
     */
    public function updateComment(Request $request, $id)
    {
        $request->validate([
            'dg_remarks' => 'required|string|max:2000',
            'dg_signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $report = OpsRoom::findOrFail($id);

        $report->dg_remarks = $request->dg_remarks;

        if ($request->hasFile('dg_signature')) {
            $file = $request->file('dg_signature');
            $filename = time() . '_dg_' . $file->getClientOriginalName();
            $file->move(public_path('upload'), $filename);
            $report->dg_signature = $filename;
        }

        $report->status = 'approved';
        $report->dg_approved_at = now();
        $report->save();

        $notification = [
            'message' => 'Comment and DG signature updated. Report approved.',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    /**
     * Get reports statistics for dashboard
     */
    public function getReportsStatistics()
    {
        $today = now()->format('Y-m-d');
        $weekStart = now()->startOfWeek()->format('Y-m-d');
        $monthStart = now()->startOfMonth()->format('Y-m-d');

        $stats = [
            'awaiting_approval' => OpsRoom::where('status', 'awaiting_approval')->count(),
            'approved_today' => OpsRoom::where('status', 'approved')
                ->whereDate('dg_approved_at', $today)
                ->count(),
            'approved_this_week' => OpsRoom::where('status', 'approved')
                ->whereDate('dg_approved_at', '>=', $weekStart)
                ->count(),
            'approved_this_month' => OpsRoom::where('status', 'approved')
                ->whereDate('dg_approved_at', '>=', $monthStart)
                ->count(),
            'total_approved' => OpsRoom::where('status', 'approved')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Get recent approved reports (last 5)
     */
    public function getRecentApprovals()
    {
        $recentApprovals = OpsRoom::where('status', 'approved')
            ->with('user')
            ->orderBy('dg_approved_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($recentApprovals);
    }

    /**
     * Get reports summary for last 7 days
     */
    public function getReportsSummary()
    {
        $dates = [];
        $approvals = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates[] = $date;
            $approvals[] = OpsRoom::where('status', 'approved')
                ->whereDate('dg_approved_at', $date)
                ->count();
        }

        return response()->json([
            'dates' => $dates,
            'approvals' => $approvals
        ]);
    }


    public function allReports()
{
    $nav_title = "All Duty Reports";

    $reports = OpsRoom::with('user')
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('dg.reports.all', compact('reports', 'nav_title'));
}

}

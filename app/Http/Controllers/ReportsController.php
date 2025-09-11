<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\OpsRoom;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function dutyReport()
    {
        $nav_title = "Duty Officer Dashboard";
        $user = auth()->user();

        // Only show reports for the logged-in personnel
        $reports = OpsRoom::where('user_service_no', $user->service_no)
         ->with(['user.rankInfo'])
            ->select([
                'id',
                'user_service_no',
                'reporting_time',
                'period_covered',
                'status',
                'gen_sy_gen',
                'gen_sig_events',
                'ops_room_comm_state',
                'ops_room_messages',
                'visit_ops_room',
                'sitrep_camp_sy_gen',
                'sitrep_camp_main_gate',
                'sitrep_camp_command_gate',
                'sitrep_camp_congo_junction',
                'sitrep_camp_gafto',
                'major_event',
                'sitrep_army_sy_gen',
                'sitrep_army_sig_event',
                'sitrep_navy_sig_event',
                'sitrep_navy_sy_gen',
                'sitrep_airforce_sig_event',
                'sitrep_airforce_sy_gen',
                'misc_duty_veh_note',
                'misc_duty_veh_taking_over',
                'misc_duty_veh_handing_over',
                'major_news_of_military',
                'admin_gen_lighting',
                'admin_gen_feeding',
                'admin_gen_welfare',
                'ghq_office_keys',
                'gaf_fire_station',
                'photocopier_taking_over',
                'photocopier_handing_over',
                'additional_information',
                'd_land_ops_comment',
                'dg_remarks',
                'created_at',
                'updated_at',
                'submitted_at'
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        // Count reports by status for the current user
        $approvedCount = $reports->where('status', 'approved')->count();
        $pendingDlandCount = $reports->where('status', 'pending_dland')->count();
        $awaitingApprovalCount = $reports->where('status', 'awaiting_approval')->count();

        return view('superadmin.reports.dutyreport', compact(
            'nav_title',
            'reports',
            'approvedCount',
            'pendingDlandCount',
            'awaitingApprovalCount'
        ));
    }

    public function view($id)
{
    $user = auth()->user();
    $report = OpsRoom::where('user_service_no', $user->service_no)
                    ->with(['user.rankInfo']) // ✅ Changed from 'user.rank'
                    ->findOrFail($id);
    
    $nav_title = "View Report";

    return view('superadmin.reports.viewreport', compact('nav_title', 'report'));
}
    public function add()
{
    $nav_title = "Add Report";
    $user = auth()->user();

    $pending = OpsRoom::where('user_service_no', $user->service_no)
        ->whereIn('status', ['pending_dland', 'awaiting_approval'])
        ->exists();

    if ($pending) {
        return redirect()->route('superadmin.reports.dutyreport')
            ->with('notification', [
                'type' => 'error',
                'message' => 'You cannot submit a new report until your previous report is approved.'
            ]);
    }

    return view('superadmin.reports.addreport', compact('nav_title', 'user'));
}


    // Save progress step-wise (AJAX for each step)
    public function saveStep(Request $request)
    {
        $reportId = $request->input('report_id');
        $data = $request->except(['_token', 'report_id']);
        $user = auth()->user();

        // Ensure personnel can only edit their own reports
        if ($reportId) {
            $report = OpsRoom::where('user_service_no', $user->service_no)
                            ->findOrFail($reportId);
            $report->update($data);
        } else {
            $data['user_service_no'] = $user->service_no;
            $report = OpsRoom::create($data);
        }

        return response()->json([
            'success' => true,
            'report_id' => $report->id
        ]);
    }

    public function submit(Request $request)
    {
        $reportId = $request->input('report_id');
        $user = auth()->user();
        
        $report = OpsRoom::where('user_service_no', $user->service_no)
                        ->findOrFail($reportId);

        $report->update([
            'submitted_at' => now(),
            'status' => 'pending_dland',
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('superadmin.reports.dutyreport')
        ]);
    }

    // Store all data for the report (called after the final submit or whenever needed)
    public function store(Request $request)
{
    $reportId = $request->input('report_id');
    $user = auth()->user();

    if ($reportId) {
        $report = OpsRoom::where('user_service_no', $user->service_no)
                        ->findOrFail($reportId);
    } else {
        $report = new OpsRoom();
        $report->user_service_no = $user->service_no;
    }

    $report->fill($request->except('current_step', '_token', 'report_id'));
    $report->save();

    if ($request->ajax()) {
        return response()->json([
            'status' => 'success',
            'step' => $request->current_step,
            'report_id' => $report->id
        ]);
    }

    return redirect()->route('superadmin.reports.dutyreport')
        ->with('notification', [
            'type' => 'success',
            'message' => 'Report saved!'
        ]);
}


    public function edit($id)
{
    $user = auth()->user();
    $report = OpsRoom::where('user_service_no', $user->service_no)
                    ->findOrFail($id);

    if ($report->submitted_at) {
        return redirect()
            ->route('superadmin.reports.view', $id)
            ->with('notification', [
                'type' => 'error',
                'message' => 'This report has been submitted and cannot be edited.'
            ]);
    }

    return view('superadmin.reports.editreport', compact('report'));
}

    public function update(Request $request, $id)
{
    $user = auth()->user();
    $report = OpsRoom::where('user_service_no', $user->service_no)
                    ->findOrFail($id);

    if ($report->submitted_at) {
        return redirect()
            ->route('superadmin.reports.view', $id)
            ->with('notification', [
                'type' => 'error',
                'message' => 'This report has been submitted and cannot be edited.'
            ]);
    }

    $validated = $request->validate([
        // ... your validation rules
    ]);

    $report->update($validated);

    return redirect()
        ->route('superadmin.reports.view', $report->id)
        ->with('notification', [
            'type' => 'success',
            'message' => 'Report updated successfully.'
        ]);
}


}
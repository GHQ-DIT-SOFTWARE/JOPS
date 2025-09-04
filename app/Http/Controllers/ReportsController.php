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
        $nav_title = "Duty Report";
        $user = auth()->user();

        // Only show reports for the logged-in personnel
        $reports = OpsRoom::where('user_service_no', $user->service_no)
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
                        ->with('user')
                        ->findOrFail($id);
        
        $nav_title = "View Report";

        return view('superadmin.reports.viewreport', compact('nav_title', 'report'));
    }

    public function add()
    {
        $nav_title = "Add Report";
        $user = auth()->user();

        // Check if the user has any report that is not approved
        $pending = OpsRoom::where('user_service_no', $user->service_no)
            ->whereIn('status', ['pending_dland', 'awaiting_approval'])
            ->exists();

        if ($pending) {
            return redirect()->route('superadmin.reports.dutyreport')
                ->with('error', 'You cannot submit a new report until your previous report is approved.');
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
        
        // Find existing report or create a new one
        if ($reportId) {
            $report = OpsRoom::where('user_service_no', $user->service_no)
                            ->findOrFail($reportId);
        } else {
            $report = new OpsRoom();
            $report->user_service_no = $user->service_no;
        }

        // Update only fields submitted
        $report->fill($request->except('current_step', '_token', 'report_id'));
        $report->save();

        // If AJAX request (step-save), return JSON
        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'step' => $request->current_step, 'report_id' => $report->id]);
        }

        // Normal form submit (if not AJAX)
        return redirect()->route('superadmin.reports.dutyreport')->with('success', 'Report saved!');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $report = OpsRoom::where('user_service_no', $user->service_no)
                        ->findOrFail($id);

        if ($report->submitted_at) {
            return redirect()
                ->route('superadmin.reports.view', $id)
                ->with('error', 'This report has been submitted and cannot be edited.');
        }

        return view('superadmin.reports.editreport', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $report = OpsRoom::where('user_service_no', $user->service_no)
                        ->findOrFail($id);

        // Prevent editing of submitted reports
        if ($report->submitted_at) {
            return redirect()
                ->route('superadmin.reports.view', $id)
                ->with('error', 'This report has been submitted and cannot be edited.');
        }

        $validated = $request->validate([
            'user_service_no' => 'nullable|string',
            'reporting_time' => 'nullable|string',
            'period_covered' => 'nullable|string',
            'gen_sy_gen' => 'nullable|string',
            'gen_sig_events' => 'nullable|array',
            'gen_sig_events.*' => 'nullable|string',

            'ops_room_comm_state' => 'nullable|string',
            'ops_room_messages' => 'nullable|array',
            'ops_room_messages.*' => 'nullable|string',

            'visit_ops_room' => 'nullable|array',
            'visit_ops_room.*' => 'nullable|string',

            'photocopier_taking_over' => 'nullable|string',
            'photocopier_handing_over' => 'nullable|string',

            'sitrep_camp_sy_gen' => 'nullable|string',
            'sitrep_camp_main_gate' => 'nullable|string',
            'sitrep_camp_command_gate' => 'nullable|string',
            'sitrep_camp_congo_junction' => 'nullable|string',
            'sitrep_camp_gafto' => 'nullable|string',

            'major_event' => 'nullable|array',
            'major_event.*' => 'nullable|string',

            'sitrep_army_sy_gen' => 'nullable|string',
            'sitrep_army_sig_event' => 'nullable|array',
            'sitrep_army_sig_event.*' => 'nullable|string',

            'sitrep_navy_sy_gen' => 'nullable|string',
            'sitrep_navy_sig_event' => 'nullable|array',
            'sitrep_navy_sig_event.*' => 'nullable|string',

            'sitrep_airforce_sy_gen' => 'nullable|string',
            'sitrep_airforce_sig_event' => 'nullable|array',
            'sitrep_airforce_sig_event.*' => 'nullable|string',

            'misc_duty_veh_note' => 'nullable|string',
            'misc_duty_veh_taking_over' => 'nullable|string',
            'misc_duty_veh_handing_over' => 'nullable|string',

            'major_news_of_military' => 'nullable|array',
            'major_news_of_military.*' => 'nullable|string',

            'admin_gen_lighting' => 'nullable|string',
            'admin_gen_feeding' => 'nullable|string',
            'admin_gen_welfare' => 'nullable|string',

            'ghq_office_keys' => 'nullable|array',
            'ghq_office_keys.*' => 'nullable|string',

            'gaf_fire_station' => 'nullable|array',
            'gaf_fire_station.*' => 'nullable|string',

            'additional_information' => 'nullable|array',
            'additional_information.*' => 'nullable|string',

            'd_land_ops_comment' => 'nullable|string',
            'dg_remarks' => 'nullable|string',
        ]);

        $report->update($validated);

        return redirect()
            ->route('superadmin.reports.view', $report->id)
            ->with('success', 'Report updated successfully.');
    }
}
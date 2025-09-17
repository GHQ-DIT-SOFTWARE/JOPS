<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\OpsRoom;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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






public function downloadPDF($id)
{
    $report = OpsRoom::with(['user.unit'])->findOrFail($id);

    $pdf = Pdf::loadView('report.pdf', compact('report'))
              ->setPaper('a4', 'portrait');
            
 return $pdf->stream('duty_officer_report_'.$id.'.pdf');
}






    public function submit(Request $request)
    {
        $reportId = $request->input('report_id');
        $user = Auth::user();
        
        $report = OpsRoom::where('user_service_no', $user->service_no)
                        ->findOrFail($reportId);

        // Set recall period (5 minutes from now)
        $recallUntil = now()->addMinutes(5);
        
        $report->update([
            'recall_until' => $recallUntil,
            'scheduled_submit_at' => $recallUntil,
            'status' => 'recall',
        ]);

        return response()->json([
            'success' => true,
            'recall_until' => $recallUntil->toISOString(),
            'report_id' => $report->id,
            'message' => 'Report submitted. You can recall and edit for 5 minutes.',
        ]);
    }

    public function finalizeSubmission(Request $request)
    {
        $reportId = $request->input('report_id');
        $user = Auth::user();
        
        $report = OpsRoom::where('user_service_no', $user->service_no)
                        ->findOrFail($reportId);
        
        // Only finalize if still in recall status and recall period has expired
        if ($report->status === 'recall' && now()->greaterThan($report->recall_until)) {
            $report->update([
                'submitted_at' => now(),
                'status' => 'pending_dland',
                'recall_until' => null,
                'scheduled_submit_at' => null,
            ]);
            
            return response()->json(['success' => true]);
        }
        
        return response()->json([
            'success' => false, 
            'message' => 'Report not ready for final submission'
        ]);
    }

    public function store(Request $request)
    {
        $reportId = $request->input('report_id');
        $user = Auth::user();

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
        $user = Auth::user();
        $report = OpsRoom::where('user_service_no', $user->service_no)
                        ->findOrFail($id);

        // Allow editing if in recall status and recall period hasn't expired
        $canEdit = $report->status === 'recall' && now()->lessThan($report->recall_until);
        
        if ($report->submitted_at && !$canEdit) {
            return redirect()
                ->route('superadmin.reports.view', $id)
                ->with('notification', [
                    'type' => 'error',
                    'message' => 'This report has been submitted and cannot be edited.'
                ]);
        }

        return view('superadmin.reports.editreport', compact('report', 'canEdit'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $report = OpsRoom::where('user_service_no', $user->service_no)
                        ->findOrFail($id);

        // Allow updating if in recall status and recall period hasn't expired
        $canEdit = $report->status === 'recall' && now()->lessThan($report->recall_until);
        
        if ($report->submitted_at && !$canEdit) {
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

    public function cancelRecall(Request $request)
    {
        $reportId = $request->input('report_id');
        $user = Auth::user();
        
        $report = OpsRoom::where('user_service_no', $user->service_no)
                        ->findOrFail($reportId);

        if ($report->status === 'recall') {
            $report->update([
                'recall_until' => null,
                'scheduled_submit_at' => null,
                'status' => 'draft',
            ]);
            
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Cannot cancel recall']);
    }
}

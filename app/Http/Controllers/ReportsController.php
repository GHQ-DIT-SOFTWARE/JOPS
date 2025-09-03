<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\OpsRoom;
use Illuminate\Http\Request;

class ReportsController extends Controller
{


    public function dutyReport()
{

    $nav_title = "Duty Report";
    // Fetch the recent duty reports, selecting the necessary columns
    $reports = OpsRoom::select([
        'id',
        'user_service_no',
        'reporting_time',
        'period_covered',
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
        'updated_at'
    ])
    ->orderBy('reporting_time', 'desc') // Sort by reporting time
    ->limit(10)  // Limit to the most recent 10 reports
    ->get();

    return view('superadmin.reports.dutyreport', compact('nav_title','reports'));


}

public function view($id)
{
    $report = OpsRoom::with('user')->findOrFail($id);
    $nav_title = "View Report";

    return view('superadmin.reports.viewreport', compact('nav_title', 'report'));
}



    public function dailySitrep()
    {
        $nav_title = "Daily Sitrep";
        return view('superadmin.reports.dailysitrep', compact('nav_title'));
    }

    public function add()
{
    $nav_title = "Add Report";
    $user = auth()->user();
    return view('superadmin.reports.addreport', compact('nav_title', 'user'));
}

  public function store(Request $request)
{
    // ---------- Validation ----------
    $request->validate([
        'reporting_time' => 'required|date_format:H:i',
        'period_covered' => 'required|string',
        
    ]);

    // ---------- Prepare data ----------
    $opsRoomData = $request->only([
        'reporting_time',
        'period_covered',
        'gen_sig_events',
        'ops_room_comm_state',
        'visit_ops_room',
        'photocopier_taking_over',
        'photocopier_handing_over',
        'sitrep_camp_sy_gen',
        'sitrep_camp_main_gate',
        'sitrep_camp_command_gate',
        'sitrep_camp_congo_junction',
        'sitrep_camp_gafto',
        'sitrep_army_sy_gen',
        'sitrep_navy_sy_gen',
        'sitrep_airforce_sy_gen',
        'misc_duty_veh_note',
        'misc_duty_veh_taking_over',
        'misc_duty_veh_handing_over',
        'major_news_of_military',
        'admin_gen_lighting',
        'admin_gen_feeding',
        'admin_gen_welfare',
        'ghq_office_keys',
        'additional_information',
        'd_land_ops_comment',
        'dg_remarks',
        'gen_sy_gen',
        'ops_room_messages',
        'gaf_fire_station',
        'major_event',
        'sitrep_army_sig_event',
        'sitrep_navy_sig_event',
        'sitrep_airforce_sig_event',
    ]);

    

    // If fields are null, ensure they stay null
    foreach ($opsRoomData as $key => $value) {
        $opsRoomData[$key] = $value ?? null; // If value is empty, set it to null
    }

    // Add the authenticated user's service number
    $opsRoomData['user_service_no'] = auth()->user()->service_no;

    // Save to DB
    OpsRoom::create($opsRoomData);

    return redirect()
        ->route('superadmin.reports.dutyreport') // Changed from 'dailysitrep'
        ->with('success', 'Report submitted successfully!');
}



// public function store(Request $request)
// {
//     dd($request->all());
// }
}

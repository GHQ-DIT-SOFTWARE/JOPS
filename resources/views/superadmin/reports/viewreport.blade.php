@extends('adminbackend.layouts.master')


<style>

</style>
@section('main')
    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Duty Officer Report</h5>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white mt-2">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="#"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Report</a></li>
                                </ul>
                                <a href="{{ route('superadmin.reports.dutyreport') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="container mt-4">
                    <h4 class="text-center mb-4">DUTY OFFICER REPORT</h4>

                    {{-- DETAILS --}}

                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>Duty Officer</th>
                            <td>{{ $report->user->rank }} {{ $report->user->fname }}</td>
                            <th>Dept/DTE</th>
                            <td>{{ $report->user->unit }}</td>
                        </tr>
                        <tr>
                            <th>Contact Number</th>
                            <td>{{ $report->user->phone }}</td>
                            <th>Reporting Time</th>
                            <td>{{ $report->reporting_time }}</td>
                        </tr>
                        <tr>
                            <th>Period Covered</th>
                            <td colspan="3">{{ $report->period_covered }}</td>
                        </tr>
                    </table>

                    {{-- GENERAL --}}

                    <label class="mt-4"
                        style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.5em">
                        GENERAL</label>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th width="25%">1. Sy Gen</th>
                            <td>{{ $report->gen_sy_gen }}</td>
                        </tr>
                        <tr>
                            <th>2. Significant Event</th>
                            <td>{!! nl2br(e($report->gen_sig_events)) !!}</td>
                        </tr>
                    </table>

                    {{-- OPS ROOM --}}
                    <label class="mt-4"
                        style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.5em">
                        OPS ROOM</label>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th width="25%">3. Comm State</th>
                            <td>{{ $report->ops_room_comm_state }}</td>
                        </tr>
                        <tr>
                            <th width="25%">4. Messages/Correspondence</th>
                            <td>{!! nl2br(e($report->ops_room_messages)) !!}</td>
                        </tr>
                        <tr>
                            <th>5. Visit to the Ops Room</th>
                            <td>{!! nl2br(e($report->visit_ops_room)) !!}</td>
                        </tr>
                    </table>

                    {{-- CAMP SITREP --}}
                    <label class="mt-4"
                        style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.5em">
                        SITREP-CAMP</label>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>6. Sy Gen</th>
                            <td>{{ $report->sitrep_camp_sy_gen }}</td>
                        </tr>
                        <tr>
                            <th>a. Main Gate</th>
                            <td>{{ $report->sitrep_camp_main_gate }}</td>
                            <th>b. Comd Gate</th>
                            <td>{{ $report->sitrep_camp_command_gate }}</td>
                        </tr>
                        <tr>
                            <th>c. Congo Junction</th>
                            <td>{{ $report->sitrep_camp_congo_junction }}</td>
                            <th>d. GAFPO</th>
                            <td>{{ $report->sitrep_camp_gafto }}</td>
                        </tr>
                    </table>

                    {{-- MAJOR EVENT --}}
                    <h5 class="mt-4">Major Event</h5>
                    <div class="border p-2">{!! nl2br(e($report->major_event)) !!}</div>

                    {{-- SITREP - ARMY/NAVY/AIRFORCE --}}
                    <label class="mt-4"
                        style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.5em">
                        SITREP - ARMY</label>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>7. Army Sy Gen</th>
                            <td>{{ $report->sitrep_army_sy_gen }}</td>
                            <th>8. Army Sig Event</th>
                            <td>{!! nl2br(e($report->sitrep_army_sig_event)) !!}</td>
                        </tr>
                        <tr>
                            <th>9. Navy Sy Gen</th>
                            <td>{{ $report->sitrep_navy_sy_gen }}</td>
                            <th>10. Navy Sig Event</th>
                            <td>{!! nl2br(e($report->sitrep_navy_sig_event)) !!}</td>
                        </tr>
                        <tr>
                            <th>11. Airforce Sy Gen</th>
                            <td>{{ $report->sitrep_airforce_sy_gen }}</td>
                            <th>12. Airforce Sig Event</th>
                            <td>{!! nl2br(e($report->sitrep_airforce_sig_event)) !!}</td>
                        </tr>
                    </table>
                    <label class="mt-4"
                        style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.5em">
                        SITREP - NAVY</label>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>7. Army Sy Gen</th>
                            <td>{{ $report->sitrep_army_sy_gen }}</td>
                            <th>8. Army Sig Event</th>
                            <td>{!! nl2br(e($report->sitrep_army_sig_event)) !!}</td>
                        </tr>
                        <tr>
                            <th>9. Navy Sy Gen</th>
                            <td>{{ $report->sitrep_navy_sy_gen }}</td>
                            <th>10. Navy Sig Event</th>
                            <td>{!! nl2br(e($report->sitrep_navy_sig_event)) !!}</td>
                        </tr>
                        <tr>
                            <th>11. Airforce Sy Gen</th>
                            <td>{{ $report->sitrep_airforce_sy_gen }}</td>
                            <th>12. Airforce Sig Event</th>
                            <td>{!! nl2br(e($report->sitrep_airforce_sig_event)) !!}</td>
                        </tr>
                    </table> <label class="mt-4"
                        style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.5em">
                        SITREP - AIRFORCE</label>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>7. Army Sy Gen</th>
                            <td>{{ $report->sitrep_army_sy_gen }}</td>
                            <th>8. Army Sig Event</th>
                            <td>{!! nl2br(e($report->sitrep_army_sig_event)) !!}</td>
                        </tr>
                        <tr>
                            <th>9. Navy Sy Gen</th>
                            <td>{{ $report->sitrep_navy_sy_gen }}</td>
                            <th>10. Navy Sig Event</th>
                            <td>{!! nl2br(e($report->sitrep_navy_sig_event)) !!}</td>
                        </tr>
                        <tr>
                            <th>11. Airforce Sy Gen</th>
                            <td>{{ $report->sitrep_airforce_sy_gen }}</td>
                            <th>12. Airforce Sig Event</th>
                            <td>{!! nl2br(e($report->sitrep_airforce_sig_event)) !!}</td>
                        </tr>
                    </table>
                    {{-- MISC --}}
                    <label class="mt-4"
                        style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.5em">
                        MISC</label>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>13. Duty Veh Note</th>
                            <td>{!! nl2br(e($report->misc_duty_veh_note)) !!}</td>
                        </tr>
                        <tr>
                            <th>Taking Over Veh</th>
                            <td>{{ $report->misc_duty_veh_taking_over }}</td>
                            <th>Handing Over Veh</th>
                            <td>{{ $report->misc_duty_veh_handing_over }}</td>
                        </tr>
                    </table>

                    <h5 class="mt-4">14. Major News of Military Importance</h5>
                    <div class="border p-2">{!! nl2br(e($report->major_news_of_military)) !!}</div>

                    {{-- ADMIN GEN --}}
                    <h5 class="mt-4">15. Admin Gen</h5>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>a. Lighting</th>
                            <td>{{ $report->admin_gen_lighting }}</td>
                            <th>b. Feeding</th>
                            <td>{{ $report->admin_gen_feeding }}</td>
                            <th>c. Welfare</th>
                            <td>{{ $report->admin_gen_welfare }}</td>
                        </tr>
                    </table>

                    <h5 class="mt-4">16. GHQ Office Keys</h5>
                    <div class="border p-2">{!! nl2br(e($report->ghq_office_keys)) !!}</div>

                    <h5 class="mt-4">17. GAF Fire Station</h5>
                    <div class="border p-2">{!! nl2br(e($report->gaf_fire_station)) !!}</div>

                    <h5 class="mt-4">18. Ops Room Photocopier</h5>
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>a. Taking Over</th>
                            <td>{{ $report->photocopier_taking_over }}</td>
                            <th>b. Handing Over</th>
                            <td>{{ $report->photocopier_handing_over }}</td>
                        </tr>
                    </table>

                    {{-- FINAL REMARKS --}}
                    <label class="mt-4"
                        style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.5em">
                        ADDITIONAL INFORMATION</label>
                    <div class="border p-2">{!! nl2br(e($report->additional_information)) !!}</div>

                    <label class="mt-4"
                        style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.5em">
                        D LANDS OPS COMMENT</label>
                    <div class="border p-2">{!! nl2br(e($report->d_land_ops_comment)) !!}</div>

                    <label class="mt-4"
                        style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.5em">
                        DG REMARKS</label>
                    <div class="border p-2">{!! nl2br(e($report->dg_remarks)) !!}</div>
                </div>
            </div>

        </div>
    </section>
@endsection

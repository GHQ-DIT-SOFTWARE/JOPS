@extends('adminbackend.layouts.master')


<style>
.card{
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif
}
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
                <hr>
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

                <label class="mt-4" style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
    GENERAL</label>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th width="25%">1. Security General</th>
                        <td>{{ $report->gen_sy_gen }}</td>
                    </tr>
                    <tr>
                        <th>2. Significant Event</th>
                        <td>{!! nl2br(e($report->gen_sig_events)) !!}</td>
                    </tr>
                </table>

                {{-- OPS ROOM --}}
                 <label class="mt-4" style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
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
                <label class="mt-4" style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
    SITREP - CAMP</label>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th>6. Security General</th>
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
                 <label class="mt-4" style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
    SITREP - ARMY</label>
                 <table class="table table-bordered table-sm">
                    <tr>
                        <th width="25%">7. Security General</th>
                        <td>{{ $report->gen_sy_gen }}</td>
                    </tr>
                    <tr>
                        <th>8. Significant Event</th>
                        <td>{!! nl2br(e($report->gen_sig_events)) !!}</td>
                    </tr>
                </table>
               <label class="mt-4" style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
    SITREP - NAVY</label>
                     <table class="table table-bordered table-sm">
                    <tr>
                        <th width="25%">9. Security General</th>
                        <td>{{ $report->gen_sy_gen }}</td>
                    </tr>
                    <tr>
                        <th>10. Significant Event</th>
                        <td>{!! nl2br(e($report->gen_sig_events)) !!}</td>
                    </tr>
                </table>
           <label class="mt-4" style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
    SITREP - AIRFORCE</label>
                <table class="table table-bordered table-sm">
                    <tr>
                        <th width="25%">11. Security General</th>
                        <td>{{ $report->gen_sy_gen }}</td>
                    </tr>
                    <tr>
                        <th>12. Significant Event</th>
                        <td>{!! nl2br(e($report->gen_sig_events)) !!}</td>
                    </tr>
                </table>
                {{-- MISC --}}
               <label class="mt-4" style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
    MISC</label>
                <table class="table table-bordered table-sm">


    <!-- MISC -->
    <tr>
        <th width="25%">13. Duty Veh Note</th>
        <td colspan="3">{!! nl2br(e($report->misc_duty_veh_note)) !!}</td>
    </tr>
    <tr>
        <th>Taking Over Veh</th>
        <td>{{ $report->misc_duty_veh_taking_over }}</td>
        <th>Handing Over Veh</th>
        <td>{{ $report->misc_duty_veh_handing_over }}</td>
    </tr>
    <tr>
        <th>14. Major News of Military Importance</th>
        <td colspan="3">{!! nl2br(e($report->major_news_of_military)) !!}</td>
    </tr>

    <!-- ADMIN GEN -->
    <tr class="table-secondary">
        <th colspan="4">15. Admin Gen</th>
    </tr>
    <tr>
        <th>a. Lighting</th>
        <td>{{ $report->admin_gen_lighting }}</td>
        <th>b. Feeding</th>
        <td>{{ $report->admin_gen_feeding }}</td>
    </tr>
    <tr>
        <th>c. Welfare</th>
        <td colspan="3">{{ $report->admin_gen_welfare }}</td>
    </tr>

    <!-- GHQ Office Keys -->
    <tr>
        <th>16. GHQ Office Keys</th>
        <td colspan="3">{!! nl2br(e($report->ghq_office_keys)) !!}</td>
    </tr>

    <!-- GAF Fire Station -->
    <tr>
        <th>17. GAF Fire Station</th>
        <td colspan="3">{!! nl2br(e($report->gaf_fire_station)) !!}</td>
    </tr>

    <!-- OPS ROOM PHOTOCOPIER -->
    <tr class="table-secondary">
        <th colspan="4">18. Ops Room Photocopier</th>
    </tr>
    <tr>
        <th>a. Taking Over</th>
        <td>{{ $report->photocopier_taking_over }}</td>
        <th>b. Handing Over</th>
        <td>{{ $report->photocopier_handing_over }}</td>
    </tr>
</table>

                {{-- FINAL REMARKS --}}
                <label class="mt-4" style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
    ADDITIONAL INFORMATION</label>
                <div class="border p-2">{!! nl2br(e($report->additional_information)) !!}</div>

                <label class="mt-4" style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
    D LANDS OPS COMMENT</label>
                <div class="border p-2">{!! nl2br(e($report->d_land_ops_comment)) !!}</div>

               <label class="mt-4" style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
    DG REMARKS</label>
                <div class="border p-2">{!! nl2br(e($report->dg_remarks)) !!}</div>
            </div>
            </div>

        </div>
    </section>
@endsection

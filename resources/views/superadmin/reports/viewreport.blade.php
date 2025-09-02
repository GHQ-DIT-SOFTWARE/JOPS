@extends('adminbackend.layouts.master')

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

            {{-- Report Body --}}
            <div class="container mt-4">
                <h4 class="text-center mb-4">DUTY OFFICER REPORT</h4>

                <h5 class="mt-4">Details</h5>
                <div class="mb-3"><strong>Duty Officer:</strong> {{ $report->user->rank }} {{ $report->user->fname }}
                </div>
                <div class="mb-3"><strong>Dept/DTE:</strong> {{ $report->user->unit }}</div>
                <div class="mb-3"><strong>Contact Number:</strong> {{ $report->user->phone }}</div>
                <div class="mb-3"><strong>Reporting Time:</strong> {{ $report->reporting_time }}</div>
                <div class="mb-3"><strong>Period Covered:</strong> {{ $report->period_covered }}</div>



                <h5 class="mt-4">General</h5>
                <p><strong>1. Sy Gen:</strong> {{ $report->gen_sy_gen }}</p>
                <p><strong>2. Significant Event:</strong><br>{!! nl2br(e($report->gen_sig_events)) !!}</p>


                <h5 class="mt-4">Ops Room</h5>
                <p><strong>3. Comm State:</strong> {{ $report->ops_room_comm_state }}</p>
                <p><strong>4. Messages/Correspondence Received:</strong><br>{!! nl2br(e($report->ops_room_messages)) !!}</p>

                <h5 class="mt-4">5. Visit to the Ops Room</h5>
                <p>{!! nl2br(e($report->visit_ops_room)) !!}</p>

                <h5 class="mt-4">Sitrep - Camp</h5>
                <p><strong>6. Sy Gen:</strong> {{ $report->sitrep_camp_sy_gen }}</p>
                <ol type="a">
                    <li>Main Gate: {{ $report->sitrep_camp_main_gate }}</li>
                    <li>Comd Gate: {{ $report->sitrep_camp_command_gate }}</li>
                    <li>Congo Junction: {{ $report->sitrep_camp_congo_junction }}</li>
                    <li>GAFT0: {{ $report->sitrep_camp_gafto }}</li>
                </ol>


                <h5 class="mt-4">Major Event</h5>
                <p>{!! nl2br(e($report->major_event)) !!}</p>

                <h5 class="mt-4">Sitrep - Army</h5>
                <p><strong>7. Sy Gen:</strong> {{ $report->sitrep_army_sy_gen }}</p>
                <p><strong>8. Significant Event:</strong><br>{!! nl2br(e($report->sitrep_army_sig_event)) !!}</p>

                <h5 class="mt-4">Sitrep - Navy</h5>
                <p><strong>9. Sy Gen:</strong> {{ $report->sitrep_navy_sy_gen }}</p>
                <p><strong>10. Significant Event:</strong><br>{!! nl2br(e($report->sitrep_navy_sig_event)) !!}</p>

                <h5 class="mt-4">Sitrep - Airforce</h5>
                <p><strong>11. Sy Gen:</strong> {{ $report->sitrep_airforce_sy_gen }}</p>
                <p><strong>12. Significant Event:</strong><br>{!! nl2br(e($report->sitrep_airforce_sig_event)) !!}</p>

                <h5 class="mt-4">Misc</h5>
                <p><strong>13. Duty Veh Note:</strong><br>{!! nl2br(e($report->misc_duty_veh_note)) !!}</p>
                <p><strong>Taking Over Veh:</strong> {{ $report->misc_duty_veh_taking_over }}</p>
                <p><strong>Handing Over Veh:</strong> {{ $report->misc_duty_veh_handing_over }}</p>

                <h5 class="mt-4">14. Major News of Military Importance</h5>
                <p>{!! nl2br(e($report->major_news_of_military)) !!}</p>

                <h5 class="mt-4">15. Admin Gen</h5>
                <ol type="a">
                    <li>Lighting: {{ $report->admin_gen_lighting }}</li>
                    <li>Feeding: {{ $report->admin_gen_feeding }}</li>
                    <li>Welfare: {{ $report->admin_gen_welfare }}</li>
                </ol>

                <h5 class="mt-4">16. GHQ Office Keys</h5>
                <p>{!! nl2br(e($report->ghq_office_keys)) !!}</p>

                <h5 class="mt-4">17. GAF Fire Station</h5>
                <p>{!! nl2br(e($report->gaf_fire_station)) !!}</p>

                <h5 class="mt-4">18. Ops Room Photocopier</h5>
                <p><strong>a. Taking Over - </strong> {{ $report->photocopier_taking_over }}</p>
                <p><strong>b. Handing Over - </strong> {{ $report->photocopier_handing_over }}</p>

                <h5 class="mt-4">Additional Information</h5>
                <p>{!! nl2br(e($report->additional_information)) !!}</p>

                <h5 class="mt-4">D Land Ops Comment</h5>
                <p>{!! nl2br(e($report->d_land_ops_comment)) !!}</p>

                <h5 class="mt-4">DG Remarks</h5>
                <p>{!! nl2br(e($report->dg_remarks)) !!}</p>

                {{-- <div class="text-muted mt-4">
                    <small>Created at: {{ $report->created_at }}</small><br>
                    <small>Updated at: {{ $report->updated_at }}</small>
                </div> --}}
            </div>
        </div>
    </section>
@endsection

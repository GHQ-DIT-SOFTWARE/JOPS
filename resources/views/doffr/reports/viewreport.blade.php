@extends('adminbackend.layouts.master')

<style>
    .card {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
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
                                    <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="#!">Report</a></li>
                                </ul>
                                <div
                                    class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white mt-2">
                                    

                                    <div class="d-flex gap-2">
                                        <a href="{{ route('doffr.reports.dutyreport') }}"
                                            class="btn btn-secondary">Back</a>

                                        @if (is_null($report->dland_approved_at))
    <a href="{{ route('doffr.reports.edit', $report->id) }}" class="btn btn-primary">Edit</a>
@endif

                                    </div>

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
                                <td>{{ $report->user->display_rank }} {{ $report->user->fname }}</td>
                                <th>Dept/DTE</th>
                                <td>{{ $report->user->unit->unit ?? '' }}</td>

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
                            style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
                            GENERAL
                        </label>
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th width="25%">1. Security General</th>
                                <td>{{ $report->gen_sy_gen }}</td>
                            </tr>
                            <tr>
                                <th>2. Significant Event</th>
                                <td>
                                    @if ($report->gen_sig_events)
                                        <ol type="a" style="padding-left: 20px; margin:0;">
                                            @foreach (is_array($report->gen_sig_events) ? $report->gen_sig_events : explode("\n", $report->gen_sig_events) as $event)
                                                @if (trim($event))
                                                    <li>{{ $event }}</li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        {{-- OPS ROOM --}}
                        <label class="mt-4"
                            style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
                            OPS ROOM
                        </label>
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th width="25%">3. Comm State</th>
                                <td>{{ $report->ops_room_comm_state }}</td>
                            </tr>
                            <tr>
                                <th width="25%">4. Messages/Correspondence</th>
                                <td>
                                    @if ($report->ops_room_messages)
                                        <ol type="a" style="padding-left: 20px; margin:0;">
                                            @foreach (is_array($report->ops_room_messages) ? $report->ops_room_messages : explode("\n", $report->ops_room_messages) as $msg)
                                                @if (trim($msg))
                                                    <li>{{ $msg }}</li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>5. Visit to the Ops Room</th>
                                <td>
                                    @if ($report->visit_ops_room)
                                        <ol type="a" style="padding-left: 20px; margin:0;">
                                            @foreach (is_array($report->visit_ops_room) ? $report->visit_ops_room : explode("\n", $report->visit_ops_room) as $visit)
                                                @if (trim($visit))
                                                    <li>{{ $visit }}</li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Photocopier Taking Over</th>
                                <td>{{ $report->photocopier_taking_over }}</td>
                                <th>Photocopier Handing Over</th>
                                <td>{{ $report->photocopier_handing_over }}</td>
                            </tr>
                        </table>

                        {{-- CAMP SITREP --}}
                        <label class="mt-4"
                            style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
                            SITREP - CAMP
                        </label>
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
                            <tr>
                                <th>Major Events</th>
                                <td colspan="3">
                                    @if ($report->major_event)
                                        <ol type="a" style="padding-left: 20px; margin:0;">
                                            @foreach (is_array($report->major_event) ? $report->major_event : explode("\n", $report->major_event) as $event)
                                                @if (trim($event))
                                                    <li>{{ $event }}</li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        {{-- BRANCH SITREPs --}}
                        @foreach (['army', 'navy', 'airforce'] as $i => $branch)
                            <label class="mt-4"
                                style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
                                SITREP - {{ strtoupper($branch) }}
                            </label>
                            <table class="table table-bordered table-sm">
                                <tr>
                                    <th width="25%">Security General</th>
                                    <td>{{ $report->{'sitrep_' . $branch . '_sy_gen'} }}</td>
                                </tr>
                                <tr>
                                    <th>Significant Events</th>
                                    <td>
                                        @php
                                            $sigEventsField = 'sitrep_' . $branch . '_sig_event';
                                            $sigEvents = $report->$sigEventsField;
                                        @endphp
                                        @if ($sigEvents)
                                            <ol type="a" style="padding-left: 20px; margin:0;">
                                                @foreach (is_array($sigEvents) ? $sigEvents : explode("\n", $sigEvents) as $ev)
                                                    @if (trim($ev))
                                                        <li>{{ $ev }}</li>
                                                    @endif
                                                @endforeach
                                            </ol>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        @endforeach

                        {{-- MISC --}}
                        <label class="mt-4"
                            style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
                            MISC
                        </label>
                        <table class="table table-bordered table-sm">
                            <tr>
                                <th>13. Duty Veh Note</th>
                                <td>{{ $report->misc_duty_veh_note }}</td>
                            </tr>
                            <tr>
                                <th>Taking Over Veh</th>
                                <td>{{ $report->misc_duty_veh_taking_over }}</td>
                                <th>Handing Over Veh</th>
                                <td>{{ $report->misc_duty_veh_handing_over }}</td>
                            </tr>
                            <tr>
                                <th>Major News of Military Importance</th>
                                <td colspan="3">
                                    @if ($report->major_news_of_military)
                                        <ol type="a" style="padding-left: 20px; margin:0;">
                                            @foreach (is_array($report->major_news_of_military) ? $report->major_news_of_military : explode("\n", $report->major_news_of_military) as $news)
                                                @if (trim($news))
                                                    <li>{{ $news }}</li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                            </tr>

                            <tr class="table-secondary">
                                <th colspan="4">Admin Gen</th>
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

                            <tr>
                                <th>GHQ Office Keys</th>
                                <td colspan="3">
                                    @if ($report->ghq_office_keys)
                                        <ol type="a" style="padding-left: 20px; margin:0;">
                                            @foreach (is_array($report->ghq_office_keys) ? $report->ghq_office_keys : explode("\n", $report->ghq_office_keys) as $key)
                                                @if (trim($key))
                                                    <li>{{ $key }}</li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>GAF Fire Station</th>
                                <td colspan="3">
                                    @if ($report->gaf_fire_station)
                                        <ol type="a" style="padding-left: 20px; margin:0;">
                                            @foreach (is_array($report->gaf_fire_station) ? $report->gaf_fire_station : explode("\n", $report->gaf_fire_station) as $station)
                                                @if (trim($station))
                                                    <li>{{ $station }}</li>
                                                @endif
                                            @endforeach
                                        </ol>
                                    @endif
                                </td>
                            </tr>

                            <tr class="table-secondary">
                                <th colspan="4">Ops Room Photocopier</th>
                            </tr>
                            <tr>
                                <th>a. Taking Over</th>
                                <td>{{ $report->photocopier_taking_over }}</td>
                                <th>b. Handing Over</th>
                                <td>{{ $report->photocopier_handing_over }}</td>
                            </tr>
                        </table>

                        {{-- ADDITIONAL INFO --}}
                        <label class="mt-4"
                            style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
                            ADDITIONAL INFORMATION
                        </label>
                        @if ($report->additional_information)
                            <ol type="a" style="padding-left: 20px; margin:0;">
                                @foreach (is_array($report->additional_information) ? $report->additional_information : explode("\n", $report->additional_information) as $info)
                                    @if (trim($info))
                                        <li>{{ $info }}</li>
                                    @endif
                                @endforeach
                            </ol>
                        @endif

                        {{-- D LANDS OPS COMMENT (Read-only) --}}
                        <label class="mt-4"
                            style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
                            D LANDS OPS COMMENT
                        </label>
                        <div class="border p-2">
                            {!! nl2br(e($report->d_land_ops_comment)) !!}
                        </div>

                        {{-- D LANDS Signature --}}
                        <label class="mt-2">D LANDS Signature</label>
                        <div class="mb-2">
                            @if ($report->d_land_signature)
                                <img src="{{ asset('upload/' . $report->d_land_signature) }}" alt="DLAND Signature"
                                    height="80">
                            @else
                                <p><em>No signature provided</em></p>
                            @endif
                        </div>

                     


                        {{-- DG REMARKS (Read-only) --}}
                        <label class="mt-4"
                            style="background-color: navy; color: white; padding: 4px 8px; border-radius: 4px; width:300px; font-size: 1.2em">
                            DG REMARKS
                        </label>

                        <div class="border p-2"> {!! nl2br(e($report->dg_remarks)) !!} </div>
                        {{-- DG Signature --}}
                        <label class="mt-2">DG Signature</label>

                        <div class="mb-2">
                            @if ($report->dg_signature)
                                <img src="{{ asset('upload/' . $report->dg_signature) }}" alt="DG Signature"
                                    height="80">
                            @else
                                <p><em>No signature provided</em></p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
    </section>
@endsection

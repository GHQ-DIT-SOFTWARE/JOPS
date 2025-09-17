<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Duty Officer Report ‑ PDF</title>
    <style>
        /** General settings **/
        @page {
            margin: 25mm 20mm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        hr {
            border: 0;
            border-top: 1px solid #000;
            margin: 10px 0 20px 0;
        }
        .section-title {
            background-color: #000080; /* navy */
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 1.1em;
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }
        th {
            font-weight: bold;
        }
        ol {
            margin: 0;
            padding-left: 20px;
        }
        .signature-block {
            margin-top: 30px;
        }
        .signature-label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .signature-image {
            height: 80px;
        }
        .read-only-box {
            border: 1px solid #000;
            padding: 10px;
            min-height: 60px;
        }
    </style>
</head>
<body>

    <h2>DUTY OFFICER REPORT</h2>
    <hr>

    {{-- DETAILS --}}
    <table>
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
    <div class="section-title">GENERAL</div>
    <table>
        <tr>
            <th width="30%">1. Security General</th>
            <td>{{ $report->gen_sy_gen }}</td>
        </tr>
        <tr>
            <th>2. Significant Events</th>
            <td>
                @if($report->gen_sig_events)
                    <ol type="a">
                        @foreach(is_array($report->gen_sig_events) ? $report->gen_sig_events : explode("\n", $report->gen_sig_events) as $event)
                            @if(trim($event))
                                <li>{{ trim($event) }}</li>
                            @endif
                        @endforeach
                    </ol>
                @endif
            </td>
        </tr>
    </table>

    {{-- OPS ROOM --}}
    <div class="section-title">OPS ROOM</div>
    <table>
        <tr>
            <th width="30%">3. Comm State</th>
            <td>{{ $report->ops_room_comm_state }}</td>
        </tr>
        <tr>
            <th>4. Messages/Correspondence</th>
            <td>
                @if($report->ops_room_messages)
                    <ol type="a">
                        @foreach(is_array($report->ops_room_messages) ? $report->ops_room_messages : explode("\n", $report->ops_room_messages) as $msg)
                            @if(trim($msg))
                                <li>{{ trim($msg) }}</li>
                            @endif
                        @endforeach
                    </ol>
                @endif
            </td>
        </tr>
        <tr>
            <th>5. Visit to the Ops Room</th>
            <td>
                @if($report->visit_ops_room)
                    <ol type="a">
                        @foreach(is_array($report->visit_ops_room) ? $report->visit_ops_room : explode("\n", $report->visit_ops_room) as $visit)
                            @if(trim($visit))
                                <li>{{ trim($visit) }}</li>
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

    {{-- SITREP CAMP --}}
    <div class="section-title">SITREP ‑ CAMP</div>
    <table>
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
                @if($report->major_event)
                    <ol type="a">
                        @foreach(is_array($report->major_event) ? $report->major_event : explode("\n", $report->major_event) as $ev)
                            @if(trim($ev))
                                <li>{{ trim($ev) }}</li>
                            @endif
                        @endforeach
                    </ol>
                @endif
            </td>
        </tr>
    </table>

    {{-- SITREPS for branches --}}
    @foreach (['army','navy','airforce'] as $branch)
        <div class="section-title">SITREP ‑ {{ strtoupper($branch) }}</div>
        <table>
            <tr>
                <th width="30%">Security General</th>
                <td>{{ $report->{'sitrep_'.$branch.'_sy_gen'} }}</td>
            </tr>
            <tr>
                <th>Significant Events</th>
                <td>
                    @php
                        $field = 'sitrep_'.$branch.'_sig_event';
                        $sig = $report->$field;
                    @endphp
                    @if($sig)
                        <ol type="a">
                            @foreach(is_array($sig) ? $sig : explode("\n", $sig) as $e)
                                @if(trim($e))
                                    <li>{{ trim($e) }}</li>
                                @endif
                            @endforeach
                        </ol>
                    @endif
                </td>
            </tr>
        </table>
    @endforeach

    {{-- MISC --}}
    <div class="section-title">MISC</div>
    <table>
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
                @if($report->major_news_of_military)
                    <ol type="a">
                        @foreach(is_array($report->major_news_of_military) ? $report->major_news_of_military : explode("\n", $report->major_news_of_military) as $news)
                            @if(trim($news))
                                <li>{{ trim($news) }}</li>
                            @endif
                        @endforeach
                    </ol>
                @endif
            </td>
        </tr>
        <tr>
            <th>Admin Gen: Lighting</th>
            <td>{{ $report->admin_gen_lighting }}</td>
            <th>Feeding</th>
            <td>{{ $report->admin_gen_feeding }}</td>
        </tr>
        <tr>
            <th>Welfare</th>
            <td colspan="3">{{ $report->admin_gen_welfare }}</td>
        </tr>
        <tr>
            <th>GHQ Office Keys</th>
            <td colspan="3">
                @if($report->ghq_office_keys)
                    <ol type="a">
                        @foreach(is_array($report->ghq_office_keys) ? $report->ghq_office_keys : explode("\n", $report->ghq_office_keys) as $key)
                            @if(trim($key))
                                <li>{{ trim($key) }}</li>
                            @endif
                        @endforeach
                    </ol>
                @endif
            </td>
        </tr>
        <tr>
            <th>GAF Fire Station</th>
            <td colspan="3">
                @if($report->gaf_fire_station)
                    <ol type="a">
                        @foreach(is_array($report->gaf_fire_station) ? $report->gaf_fire_station : explode("\n", $report->gaf_fire_station) as $station)
                            @if(trim($station))
                                <li>{{ trim($station) }}</li>
                            @endif
                        @endforeach
                    </ol>
                @endif
            </td>
        </tr>
    </table>

    {{-- Additional Information --}}
    <div class="section-title">ADDITIONAL INFORMATION</div>
    @if($report->additional_information)
        <table>
            <tr>
                <td>
                    <ol type="a">
                        @foreach(is_array($report->additional_information) ? $report->additional_information : explode("\n", $report->additional_information) as $info)
                            @if(trim($info))
                                <li>{{ trim($info) }}</li>
                            @endif
                        @endforeach
                    </ol>
                </td>
            </tr>
        </table>
    @endif

    {{-- D LANDS OPS COMMENT --}}
    <div class="section-title">D LANDS OPS COMMENT</div>
    <div class="read-only-box">
        {!! nl2br(e($report->d_land_ops_comment)) !!}
    </div>

    <div class="signature-block">
        <div class="signature-label">D LANDS Signature:</div>
        @if($report->d_land_signature)
            <img class="signature-image" src="{{ public_path('upload/' . $report->d_land_signature) }}" alt="D LANDS Signature">
        @else
            <div><em>No signature provided</em></div>
        @endif
    </div>

    <div class="signature-block">
        <div class="signature-label">DG Signature:</div>
        @if($report->dg_signature)
            <img class="signature-image" src="{{ public_path('upload/' . $report->dg_signature) }}" alt="DG Signature">
        @else
            <div><em>No signature provided</em></div>
        @endif
    </div>

</body>
</html>

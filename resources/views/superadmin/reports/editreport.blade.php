@extends('adminbackend.layouts.master')

<style>
    .wizard-icons .nav-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 12px 10px;
        border-radius: 12px;
        background: #f8f9fa;
        color: #495057;
        font-weight: 500;
        transition: all 0.3s ease-in-out;
    }

    .wizard-icons .nav-link .wizard-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        padding: 10px;
        background: #e9ecef;
        transition: all 0.3s ease-in-out;
    }

    .wizard-icons .nav-link.active {
        background: #28a745;
        color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .wizard-icons .nav-link.active .wizard-icon {
        background: #218838;
        /* darker green */
        filter: brightness(0) invert(1);
        /* turn png icons white */
    }

    .wizard-icons .nav-link:hover {
        transform: translateY(-2px);
        background: #e2f0e9;
    }

    .tab-pane .form-section {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .tab-pane label {
        font-weight: 600;
        color: #333;
    }

    .progress {
        background: #e9ecef;
        border-radius: 50px;
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, #28a745, #20c997);
        transition: width 0.4s ease;
    }


    #summary_content {
        background: #fdfdfd;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    }

    #summary_content h6 {
        color: #28a745;
        font-weight: 700;
        margin-top: 15px;
    }

    /* Wizard Nav Tabs (active step) */
    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #93939382 !important;
        /* SaddleBrown */
        color: #fff !important;
    }




    .wizard-icons .wizard-icon {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
</style>




@section('main')
    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">{{ $nav_title ?? 'Duty Officer Report' }}</h5>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a
                                            href="#!">{{ $nav_title ?? 'Duty Officer Report' }}</a></li>
                                </ul>
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-light mt-2 mt-md-0">← Back
                                    to Page</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->

            <!-- Wizard Form -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Duty Officer Report</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('superadmin.reports.update', $report->id) }}" method="POST"
                            id="reportWizardForm">
                            @csrf
                            @method('PUT')


                            <input type="hidden" id="report_id" name="report_id" value="{{ $report->id ?? '' }}">

                            <div id="progresswizard" class="bt-wizard">


                                <ul class="nav nav-pills nav-fill mb-3 wizard-icons">
                                    <li class="nav-item">
                                        <a href="#tab1" class="nav-link active" data-toggle="tab">
                                            <img src="{{ asset('assets/images/dashicons/work.png') }}" alt="Duty"
                                                class="wizard-icon">
                                            Duty Officer Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tab2" class="nav-link" data-toggle="tab">
                                            <img src="{{ asset('assets/images/dashicons/security.png') }}" alt="General"
                                                class="wizard-icon">
                                            General
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tab3" class="nav-link" data-toggle="tab">
                                            <img src="{{ asset('assets/images/dashicons/opsroom.png') }}" alt="Ops"
                                                class="wizard-icon">
                                            Ops Room
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tab4" class="nav-link" data-toggle="tab">
                                            <img src="{{ asset('assets/images/dashicons/reporting.png') }}" alt="Sitrep"
                                                class="wizard-icon">
                                            Sitrep
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tab5" class="nav-link" data-toggle="tab">
                                            <img src="{{ asset('assets/images/dashicons/cotton.png') }}" alt="Misc"
                                                class="wizard-icon">
                                            Misc
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tab6" class="nav-link" data-toggle="tab">
                                            <img src="{{ asset('assets/images/dashicons/addinfo.png') }}" alt="Additional"
                                                class="wizard-icon">
                                            Additional Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#summary" class="nav-link" data-toggle="tab">
                                            <img src="{{ asset('assets/images/dashicons/summary.png') }}" alt="Summary"
                                                class="wizard-icon">
                                            Summary
                                        </a>
                                    </li>
                                </ul>


                                <!-- Progress Bar -->
                                <div id="bar" class="progress mb-3" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 5%;"></div>
                                </div>



                                <!-- Tab Content -->
                                <div class="tab-content">
                                    <!-- === TAB 1: Duty Officer Info (Edit) === -->
                                    <div class="tab-pane active show" id="tab1">
                                        <div class="row">
                                            <!-- Duty Officer -->
                                            <div class="col-md-6 mb-3">
                                                <label for="duty_officer_display" class="form-label">Duty Officer</label>
                                                <input type="text" id="duty_officer_display" class="form-control"
                                                    value="{{ $report->user?->rank }} {{ $report->user?->fname }}"
                                                    readonly>
                                                <input type="hidden" id="duty_officer" name="duty_officer"
                                                    value="{{ $report->user?->rank }} {{ $report->user?->fname }}">
                                            </div>

                                            <!-- Dept/DTE -->
                                            <div class="col-md-6 mb-3">
                                                <label for="unit_name_display" class="form-label">Dept/DTE</label>
                                                <input type="text" id="unit_name_display" class="form-control"
                                                    value="{{ $report->user?->unit?->unit }}" readonly>
                                                <input type="hidden" id="unit_name" name="unit_name"
                                                    value="{{ $report->user?->unit?->name }}">
                                            </div>

                                            <!-- Contact Number -->
                                            <div class="col-md-6 mb-3">
                                                <label for="phone_display" class="form-label">Contact Number</label>
                                                <input type="text" id="phone_display" class="form-control"
                                                    value="{{ $report->user?->phone }}" readonly>
                                                <input type="hidden" id="phone" name="phone"
                                                    value="{{ $report->user?->phone }}">
                                            </div>

                                            <!-- Reporting Time -->
                                            <div class="col-md-6 mb-3">
                                                <label for="reporting_time" class="form-label">Reporting Time</label>
                                                <input type="time" class="form-control" id="reporting_time"
                                                    name="reporting_time"
                                                    value="{{ old('reporting_time', \Carbon\Carbon::parse($report->reporting_time)->format('H:i')) }}">
                                            </div>

                                            <!-- Period Covered -->
                                            <div class="col-md-12 mb-3">
                                                <label for="period_covered" class="form-label">Period Covered</label>
                                                <input type="text" id="period_covered" name="period_covered"
                                                    class="form-control"
                                                    value="{{ old('period_covered', $report->period_covered) }}"
                                                    placeholder="e.g. 011330Z - 020730Z AUG 25">
                                            </div>
                                        </div>
                                    </div>





                                    <!-- === TAB 2: General (Edit) === -->
                                    <div class="tab-pane" id="tab2">
                                        <!-- Security General -->
                                        <div class="form-group row">
                                            <label for="gen_sy_gen" class="col-sm-3 col-form-label">Security
                                                General</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="gen_sy_gen" name="gen_sy_gen"
                                                    class="form-control"
                                                    value="{{ old('gen_sy_gen', $report->gen_sy_gen) }}"
                                                    placeholder="e.g. Calm">
                                            </div>
                                        </div>

                                        <!-- Significant Events -->
                                        <div class="form-group">
                                            <label>Significant Events</label>
                                            <div class="lettered-list" data-name="gen_sig_events[]"
                                                data-placeholder="Add Event">
                                                @php $events = old('gen_sig_events', $report->gen_sig_events ?? []); @endphp

                                                @forelse($events as $i => $event)
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">{{ chr(97 + $i) }}.</div>
                                                        <div class="col">
                                                            <label for="gen_sig_events_{{ $i }}"
                                                                class="sr-only">Event {{ $i + 1 }}</label>
                                                            <input type="text" id="gen_sig_events_{{ $i }}"
                                                                name="gen_sig_events[]" value="{{ $event }}"
                                                                class="form-control" placeholder="Add Event">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-{{ $i === 0 ? 'success add-next' : 'danger remove-letter' }}">
                                                                {{ $i === 0 ? '+' : 'Remove' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <label for="gen_sig_events_0" class="sr-only">Event 1</label>
                                                            <input type="text" id="gen_sig_events_0"
                                                                name="gen_sig_events[]" class="form-control"
                                                                placeholder="Add Event">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-success add-next">+</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>






                                    <!-- === TAB 3: Ops Room (Edit) === -->
                                    <div class="tab-pane" id="tab3">
                                        <!-- Communication State -->
                                        <div class="form-group row">
                                            <label for="ops_room_comm_state" class="col-sm-3 col-form-label">Communication
                                                State</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="ops_room_comm_state" name="ops_room_comm_state"
                                                    class="form-control"
                                                    value="{{ old('ops_room_comm_state', $report->ops_room_comm_state) }}"
                                                    placeholder="Satisfactory">
                                            </div>
                                        </div>

                                        <!-- Messages / Correspondences -->
                                        <div class="form-group">
                                            <label>Messages / Correspondences Received</label>
                                            <div class="lettered-list" data-name="ops_room_messages[]"
                                                data-placeholder="Add Message">
                                                @php $messages = old('ops_room_messages', $report->ops_room_messages ?? []); @endphp
                                                @forelse($messages as $i => $msg)
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">{{ chr(97 + $i) }}.</div>
                                                        <div class="col">
                                                            <label for="ops_room_messages_{{ $i }}"
                                                                class="sr-only">Message {{ $i + 1 }}</label>
                                                            <input type="text"
                                                                id="ops_room_messages_{{ $i }}"
                                                                name="ops_room_messages[]" value="{{ $msg }}"
                                                                class="form-control" placeholder="Add Message">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-{{ $i === 0 ? 'success add-next' : 'danger remove-letter' }}">
                                                                {{ $i === 0 ? '+' : 'Remove' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <label for="ops_room_messages_0" class="sr-only">Message
                                                                1</label>
                                                            <input type="text" id="ops_room_messages_0"
                                                                name="ops_room_messages[]" class="form-control"
                                                                placeholder="Add Message">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-success add-next">+</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <!-- Visit Ops Room -->
                                        <div class="form-group">
                                            <label>Visit Ops Room</label>
                                            <div class="lettered-list" data-name="visit_ops_room[]"
                                                data-placeholder="Add Visit">
                                                @php $visits = old('visit_ops_room', $report->visit_ops_room ?? []); @endphp
                                                @forelse($visits as $i => $visit)
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">{{ chr(97 + $i) }}.</div>
                                                        <div class="col">
                                                            <label for="visit_ops_room_{{ $i }}"
                                                                class="sr-only">Visit {{ $i + 1 }}</label>
                                                            <input type="text" id="visit_ops_room_{{ $i }}"
                                                                name="visit_ops_room[]" value="{{ $visit }}"
                                                                class="form-control" placeholder="Add Visit">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-{{ $i === 0 ? 'success add-next' : 'danger remove-letter' }}">
                                                                {{ $i === 0 ? '+' : 'Remove' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <label for="visit_ops_room_0" class="sr-only">Visit 1</label>
                                                            <input type="text" id="visit_ops_room_0"
                                                                name="visit_ops_room[]" class="form-control"
                                                                placeholder="Add Visit">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-success add-next">+</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <!-- Ops Room Photocopier -->
                                        <div class="form-group">
                                            <label><strong>Ops Room Photocopier</strong></label>

                                            <div class="form-group row align-items-center mb-2">
                                                <label for="photocopier_taking_over"
                                                    class="col-sm-1 col-form-label text-right">a.</label>
                                                <label for="photocopier_taking_over"
                                                    class="col-sm-2 col-form-label">Taking Over</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="photocopier_taking_over"
                                                        name="photocopier_taking_over" class="form-control"
                                                        value="{{ old('photocopier_taking_over', $report->photocopier_taking_over) }}"
                                                        placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center mb-2">
                                                <label for="photocopier_handing_over"
                                                    class="col-sm-1 col-form-label text-right">b.</label>
                                                <label for="photocopier_handing_over"
                                                    class="col-sm-2 col-form-label">Handing Over</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="photocopier_handing_over"
                                                        name="photocopier_handing_over" class="form-control"
                                                        value="{{ old('photocopier_handing_over', $report->photocopier_handing_over) }}"
                                                        placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <!-- === TAB 4: SITREP - CAMP (Edit) === -->
                                    <div class="tab-pane" id="tab4">
                                        <div class="row">
                                            <!-- Security General -->
                                            <div class="col-md-12 mb-3">
                                                <label for="sitrep_camp_sy_gen">Security General</label>
                                                <input type="text" id="sitrep_camp_sy_gen" name="sitrep_camp_sy_gen"
                                                    class="form-control"
                                                    value="{{ old('sitrep_camp_sy_gen', $report->sitrep_camp_sy_gen) }}"
                                                    placeholder="e.g. Calm">
                                            </div>

                                            <!-- Main Gate -->
                                            <div class="col-md-6 mb-3">
                                                <label for="sitrep_camp_main_gate">Main Gate</label>
                                                <input type="text" id="sitrep_camp_main_gate"
                                                    name="sitrep_camp_main_gate" class="form-control"
                                                    value="{{ old('sitrep_camp_main_gate', $report->sitrep_camp_main_gate) }}"
                                                    placeholder="e.g. NTR">
                                            </div>

                                            <!-- Comd Gate -->
                                            <div class="col-md-6 mb-3">
                                                <label for="sitrep_camp_command_gate">Comd Gate</label>
                                                <input type="text" id="sitrep_camp_command_gate"
                                                    name="sitrep_camp_command_gate" class="form-control"
                                                    value="{{ old('sitrep_camp_command_gate', $report->sitrep_camp_command_gate) }}"
                                                    placeholder="e.g. NTR">
                                            </div>

                                            <!-- Congo Junction -->
                                            <div class="col-md-6 mb-3">
                                                <label for="sitrep_camp_congo_junction">Congo Junction</label>
                                                <input type="text" id="sitrep_camp_congo_junction"
                                                    name="sitrep_camp_congo_junction" class="form-control"
                                                    value="{{ old('sitrep_camp_congo_junction', $report->sitrep_camp_congo_junction) }}"
                                                    placeholder="e.g. NTR">
                                            </div>

                                            <!-- GAFPO -->
                                            <div class="col-md-6 mb-3">
                                                <label for="sitrep_camp_gafto">GAFPO</label>
                                                <input type="text" id="sitrep_camp_gafto" name="sitrep_camp_gafto"
                                                    class="form-control"
                                                    value="{{ old('sitrep_camp_gafto', $report->sitrep_camp_gafto) }}"
                                                    placeholder="e.g. NTR">
                                            </div>

                                            <!-- Major Events -->
                                            <div class="col-md-12 mb-3">
                                                <label>Major Events</label>
                                                <div class="lettered-list" data-name="major_event[]"
                                                    data-placeholder="Add Event">
                                                    @php $campEvents = old('major_event', $report->major_event ?? []); @endphp
                                                    @forelse($campEvents as $i => $ev)
                                                        <div class="form-row align-items-center letter-row mb-2">
                                                            <div class="col-auto letter-label">{{ chr(97 + $i) }}.</div>
                                                            <div class="col">
                                                                <label for="major_event_{{ $i }}"
                                                                    class="sr-only">Event {{ $i + 1 }}</label>
                                                                <input type="text"
                                                                    id="major_event_{{ $i }}"
                                                                    name="major_event[]" value="{{ $ev }}"
                                                                    class="form-control" placeholder="Add Event">
                                                            </div>
                                                            <div class="col-auto">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-{{ $i === 0 ? 'success add-next' : 'danger remove-letter' }}">
                                                                    {{ $i === 0 ? '+' : 'Remove' }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="form-row align-items-center letter-row mb-2">
                                                            <div class="col-auto letter-label">a.</div>
                                                            <div class="col">
                                                                <label for="major_event_0" class="sr-only">Event 1</label>
                                                                <input type="text" id="major_event_0"
                                                                    name="major_event[]" class="form-control"
                                                                    placeholder="Add Event">
                                                            </div>
                                                            <div class="col-auto">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-success add-next">+</button>
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>

                                        <!-- SITREP - Army -->
                                        <label><strong>SITREP - Army</strong></label>
                                        <div class="form-group row">
                                            <label for="sitrep_army_sy_gen" class="col-sm-3 col-form-label">Security
                                                General</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="sitrep_army_sy_gen" name="sitrep_army_sy_gen"
                                                    class="form-control"
                                                    value="{{ old('sitrep_army_sy_gen', $report->sitrep_army_sy_gen) }}"
                                                    placeholder="e.g. Calm">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Sitrep Army Significant Events</label>
                                            <div class="lettered-list" data-name="sitrep_army_sig_event[]"
                                                data-placeholder="Add Event">
                                                @php $army = old('sitrep_army_sig_event', $report->sitrep_army_sig_event ?? []); @endphp
                                                @forelse($army as $i => $ev)
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">{{ chr(97 + $i) }}.</div>
                                                        <div class="col">
                                                            <label for="sitrep_army_sig_event_{{ $i }}"
                                                                class="sr-only">Army Event {{ $i + 1 }}</label>
                                                            <input type="text"
                                                                id="sitrep_army_sig_event_{{ $i }}"
                                                                name="sitrep_army_sig_event[]"
                                                                value="{{ $ev }}" class="form-control"
                                                                placeholder="Add Event">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-{{ $i === 0 ? 'success add-next' : 'danger remove-letter' }}">
                                                                {{ $i === 0 ? '+' : 'Remove' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <label for="sitrep_army_sig_event_0" class="sr-only">Army
                                                                Event 1</label>
                                                            <input type="text" id="sitrep_army_sig_event_0"
                                                                name="sitrep_army_sig_event[]" class="form-control"
                                                                placeholder="Add Event">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-success add-next">+</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <!-- SITREP - Navy -->
                                        <label><strong>SITREP - Navy</strong></label>
                                        <div class="form-group row">
                                            <label for="sitrep_navy_sy_gen" class="col-sm-3 col-form-label">Security
                                                General</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="sitrep_navy_sy_gen" name="sitrep_navy_sy_gen"
                                                    class="form-control"
                                                    value="{{ old('sitrep_navy_sy_gen', $report->sitrep_navy_sy_gen) }}"
                                                    placeholder="e.g. Calm">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Sitrep Navy Significant Events</label>
                                            <div class="lettered-list" data-name="sitrep_navy_sig_event[]"
                                                data-placeholder="Add Event">
                                                @php $navy = old('sitrep_navy_sig_event', $report->sitrep_navy_sig_event ?? []); @endphp
                                                @forelse($navy as $i => $ev)
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">{{ chr(97 + $i) }}.</div>
                                                        <div class="col">
                                                            <label for="sitrep_navy_sig_event_{{ $i }}"
                                                                class="sr-only">Navy Event {{ $i + 1 }}</label>
                                                            <input type="text"
                                                                id="sitrep_navy_sig_event_{{ $i }}"
                                                                name="sitrep_navy_sig_event[]"
                                                                value="{{ $ev }}" class="form-control"
                                                                placeholder="Add Event">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-{{ $i === 0 ? 'success add-next' : 'danger remove-letter' }}">
                                                                {{ $i === 0 ? '+' : 'Remove' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <label for="sitrep_navy_sig_event_0" class="sr-only">Navy
                                                                Event 1</label>
                                                            <input type="text" id="sitrep_navy_sig_event_0"
                                                                name="sitrep_navy_sig_event[]" class="form-control"
                                                                placeholder="Add Event">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-success add-next">+</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <!-- SITREP - Airforce -->
                                        <label><strong>SITREP - Airforce</strong></label>
                                        <div class="form-group row">
                                            <label for="sitrep_airforce_sy_gen" class="col-sm-3 col-form-label">Security
                                                General</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="sitrep_airforce_sy_gen"
                                                    name="sitrep_airforce_sy_gen" class="form-control"
                                                    value="{{ old('sitrep_airforce_sy_gen', $report->sitrep_airforce_sy_gen) }}"
                                                    placeholder="e.g. Calm">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Sitrep Airforce Significant Events</label>
                                            <div class="lettered-list" data-name="sitrep_airforce_sig_event[]"
                                                data-placeholder="Add Event">
                                                @php $airforce = old('sitrep_airforce_sig_event', $report->sitrep_airforce_sig_event ?? []); @endphp
                                                @forelse($airforce as $i => $ev)
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">{{ chr(97 + $i) }}.</div>
                                                        <div class="col">
                                                            <label for="sitrep_airforce_sig_event_{{ $i }}"
                                                                class="sr-only">Airforce Event {{ $i + 1 }}</label>
                                                            <input type="text"
                                                                id="sitrep_airforce_sig_event_{{ $i }}"
                                                                name="sitrep_airforce_sig_event[]"
                                                                value="{{ $ev }}" class="form-control"
                                                                placeholder="Add Event">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-{{ $i === 0 ? 'success add-next' : 'danger remove-letter' }}">
                                                                {{ $i === 0 ? '+' : 'Remove' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <label for="sitrep_airforce_sig_event_0"
                                                                class="sr-only">Airforce Event 1</label>
                                                            <input type="text" id="sitrep_airforce_sig_event_0"
                                                                name="sitrep_airforce_sig_event[]" class="form-control"
                                                                placeholder="Add Event">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-success add-next">+</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>



                                    <!-- === TAB 5: MISC (Edit) === -->
                                    <div class="tab-pane" id="tab5">
                                        <!-- Duty Vehicle -->
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group">
                                                <label for="misc_duty_veh_note">Duty Vehicle</label>
                                                <textarea id="misc_duty_veh_note" name="misc_duty_veh_note" class="form-control" rows="3">
                {{ old('misc_duty_veh_note', $report->misc_duty_veh_note) }}
            </textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">a.</label>
                                                <label for="misc_duty_veh_taking_over"
                                                    class="col-sm-2 col-form-label">Taking Over</label>
                                                <div class="col-sm-9">
                                                    <input id="misc_duty_veh_taking_over" type="text"
                                                        name="misc_duty_veh_taking_over" class="form-control"
                                                        value="{{ old('misc_duty_veh_taking_over', $report->misc_duty_veh_taking_over) }}"
                                                        placeholder="e.g. Taking Over - 453425635">
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">b.</label>
                                                <label for="misc_duty_veh_handing_over"
                                                    class="col-sm-2 col-form-label">Handing Over</label>
                                                <div class="col-sm-9">
                                                    <input id="misc_duty_veh_handing_over" type="text"
                                                        name="misc_duty_veh_handing_over" class="form-control"
                                                        value="{{ old('misc_duty_veh_handing_over', $report->misc_duty_veh_handing_over) }}"
                                                        placeholder="e.g. Handing Over - 453425709">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Major News of Military -->
                                        <div class="form-group">
                                            <label>Major News of Military</label>
                                            <div class="lettered-list" data-name="major_news_of_military[]"
                                                data-placeholder="Add News">
                                                @php $news = old('major_news_of_military', $report->major_news_of_military ?? []); @endphp
                                                @forelse($news as $i => $item)
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">{{ chr(97 + $i) }}.</div>
                                                        <div class="col">
                                                            <label for="major_news_of_military_{{ $i }}"
                                                                class="sr-only">News {{ $i + 1 }}</label>
                                                            <input id="major_news_of_military_{{ $i }}"
                                                                type="text" name="major_news_of_military[]"
                                                                value="{{ $item }}" class="form-control"
                                                                placeholder="Add News">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-{{ $i === 0 ? 'success add-next' : 'danger remove-letter' }}">
                                                                {{ $i === 0 ? '+' : 'Remove' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <label for="major_news_of_military_0" class="sr-only">News
                                                                1</label>
                                                            <input id="major_news_of_military_0" type="text"
                                                                name="major_news_of_military[]" class="form-control"
                                                                placeholder="Add News">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-success add-next">+</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <!-- Admin General -->
                                        <div class="form-group">
                                            <label><strong>Admin General</strong></label>

                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">a.</label>
                                                <label for="admin_gen_lighting"
                                                    class="col-sm-2 col-form-label">Lighting</label>
                                                <div class="col-sm-9">
                                                    <input id="admin_gen_lighting" type="text"
                                                        name="admin_gen_lighting" class="form-control"
                                                        value="{{ old('admin_gen_lighting', $report->admin_gen_lighting) }}"
                                                        placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">b.</label>
                                                <label for="admin_gen_feeding"
                                                    class="col-sm-2 col-form-label">Feeding</label>
                                                <div class="col-sm-9">
                                                    <input id="admin_gen_feeding" type="text" name="admin_gen_feeding"
                                                        class="form-control"
                                                        value="{{ old('admin_gen_feeding', $report->admin_gen_feeding) }}"
                                                        placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">c.</label>
                                                <label for="admin_gen_welfare"
                                                    class="col-sm-2 col-form-label">Welfare</label>
                                                <div class="col-sm-9">
                                                    <input id="admin_gen_welfare" type="text" name="admin_gen_welfare"
                                                        class="form-control"
                                                        value="{{ old('admin_gen_welfare', $report->admin_gen_welfare) }}"
                                                        placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- GHQ Office Keys -->
                                        <div class="form-group">
                                            <label>GHQ Office Keys (Sy)</label>
                                            <div class="lettered-list" data-name="ghq_office_keys[]"
                                                data-placeholder="Add Key Info">
                                                @php $keys = old('ghq_office_keys', $report->ghq_office_keys ?? []); @endphp
                                                @forelse($keys as $i => $key)
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">{{ chr(97 + $i) }}.</div>
                                                        <div class="col">
                                                            <label for="ghq_office_keys_{{ $i }}"
                                                                class="sr-only">Key {{ $i + 1 }}</label>
                                                            <input id="ghq_office_keys_{{ $i }}"
                                                                type="text" name="ghq_office_keys[]"
                                                                value="{{ $key }}" class="form-control"
                                                                placeholder="Add Key Info">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-{{ $i === 0 ? 'success add-next' : 'danger remove-letter' }}">
                                                                {{ $i === 0 ? '+' : 'Remove' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <label for="ghq_office_keys_0" class="sr-only">Key 1</label>
                                                            <input id="ghq_office_keys_0" type="text"
                                                                name="ghq_office_keys[]" class="form-control"
                                                                placeholder="Add Key Info">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-success add-next">+</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <!-- GAF Fire Station -->
                                        <div class="form-group">
                                            <label>GAF Fire Station</label>
                                            <div class="lettered-list" data-name="gaf_fire_station[]"
                                                data-placeholder="Add Info">
                                                @php $fires = old('gaf_fire_station', $report->gaf_fire_station ?? []); @endphp
                                                @forelse($fires as $i => $fire)
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">{{ chr(97 + $i) }}.</div>
                                                        <div class="col">
                                                            <label for="gaf_fire_station_{{ $i }}"
                                                                class="sr-only">Fire {{ $i + 1 }}</label>
                                                            <input id="gaf_fire_station_{{ $i }}"
                                                                type="text" name="gaf_fire_station[]"
                                                                value="{{ $fire }}" class="form-control"
                                                                placeholder="Add Info">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-{{ $i === 0 ? 'success add-next' : 'danger remove-letter' }}">
                                                                {{ $i === 0 ? '+' : 'Remove' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <label for="gaf_fire_station_0" class="sr-only">Fire 1</label>
                                                            <input id="gaf_fire_station_0" type="text"
                                                                name="gaf_fire_station[]" class="form-control"
                                                                placeholder="Add Info">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-success add-next">+</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>



                                    <!-- === TAB 6: Additional Information (Edit) === -->
                                    <div class="tab-pane" id="tab6">
                                        <div class="form-group">
                                            <label>Additional Information</label>
                                            <div class="lettered-list" data-name="additional_information[]"
                                                data-placeholder="Add Info">
                                                @php $infos = old('additional_information', $report->additional_information ?? []); @endphp
                                                @forelse($infos as $i => $info)
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">{{ chr(97 + $i) }}.</div>
                                                        <div class="col">
                                                            <label for="additional_information_{{ $i }}"
                                                                class="sr-only">Additional Info
                                                                {{ $i + 1 }}</label>
                                                            <input id="additional_information_{{ $i }}"
                                                                type="text" name="additional_information[]"
                                                                value="{{ $info }}" class="form-control"
                                                                placeholder="Add Info">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-{{ $i === 0 ? 'success add-next' : 'danger remove-letter' }}">
                                                                {{ $i === 0 ? '+' : 'Remove' }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <label for="additional_information_0"
                                                                class="sr-only">Additional Info 1</label>
                                                            <input id="additional_information_0" type="text"
                                                                name="additional_information[]" class="form-control"
                                                                placeholder="Add Info">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-success add-next">+</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>

                                    <!-- === SUMMARY TAB === -->
                                    <div class="tab-pane" id="summary">
                                        <div id="summary_content" class="p-3"
                                            style="white-space:pre-line; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial;">
                                            <h5 class="mb-3">Duty Officer Report - Summary</h5>
                                            <div id="summary_render"></div> <!-- JS injects summary here -->
                                        </div>
                                    </div>

                                    <!-- Wizard Navigation Buttons -->
                                    <div class="row justify-content-between mt-3">
                                        <div class="col-sm-6">
                                            <button type="button"
                                                class="btn btn-primary button-previous">Previous</button>
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <button type="button" class="btn btn-primary button-next">Next</button>
                                            <button type="submit" id="submitBtn"
                                                class="btn btn-success d-none button-finish">Submit</button>


                                        </div>
                                    </div>


                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </section>

    <!-- Keep these (jQuery + Bootstrap 4 + Wizard plugin) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap-wizard/1.2/jquery.bootstrap.wizard.min.js">
    </script>



    <script>
$(function() {
    const reportId = $('#report_id').val() || null;
    const isEdit = !!reportId;

    const $wizard = $('#progresswizard');
    const $form = $('#reportWizardForm');
    const $submitBtn = $('#submitBtn');
    const $prevBtn = $('.button-previous');
    const $nextBtn = $('.button-next');

    // ---------------- Wizard Init ----------------
    $wizard.bootstrapWizard({
        nextSelector: '.button-next',
        previousSelector: '.button-previous',

        onTabShow: function(tab, nav, index) {
            const total = nav.find('li').length;
            const current = index + 1;
            const percent = (current / total) * 100;
            $wizard.find('.progress-bar').css({ width: percent + '%' });

            $prevBtn.toggleClass('d-none', index === 0);
            const isLast = index === total - 1;
            $nextBtn.toggleClass('d-none', isLast);
            $submitBtn.toggleClass('d-none', !isLast);

            if (isLast) renderSummary();
        },

        onTabClick: function(tab, nav, index) {
            const href = nav.find('a').eq(index).attr('href');
            return href !== '#summary'; // prevent direct click to summary
        }
    });

    // ---------------- Lettered Lists ----------------
    function indexToLabel(index) {
        index++;
        let s = '';
        while (index > 0) {
            const rem = (index - 1) % 26;
            s = String.fromCharCode(97 + rem) + s;
            index = Math.floor((index - 1) / 26);
        }
        return s;
    }

    function relabel($container) {
        $container.find('.letter-row').each(function(i) {
            $(this).find('.letter-label').text(indexToLabel(i) + '.');
        });
    }

    function updateRemoveButtons($container) {
        const $rows = $container.find('.letter-row');
        $rows.find('.remove-letter').prop('disabled', false);
        if ($rows.length) $rows.first().find('.remove-letter').prop('disabled', true);
    }

    function initAllLists() {
        $('.lettered-list').each(function() {
            const $c = $(this);
            relabel($c);
            updateRemoveButtons($c);
        });
    }
    initAllLists();

    // Add new row
    $(document).on('click', '.add-next', function() {
        const $container = $(this).closest('.lettered-list');
        const $rows = $container.find('.letter-row');
        const nextLabel = indexToLabel($rows.length) + '.';
        const name = $container.data('name');
        const placeholder = $container.data('placeholder') || '';

        const $row = $(`
            <div class="form-row align-items-center letter-row mb-2">
                <div class="col-auto letter-label">${nextLabel}</div>
                <div class="col">
                    <input type="text" name="${name}" class="form-control" placeholder="${placeholder}">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-danger remove-letter">Remove</button>
                </div>
            </div>
        `);
        $container.append($row);
        relabel($container);
        updateRemoveButtons($container);
    });

    // Remove row
    $(document).on('click', '.remove-letter', function() {
        const $container = $(this).closest('.lettered-list');
        $(this).closest('.letter-row').remove();
        relabel($container);
        updateRemoveButtons($container);
    });

    // ---------------- Summary Renderer ----------------
    function renderSummary() {
        let html = '';
        const form = $form[0];

        function renderLetteredList(selector) {
            const lines = [];
            form.querySelectorAll(selector).forEach(el => {
                if (el.value.trim()) lines.push(el.value.trim());
            });
            if (!lines.length) return '';
            return `<ol type="a" style="padding-left: 20px; margin:0;">${lines.map(l => `<li>${l}</li>`).join('')}</ol>`;
        }

        // Duty Officer Info
        html += `<h6>1. Duty Officer Info</h6>`;
        html += `<p><strong>Duty Officer:</strong> ${form.duty_officer?.value || ''}</p>`;
        html += `<p><strong>Dept/DTE:</strong> ${form.unit_name?.value || ''}</p>`;
        html += `<p><strong>Reporting Time:</strong> ${form.reporting_time?.value || ''}</p>`;
        html += `<p><strong>Contact Number:</strong> ${form.phone?.value || ''}</p>`;
        html += `<p><strong>Period Covered:</strong> ${form.period_covered?.value || ''}</p>`;

        // General
        html += `<h6 class='mt-3'>2. General</h6>`;
        html += `<p><strong>Sy Gen:</strong> ${form.gen_sy_gen?.value || ''}</p>`;
        html += `<p><strong>Significant Events:</strong> ${renderLetteredList('[name="gen_sig_events[]"]')}</p>`;

        // Ops Room
        html += `<h6 class='mt-3'>3. Ops Room</h6>`;
        html += `<p><strong>Comm State:</strong> ${form.ops_room_comm_state?.value || ''}</p>`;
        html += `<p><strong>Messages:</strong> ${renderLetteredList('[name="ops_room_messages[]"]')}</p>`;
        html += `<p><strong>Visits:</strong> ${renderLetteredList('[name="visit_ops_room[]"]')}</p>`;
        html += `<p><strong>Photocopier Taking Over:</strong> ${form.photocopier_taking_over?.value || ''}</p>`;
        html += `<p><strong>Photocopier Handing Over:</strong> ${form.photocopier_handing_over?.value || ''}</p>`;

        // SITREP Camp
        html += `<h6 class='mt-3'>4. SITREP - Camp</h6>`;
        html += `<p><strong>Sy Gen:</strong> ${form.sitrep_camp_sy_gen?.value || ''}</p>`;
        html += `<p><strong>Main Gate:</strong> ${form.sitrep_camp_main_gate?.value || ''}</p>`;
        html += `<p><strong>Comd Gate:</strong> ${form.sitrep_camp_command_gate?.value || ''}</p>`;
        html += `<p><strong>Congo Junction:</strong> ${form.sitrep_camp_congo_junction?.value || ''}</p>`;
        html += `<p><strong>GAFPO:</strong> ${form.sitrep_camp_gafto?.value || ''}</p>`;
        html += `<p><strong>Major Events:</strong> ${renderLetteredList('[name="major_event[]"]')}</p>`;

        ['army', 'navy', 'airforce'].forEach((branch, i) => {
            const branchName = branch.charAt(0).toUpperCase() + branch.slice(1);
            html += `<h6 class='mt-3'>${i + 5}. SITREP - ${branchName}</h6>`;
            html += `<p><strong>Sy Gen:</strong> ${form[`sitrep_${branch}_sy_gen`]?.value || ''}</p>`;
            html += `<p><strong>Significant Events:</strong> ${renderLetteredList(`[name="sitrep_${branch}_sig_event[]"]`)}</p>`;
        });

        // Misc
        html += `<h6 class='mt-3'>8. Misc</h6>`;
        html += `<p><strong>Duty Veh Note:</strong> ${form.misc_duty_veh_note?.value || ''}</p>`;
        html += `<p><strong>Taking Over Odometer:</strong> ${form.misc_duty_veh_taking_over?.value || ''}</p>`;
        html += `<p><strong>Handing Over Odometer:</strong> ${form.misc_duty_veh_handing_over?.value || ''}</p>`;
        html += `<p><strong>Major News:</strong> ${renderLetteredList('[name="major_news_of_military[]"]')}</p>`;
        html += `<p><strong>Admin Gen:</strong> Lighting: ${form.admin_gen_lighting?.value || ''}, Feeding: ${form.admin_gen_feeding?.value || ''}, Welfare: ${form.admin_gen_welfare?.value || ''}</p>`;
        html += `<p><strong>GHQ Office Keys:</strong> ${renderLetteredList('[name="ghq_office_keys[]"]')}</p>`;
        html += `<p><strong>GAF Fire Station:</strong> ${renderLetteredList('[name="gaf_fire_station[]"]')}</p>`;

        // Additional Info
        html += `<h6 class='mt-3'>9. Additional Information</h6>`;
        html += renderLetteredList('[name="additional_information[]"]');

        $('#summary_render').html(html);
    }

    // ---------------- Final Submit ----------------
    $form.on('submit', function(e) {
    e.preventDefault();
    $submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Submitting...');

    const formData = new FormData(this);
    const reportId = $('#report_id').val();

    // Step 1: Update the report
    $.ajax({
        url: $form.attr('action'),
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-HTTP-Method-Override': 'PUT'
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            // Step 2: Submit the report (mark as submitted)
            $.post('{{ route("superadmin.reports.submit") }}', { report_id: reportId, _token: '{{ csrf_token() }}' }, function(submitRes) {
                if (submitRes.success) {
                    window.location.href = submitRes.redirect;
                } else {
                    $submitBtn.prop('disabled', false).html('Submit');
                }
            }).fail(function() {
                alert('Error submitting the report.');
                $submitBtn.prop('disabled', false).html('Submit');
            });
        },
        error: function(xhr) {
            // Handle validation errors here (422)
            $submitBtn.prop('disabled', false).html('Submit');
        }
    });
});

});
</script>

@endsection

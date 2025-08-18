@extends('adminbackend.layouts.master')


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
                        <form id="dutyReportForm" action="#" method="POST">
                            @csrf

                            <div id="progresswizard" class="bt-wizard">

                                <!-- Wizard Nav Tabs -->
                                <ul class="nav nav-pills nav-fill mb-3">
                                    <li class="nav-item"><a href="#tab1" class="nav-link active" data-toggle="tab">1. Duty
                                            Officer Info</a></li>
                                    <li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">2. General</a>
                                    </li>
                                    <li class="nav-item"><a href="#tab3" class="nav-link" data-toggle="tab">3. Ops
                                            Room</a></li>
                                    <li class="nav-item"><a href="#tab4" class="nav-link" data-toggle="tab">4. Sitrep</a>
                                    </li>
                                    <li class="nav-item"><a href="#tab5" class="nav-link" data-toggle="tab">5. Misc</a>
                                    </li>
                                    <li class="nav-item"><a href="#tab6" class="nav-link" data-toggle="tab">6. Additional
                                            Info</a></li>
                                    <li class="nav-item"><a href="#summary" class="nav-link" data-toggle="tab">Summary</a>
                                    </li>
                                </ul>

                                <!-- Progress Bar -->
                                <div id="bar" class="progress mb-3" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: 5%;"></div>
                                </div>

                                <!-- Tab Content -->
                                <div class="tab-content">
                                    <!-- === TAB 1: Duty Officer Info === -->

                                    <div class="tab-pane active show" id="tab1">
                                        <!-- Duty Officer (readonly, prefilled) -->
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Duty Officer</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="duty_officer" class="form-control"
                                                    value="{{ $user->rank }} {{ $user->fname }}" readonly>
                                            </div>
                                        </div>

                                        <!-- Dept/DTE (readonly, prefilled) -->
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Dept/DTE</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="unit" class="form-control"
                                                    value="{{ $user->unit }}" readonly>
                                            </div>
                                        </div>

                                        <!-- Reporting Time (editable) -->
<div class="form-group row">
    <label class="col-sm-3 col-form-label">Reporting Time</label>
    <div class="col-sm-9">
        <input 
            type="time" 
            name="reporting_time" 
            class="form-control"
            value="13:30"
            step="60"
        >
    </div>
</div>




                                        <!-- Contact Number (readonly, prefilled) -->
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Contact Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="phone" class="form-control"
                                                    value="{{ $user->phone }}" readonly>
                                            </div>
                                        </div>

                                        <!-- Period Covered (editable) -->
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Period Covered</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="period_covered" class="form-control"
                                                    placeholder="e.g. 011330Z - 020730Z AUG 25">
                                            </div>
                                        </div>
                                    </div>


                                    <!-- === TAB 2: General === -->
                                    <div class="tab-pane" id="tab2">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Sy Gen</label>
                                            <div class="col-sm-9"><input type="text" name="gen_sy_gen"
                                                    class="form-control" placeholder="e.g. Calm"></div>
                                        </div>
                                        <div class="form-group">
                                            <label>Significant Event</label>
                                            <div id="sig_events_list" class="lettered-list" data-section="sig_events">
                                                <!-- initial row (a) -->
                                                <div class="form-row align-items-center letter-row mb-2">
                                                    <div class="col-auto letter-label">a.</div>
                                                    <div class="col">
                                                        <input type="text" name="gen_sig_event[]" class="form-control"
                                                            placeholder="e.g. Event A">
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-sm btn-danger remove-letter"
                                                            disabled>Remove</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2 add-next"
                                                data-target="#sig_events_list">Add Next</button>
                                        </div>
                                    </div>



                                    <!-- === TAB 3: Ops Room (with messages lettered list) === -->
                                    <div class="tab-pane" id="tab3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Comm State</label>
                                            <div class="col-sm-9"><input type="text" name="ops_room_comm_state"
                                                    class="form-control" placeholder="Satisfactory"></div>
                                        </div>

                                        <div class="form-group">
                                            <label>Messages / Correspondences Received</label>
                                            <div id="messages_list" class="lettered-list" data-section="messages">
                                                <!-- initial row (a) -->
                                                <div class="form-row align-items-center letter-row mb-2">
                                                    <div class="col-auto letter-label">a.</div>
                                                    <div class="col">
                                                        <input type="text" name="ops_room_messages[]"
                                                            class="form-control"
                                                            placeholder="e.g. ARMY HQ - OPS/1296 ...">
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-sm btn-danger remove-letter"
                                                            disabled>Remove</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2 add-next"
                                                data-target="#messages_list">Add Next</button>

                                        </div>

                                        <div class="form-group">
                                            <label>Visits to Ops Room</label>
                                            <textarea name="visit_ops_room" class="form-control" rows="3"
                                                placeholder="e.g. Lt Col JM Gbog visited at 1410 hrs"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Ops Room Photocopier</strong></label>

                                            <!-- a. Taking Over -->
                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">a.</label>
                                                <label class="col-sm-2 col-form-label">Taking Over</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="photocopier_taking_over"
                                                        class="form-control" placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>

                                            <!-- b. Handing Over -->
                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">b.</label>
                                                <label class="col-sm-2 col-form-label">Handing Over</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="photocopier_handing_over"
                                                        class="form-control" placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- === TAB 4: SITREP - CAMP (lettered list) === -->

                                    <div class="tab-pane" id="tab4">
                                        <label><strong>SITREP - Camp</strong></label>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Sy Gen</label>
                                            <div class="col-sm-9"><input type="text" name="sitrep_camp_sy_gen"
                                                    class="form-control" placeholder="e.g. Calm"></div>
                                        </div>

                                        <div class="form-group">


                                            <!-- a. Main Gate -->
                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">a.</label>
                                                <label class="col-sm-2 col-form-label">Main Gate</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="sitrep_camp_main_gate"
                                                        class="form-control" placeholder="e.g. NTR">
                                                </div>
                                            </div>

                                            <!-- b. Comd Gate -->
                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">b.</label>
                                                <label class="col-sm-2 col-form-label">Comd Gate</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="sitrep_camp_command_gate"
                                                        class="form-control" placeholder="e.g. NTR">
                                                </div>
                                            </div>

                                            <!-- c. Congo Junction -->
                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">c.</label>
                                                <label class="col-sm-2 col-form-label">Congo Junction</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="sitrep_camp_congo_junction"
                                                        class="form-control" placeholder="e.g. NTR">
                                                </div>
                                            </div>

                                            <!-- d. GAFTO -->
                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">d.</label>
                                                <label class="col-sm-2 col-form-label">GAFTO</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="sitrep_camp_gafto" class="form-control"
                                                        placeholder="e.g. NTR">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label>Major Events</label>
                                            <textarea name="major_event[]" class="form-control" rows="4" placeholder="e.g. Nil"></textarea>
                                        </div>

                                        <!-- SITREP - Army -->
                                        <label><strong>SITREP - Army</strong></label>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Sy Gen</label>
                                            <div class="col-sm-9"><input type="text" name="sitrep_army_sy_gen"
                                                    class="form-control" placeholder="e.g. Calm"></div>
                                        </div>

                                        <!-- Army Significant Events -->
                                        <div class="form-group">
                                            <label>Army Significant Events</label>
                                            <div id="army_sig_events_list" class="lettered-list"
                                                data-name="sitrep_army_sig_event[]" data-placeholder="e.g. Army Event">
                                                <!-- initial row -->
                                                <div class="form-row align-items-center letter-row mb-2">
                                                    <div class="col-auto letter-label">a.</div>
                                                    <div class="col">
                                                        <input type="text" name="sitrep_army_sig_event[]"
                                                            class="form-control" placeholder="e.g. Army Event">
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-sm btn-danger remove-letter"
                                                            disabled>Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2 add-next"
                                                data-target="#army_sig_events_list">Add Next</button>
                                        </div>

                                        <!-- SITREP - Navy -->
                                        <label><strong>SITREP - Navy</strong></label>
                                        <div class="form-group">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Sy Gen</label>
                                                <div class="col-sm-9"><input type="text" name="sitrep_navy_sy_gen"
                                                        class="form-control" placeholder="e.g. Calm"></div>
                                            </div>

                                            <!-- Navy Significant Events -->
                                            <div class="form-group">
                                                <label>Navy Significant Events</label>
                                                <div id="navy_sig_events_list" class="lettered-list"
                                                    data-name="sitrep_navy_sig_event[]"
                                                    data-placeholder="e.g. Navy Event">
                                                    <!-- initial row -->
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <input type="text" name="sitrep_navy_sig_event[]"
                                                                class="form-control" placeholder="e.g. Navy Event">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-letter"
                                                                disabled>Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary mt-2 add-next"
                                                    data-target="#navy_sig_events_list">Add Next</button>
                                            </div>

                                        </div>
                                        <!-- SITREP - Airforce -->
                                        <label><strong>SITREP - Airforce</strong></label>
                                        <div class="form-group">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Sy Gen</label>
                                                <div class="col-sm-9"><input type="text" name="sitrep_airforce_sy_gen"
                                                        class="form-control" placeholder="e.g. Calm"></div>
                                            </div>

                                            <!-- Air Force Significant Events -->
                                            <div class="form-group">
                                                <label>Air Force Significant Events</label>
                                                <div id="airforce_sig_events_list" class="lettered-list"
                                                    data-name="sitrep_airforce_sig_event[]"
                                                    data-placeholder="e.g. Air Force Event">
                                                    <!-- initial row -->
                                                    <div class="form-row align-items-center letter-row mb-2">
                                                        <div class="col-auto letter-label">a.</div>
                                                        <div class="col">
                                                            <input type="text" name="sitrep_airforce_sig_event[]"
                                                                class="form-control" placeholder="e.g. Air Force Event">
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger remove-letter"
                                                                disabled>Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary mt-2 add-next"
                                                    data-target="#airforce_sig_events_list">Add Next</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- === TAB 5: MISC (includes duty veh odometer lettered subitems) === -->
                                    <div class="tab-pane" id="tab5">
                                        <div class="form-group">
                                            <label>Duty Veh</label>
                                            <textarea name="misc_duty_veh_note" class="form-control" rows="3"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Taking Over</label>
                                            <div id="odometer_list" class="lettered-list" data-section="odometer">
                                                <div class="form-row align-items-center letter-row mb-2">
                                                    <div class="col-auto letter-label">a.</div>
                                                    <div class="col">
                                                        <input type="text" name="misc_duty_veh_taking_over"
                                                            class="form-control" placeholder="Taking over - 163724">
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label>Handing Over</label>
                                            <div id="odometer_list" class="lettered-list" data-section="odometer">
                                                <div class="form-row align-items-center letter-row mb-2">
                                                    <div class="col-auto letter-label">b.</div>
                                                    <div class="col">
                                                        <input type="text" name="misc_duty_veh_handing_over"
                                                            class="form-control" placeholder="Taking over - 163724">
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label>Major News of Military Importance (print/electronic)</label>

                                            <textarea name="major_news_of_military" class="form-control" rows="3" placeholder="e.g. NTR"></textarea>

                                        </div>

                                        <div class="form-group">
                                            <label><strong>Admin Gen</strong></label>

                                            <!-- a. Lighting -->
                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">a.</label>
                                                <label class="col-sm-2 col-form-label">Lighting</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="admin_gen_lighting" class="form-control"
                                                        placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>

                                            <!-- b. Feeding -->
                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">b.</label>
                                                <label class="col-sm-2 col-form-label">Feeding</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="admin_gen_feeding" class="form-control"
                                                        placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>

                                            <!-- c. Welfare -->
                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">c.</label>
                                                <label class="col-sm-2 col-form-label">Welfare</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="admin_gen_welfare" class="form-control"
                                                        placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>GHQ Office Keys (Sy).</label>
                                            <textarea name="ghq_office_keys" class="form-control" rows="4" placeholder="All keys signed for..."></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>GAF Fire Station</label>
                                            <textarea name="gaf_fire[]" class="form-control" rows="4"></textarea>
                                        </div>


                                    </div>

                                    <!-- === TAB 6: Additional Information === -->
                                    <div class="tab-pane" id="tab6">
                                        <div class="form-group">
                                            <label>Additional Information</label>
                                            <textarea name="additional_information" class="form-control" rows="4"></textarea>
                                        </div>
                                    </div>

                                    <!-- === SUMMARY TAB === -->
                                    <div class="tab-pane" id="summary">
                                        <div id="summary_content" class="p-3"
                                            style="white-space:pre-line; font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial;">
                                            <!-- summary is injected here by JS when Next clicked from last step -->
                                            <h5 class="mb-3">Duty Officer Report - Summary</h5>
                                            <div id="summary_render"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Wizard Navigation Buttons -->
                                <div class="row justify-content-between mt-3">
                                    <div class="col-sm-6">
                                        <a href="#!" class="btn btn-primary button-previous">Previous</a>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <a href="#!" class="btn btn-primary button-next">Next</a>
                                        <button type="submit" id="submitBtn"
                                            class="btn btn-success d-none button-finish">Submit</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>


        </div>
    </section>

    <!-- jQuery, Popper, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!-- Bootstrap Wizard Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap-wizard/1.2/jquery.bootstrap.wizard.min.js">
    </script>
    <script>
        (function($) {
            const DutyReportWizard = {
                LETTER_A_CODE: 97,
                $wizard: null,
                $navItems: null,
                $submitBtn: null,
                $form: null,
                $summaryRender: null,

                init() {
                    this.cacheDom();
                    this.initWizard();
                    this.bindEvents();
                    this.initializeLists();
                },

                cacheDom() {
                    this.$wizard = $('#progresswizard');
                    this.$navItems = this.$wizard.find('.nav li');
                    this.$submitBtn = $('#submitBtn');
                    this.$form = $('#dutyReportForm');
                    this.$summaryRender = $('#summary_render');
                },

                initWizard() {
                    this.$wizard.bootstrapWizard({
                        nextSelector: '.button-next',
                        previousSelector: '.button-previous',
                        onTabShow: (tab, nav, index) => {
                            const total = nav.find('li').length;
                            const current = index + 1;
                            const percent = (current / total) * 100;
                            this.$wizard.find('.progress-bar').css({
                                width: percent + '%'
                            });
                        },
                        onTabClick: (tab, nav, index) => {
                            // Prevent clicking on the summary tab directly
                            return nav.find('li').eq(index).find('a').attr('href') !== '#summary';
                        }
                    });
                },

                bindEvents() {
                    // Handle Next button click
                    $(document).on('click', '.button-next', (e) => {
                        const idx = this.$navItems.index(this.$navItems.find('a.active').parent());
                        if (idx === this.$navItems.length - 2) { // second last tab
                            e.preventDefault();
                            this.showSummary();
                        }
                    });

                    // Handle Previous button click
                    $(document).on('click', '.button-previous', () => {
                        if (this.$wizard.find('.nav li a.active').attr('href') !== '#summary') {
                            this.$submitBtn.addClass('d-none');
                        }
                    });

                    // Handle form submission
                    this.$form.on('submit', (e) => this.handleSubmit(e));
                },

                initializeLists() {
                    $('.lettered-list').each((_, el) => {
                        const $container = $(el);
                        this.relabelLetters($container);
                        this.updateRemoveButtons($container);
                    });
                },

                nextLetter(lastLabel) {
                    if (!lastLabel) return 'a';
                    const toNum = (label) => {
                        let num = 0;
                        for (let i = 0; i < label.length; i++) {
                            num = num * 26 + (label.charCodeAt(i) - this.LETTER_A_CODE + 1);
                        }
                        return num;
                    };
                    const toLabel = (num) => {
                        let s = '';
                        while (num > 0) {
                            const rem = (num - 1) % 26;
                            s = String.fromCharCode(this.LETTER_A_CODE + rem) + s;
                            num = Math.floor((num - 1) / 26);
                        }
                        return s;
                    };
                    return toLabel(toNum(lastLabel) + 1);
                },

                addLetterRow($container) {
                    const $rows = $container.find('.letter-row');
                    const lastLabel = $rows.last().find('.letter-label').text().trim().replace('.', '') || '';
                    const newLetter = this.nextLetter(lastLabel);

                    const fieldName = $container.data('section') || ($container.attr('id') || 'x').replace('_list',
                        '');
                    const elementHtml =
                        `<input type="text" name="${fieldName}[]" class="form-control" placeholder="">`;

                    const $newRow = $(`
          <div class="form-row align-items-center letter-row mb-2">
            <div class="col-auto letter-label">${newLetter}.</div>
            <div class="col">${elementHtml}</div>
            <div class="col-auto">
              <button type="button" class="btn btn-sm btn-danger remove-letter">Remove</button>
            </div>
          </div>
        `);

                    $container.append($newRow);
                    this.updateRemoveButtons($container);
                },

                updateRemoveButtons($container) {
                    const $rows = $container.find('.letter-row');
                    $rows.find('.remove-letter').prop('disabled', false);
                    $rows.first().find('.remove-letter').prop('disabled', true);
                },

                relabelLetters($container) {
                    $container.find('.letter-row').each((i, row) => {
                        $(row).find('.letter-label').text(this.numberToLabel(i) + '.');
                    });
                },

                numberToLabel(index) {
                    index++;
                    let s = '';
                    while (index > 0) {
                        const rem = (index - 1) % 26;
                        s = String.fromCharCode(this.LETTER_A_CODE + rem) + s;
                        index = Math.floor((index - 1) / 26);
                    }
                    return s;
                },

                getLetteredListData(selector) {
                    return $(selector).find('.letter-row').map((_, row) => {
                        return {
                            label: $(row).find('.letter-label').text().trim(),
                            value: $(row).find('input, textarea').val() || ''
                        };
                    }).get();
                },

                collectFormData() {
                    return {
                        duty_officer: $('input[name="duty_officer"]').val() || '',
                        dept: $('input[name="unit"]').val() || '',
                        reporting_time: $('input[name="reporting_time"]').val() || '',
                        contact_number: $('input[name="phone"]').val() || '',
                        period_covered: $('input[name="period_covered"]').val() || '',

                        general_sy_gen: $('input[name="general_sy_gen"]').val() || '',
                        general_significant_event: $('input[name="general_significant_event"]').val() || '',

                        comm_state: $('input[name="comm_state"]').val() || '',
                        messages: this.getLetteredListData('#messages_list'),
                        visits_ops_room: $('textarea[name="visits_ops_room"]').val() || '',

                        ops_room_copier: this.getLetteredListData('#ops_room_copier_list'),

                        sitrep_camp_sy_gen: $('input[name="sitrep_camp_sy_gen"]').val() || '',
                        sitrep_camp: this.getLetteredListData('#sitrep_camp_list'),
                        major_events: $('textarea[name="major_events"]').val() || '',

                        sitrep_army_sy_gen: $('input[name="sitrep_army_sy_gen"]').val() || '',
                        sitrep_army_significant: $('input[name="sitrep_army_significant"]').val() || '',

                        sitrep_navy_sy_gen: $('input[name="sitrep_navy_sy_gen"]').val() || '',
                        sitrep_navy_significant: $('input[name="sitrep_navy_significant"]').val() || '',

                        sitrep_airforce_sy_gen: $('input[name="sitrep_airforce_sy_gen"]').val() || '',
                        sitrep_airforce_significant: $('input[name="sitrep_airforce_significant"]').val() || '',

                        misc_notes: $('textarea[name="misc_notes"]').val() || '',
                        odometer: this.getLetteredListData('#odometer_list'),
                        major_news: $('input[name="major_news"]').val() || '',
                        admin_gen: this.getLetteredListData('#admin_gen_list'),
                        gaf_fire: this.getLetteredListData('#gaf_fire_list'),
                        ghq_office_keys: $('textarea[name="ghq_office_keys"]').val() || '',
                        visits_details: $('textarea[name="visits_details"]').val() || ''
                    };
                },

                renderSummary(data) {
                    let out = '';
                    out += `DUTY OFFICER : ${data.duty_officer}\n`;
                    out += `DEPT/DTE     : ${data.dept}\n`;
                    out += `REPORTING TIME: ${data.reporting_time}\n`;
                    out += `CONTACT NO.  : ${data.contact_number}\n\n`;
                    out += `PERIOD COVERED: ${data.period_covered}\n\n`;

                    out += 'GENERAL\n';
                    out += `1. Sy Gen.  ${data.general_sy_gen}\n`;
                    out += `2. Significant Event.  ${data.general_significant_event}\n\n`;

                    out += 'OPS ROOM\n';
                    out += `3. Comm State. ${data.comm_state}\n\n`;

                    out += '4. Messages/Correspondences Received.\n';
                    data.messages.forEach(m => {
                        out += `   ${m.label} ${m.value}\n`;
                    });
                    out += '\n';

                    out += '5. Visits to the Ops Room.\n';
                    out += `   ${data.visits_ops_room || data.visits_details}\n\n`;

                    out += 'SITREP - CAMP\n';
                    out += `6. Sy Gen. ${data.sitrep_camp_sy_gen}\n`;
                    data.sitrep_camp.forEach(r => {
                        out += `   ${r.label} ${r.value}\n`;
                    });
                    out += '\n';

                    out += `7. Major Events. ${data.major_events}\n\n`;

                    out += 'SITREP - ARMY\n';
                    out += `8. Sy Gen. ${data.sitrep_army_sy_gen}\n`;
                    out += `9. Significant Events. ${data.sitrep_army_significant}\n\n`;

                    out += 'SITREP - NAVY\n';
                    out += `10. Sy Gen. ${data.sitrep_navy_sy_gen}\n`;
                    out += `11. Significant Event. ${data.sitrep_navy_significant}\n\n`;

                    out += 'SITREP - AIRFORCE\n';
                    out += `12. Sy Gen. ${data.sitrep_airforce_sy_gen}\n`;
                    out += `13. Significant Event. ${data.sitrep_airforce_significant}\n\n`;

                    out += 'MISC\n';
                    out += `14. ${data.misc_notes}\n`;
                    data.odometer.forEach(d => {
                        out += `   ${d.label} ${d.value}\n`;
                    });
                    out += '\n';

                    out += `15. Major News: ${data.major_news}\n\n`;

                    out += '16. Admin Gen.\n';
                    data.admin_gen.forEach(a => {
                        out += `   ${a.label} ${a.value}\n`;
                    });
                    out += '\n';

                    out += `17. GHQ Office Keys / Notes: ${data.ghq_office_keys}\n\n`;

                    if (data.gaf_fire && data.gaf_fire.length) {
                        out += 'GAF Fire Station\n';
                        data.gaf_fire.forEach(f => {
                            out += `   ${f.label} ${f.value}\n`;
                        });
                        out += '\n';
                    }

                    this.$summaryRender.text(out);
                },

                showSummary() {
                    const data = this.collectFormData();
                    this.renderSummary(data);
                    const total = this.$navItems.length;
                    this.$wizard.bootstrapWizard('show', total - 1);
                    this.$submitBtn.removeClass('d-none');
                },

                handleSubmit(e) {
                    e.preventDefault();
                    const payload = this.$form.serializeArray();
                    console.log('Submitting data:', payload);

                    // Optional: AJAX submission
                    /*
                    $.post('/your-endpoint', this.$form.serialize())
                      .done(() => alert('Report submitted successfully!'))
                      .fail(() => alert('Submission failed.'));
                    */

                    alert('Form submitted. Replace with real server submission logic.');
                }
            };

            // Initialize on DOM ready
            $(function() {
                DutyReportWizard.init();
            });

        })(jQuery);
    </script>






    <script>
        document.querySelectorAll('.add-next').forEach(button => {
            button.addEventListener('click', function() {
                const targetSelector = this.dataset.target;
                const wrapper = document.querySelector(targetSelector);
                const rows = wrapper.querySelectorAll('.letter-row');
                const nextLetter = String.fromCharCode(97 + rows.length); // 97 = 'a'

                const nameAttr = wrapper.id === 'messages_list' ?
                    'ops_room_messages[]' :
                    'gen_sig_event[]';

                const placeholderText = wrapper.id === 'messages_list' ?
                    'e.g. ARMY HQ - OPS/1296 ...' :
                    'e.g. Event A';

                const newRow = document.createElement('div');
                newRow.className = 'form-row align-items-center letter-row mb-2';
                newRow.innerHTML = `
                <div class="col-auto letter-label">${nextLetter}.</div>
                <div class="col">
                    <input type="text" name="${nameAttr}" class="form-control"
                        placeholder="${placeholderText}">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-sm btn-danger remove-letter">Remove</button>
                </div>
            `;

                wrapper.appendChild(newRow);
                enableRemoveButtons(wrapper);
            });
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-letter')) {
                const row = e.target.closest('.letter-row');
                const wrapper = row.parentNode;
                row.remove();
                updateLetterLabels(wrapper);
                enableRemoveButtons(wrapper);
            }
        });

        function updateLetterLabels(wrapper) {
            const rows = wrapper.querySelectorAll('.letter-row');
            rows.forEach((row, i) => {
                const label = row.querySelector('.letter-label');
                label.textContent = String.fromCharCode(97 + i) + '.';
            });
        }

        function enableRemoveButtons(wrapper) {
            const rows = wrapper.querySelectorAll('.letter-row');
            rows.forEach(row => {
                const btn = row.querySelector('.remove-letter');
                btn.disabled = rows.length === 1;
            });
        }

        // On page load — init both sections
        enableRemoveButtons(document.querySelector('#messages_list'));
        enableRemoveButtons(document.querySelector('#sig_events_list'));
    </script>
@endsection

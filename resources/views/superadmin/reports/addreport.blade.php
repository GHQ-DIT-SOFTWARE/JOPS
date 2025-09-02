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
                       <form id="dutyReportForm" action="{{ route('superadmin.reports.store') }}" method="POST">
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
                                        <!-- Duty Officer (readonly, prefilled, submitted via hidden input) -->
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Duty Officer</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    value="{{ $user->rank }} {{ $user->fname }}" readonly>
                                                <input type="hidden" name="duty_officer"
                                                    value="{{ $user->rank }} {{ $user->fname }}">
                                            </div>
                                        </div>

                                        <!-- Dept/DTE (readonly, prefilled, submitted via hidden input) -->
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Dept/DTE</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $user->unit }}"
                                                    readonly>
                                                <input type="hidden" name="unit" value="{{ $user->unit }}">
                                            </div>
                                        </div>

                                        <!-- Contact Number (readonly, submitted via hidden input) -->
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Contact Number</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" value="{{ $user->phone }}"
                                                    readonly>
                                                <input type="hidden" name="phone" value="{{ $user->phone }}">
                                            </div>
                                        </div>


                                        <!-- Reporting Time (editable, submitted) -->
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Reporting Time</label>
                                            <div class="col-sm-9">
                                                <input type="time" class="form-control" id="reporting_time"
                                                    name="reporting_time">
                                            </div>
                                        </div>



                                        <!-- Period Covered (editable, submitted) -->
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
                                            <div class="col-sm-9">
                                                <textarea name="gen_sy_gen" class="form-control" rows="4"
                                                    placeholder="e.g. 
                                                Calm">{{ old('gen_sy_gen') }}</textarea>
                                                <small class="form-text text-muted">Enter each item on a new line.</small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Significant Events</label>
                                            <textarea name="gen_sig_events" class="form-control" rows="6"
                                                placeholder="e.g. 
                                                Event A
                                                Event B">{{ old('gen_sig_events') }}</textarea>
                                            <small class="form-text text-muted">Enter each event on a new line.</small>
                                        </div>
                                    </div>



                                    <!-- === TAB 3: Ops Room === -->
                                    <div class="tab-pane" id="tab3">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Comm State</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="ops_room_comm_state" class="form-control"
                                                    placeholder="Satisfactory">
                                            </div>
                                        </div>

                                        <!-- Replaced array of messages with textarea -->
                                        <div class="form-group">
                                            <label>Messages / Correspondences Received</label>
                                            <textarea name="ops_room_messages" class="form-control" rows="5"
                                                placeholder="e.g. ARMY HQ - OPS/1296 ...&#10;NAVY HQ - OPS/456 ...">{{ old('ops_room_messages') }}</textarea>
                                            <small class="form-text text-muted">Enter each message on a new line.</small>
                                        </div>

                                        <div class="form-group">
                                            <label>Visits to Ops Room</label>
                                            <textarea name="visit_ops_room" class="form-control" rows="3"
                                                placeholder="e.g. Lt Col JM Gbog visited at 1410 hrs">{{ old('visit_ops_room') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Ops Room Photocopier</strong></label>

                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">a.</label>
                                                <label class="col-sm-2 col-form-label">Taking Over</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="photocopier_taking_over"
                                                        class="form-control" placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>

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

                                    <!-- === TAB 4: SITREP - CAMP === -->
                                    <div class="tab-pane" id="tab4">
                                        <label><strong>SITREP - Camp</strong></label>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Sy Gen</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="sitrep_camp_sy_gen" class="form-control"
                                                    placeholder="e.g. Calm">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Main Gate</label>
                                            <input type="text" name="sitrep_camp_main_gate" class="form-control"
                                                placeholder="e.g. NTR">
                                        </div>

                                        <div class="form-group">
                                            <label>Comd Gate</label>
                                            <input type="text" name="sitrep_camp_command_gate" class="form-control"
                                                placeholder="e.g. NTR">
                                        </div>

                                        <div class="form-group">
                                            <label>Congo Junction</label>
                                            <input type="text" name="sitrep_camp_congo_junction" class="form-control"
                                                placeholder="e.g. NTR">
                                        </div>

                                        <div class="form-group">
                                            <label>GAFPO</label>
                                            <input type="text" name="sitrep_camp_gafto" class="form-control"
                                                placeholder="e.g. NTR">
                                        </div>

                                        <div class="form-group">
                                            <label>Major Events</label>
                                            <textarea name="major_event" class="form-control" rows="4" placeholder="e.g. Nil">{{ old('major_event') }}</textarea>
                                        </div>

                                        <!-- SITREP - Army -->
                                        <label><strong>SITREP - Army</strong></label>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Sy Gen</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="sitrep_army_sy_gen" class="form-control"
                                                    placeholder="e.g. Calm">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Army Significant Events</label>
                                            <textarea name="sitrep_army_sig_event" class="form-control" rows="4" placeholder="e.g. Army Event">{{ old('sitrep_army_sig_event') }}</textarea>
                                            <small class="form-text text-muted">Enter each event on a new line.</small>
                                        </div>

                                        <!-- SITREP - Navy -->
                                        <label><strong>SITREP - Navy</strong></label>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Sy Gen</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="sitrep_navy_sy_gen" class="form-control"
                                                    placeholder="e.g. Calm">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Navy Significant Events</label>
                                            <textarea name="sitrep_navy_sig_event" class="form-control" rows="4" placeholder="e.g. Navy Event">{{ old('sitrep_navy_sig_event') }}</textarea>
                                            <small class="form-text text-muted">Enter each event on a new line.</small>
                                        </div>

                                        <!-- SITREP - Airforce -->
                                        <label><strong>SITREP - Airforce</strong></label>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Sy Gen</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="sitrep_airforce_sy_gen" class="form-control"
                                                    placeholder="e.g. Calm">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Air Force Significant Events</label>
                                            <textarea name="sitrep_airforce_sig_event" class="form-control" rows="4" placeholder="e.g. Air Force Event">{{ old('sitrep_airforce_sig_event') }}</textarea>
                                            <small class="form-text text-muted">Enter each event on a new line.</small>
                                        </div>
                                    </div>

                                    <!-- === TAB 5: MISC === -->
                                    <div class="tab-pane" id="tab5">
                                        <div class="form-group">
                                            <label>Duty Veh</label>
                                            <textarea name="misc_duty_veh_note" class="form-control" rows="3">{{ old('misc_duty_veh_note') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Taking Over</label>
                                            <textarea name="misc_duty_veh_taking_over" class="form-control" rows="2" placeholder="Taking over - 163724">{{ old('misc_duty_veh_taking_over') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Handing Over</label>
                                            <textarea name="misc_duty_veh_handing_over" class="form-control" rows="2" placeholder="Handing over - 163724">{{ old('misc_duty_veh_handing_over') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Major News of Military Importance (print/electronic)</label>
                                            <textarea name="major_news_of_military" class="form-control" rows="3" placeholder="e.g. NTR">{{ old('major_news_of_military') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Admin Gen</strong></label>

                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">a.</label>
                                                <label class="col-sm-2 col-form-label">Lighting</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="admin_gen_lighting" class="form-control"
                                                        placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center mb-2">
                                                <label class="col-sm-1 col-form-label text-right">b.</label>
                                                <label class="col-sm-2 col-form-label">Feeding</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="admin_gen_feeding" class="form-control"
                                                        placeholder="e.g. Satisfactory">
                                                </div>
                                            </div>

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
                                            <label>GHQ Office Keys (Sy)</label>
                                            <textarea name="ghq_office_keys" class="form-control" rows="4" placeholder="All keys signed for...">{{ old('ghq_office_keys') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>GAF Fire Station</label>
                                            <textarea name="gaf_fire_station" class="form-control" rows="4" placeholder="e.g. Fire alarm test successful">{{ old('gaf_fire_station') }}</textarea>
                                        </div>
                                    </div>


                                    <!-- === TAB 6: Additional Information === -->
                                    <div class="tab-pane" id="tab6">
                                        <div class="form-group">
                                            <label>Additional Information</label>
                                            <textarea name="additional_information" class="form-control" rows="4"
                                                placeholder="Enter any additional information here...">{{ old('additional_information') }}</textarea>
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

    <!-- Keep these (jQuery + Bootstrap 4 + Wizard plugin) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap-wizard/1.2/jquery.bootstrap.wizard.min.js">
    </script>

    <script>
        $(function() {
            const $wizard = $('#progresswizard');
            const $form = $('#dutyReportForm');
            const $submitBtn = $('#submitBtn');

            // ---------------- Wizard Init ----------------
            $wizard.bootstrapWizard({
                nextSelector: '.button-next',
                previousSelector: '.button-previous',
                onTabShow: function(tab, nav, index) {
                    const total = nav.find('li').length;
                    const current = index + 1;
                    const percent = (current / total) * 100;
                    $wizard.find('.progress-bar').css({
                        width: percent + '%'
                    });
                },
                onTabClick: function(tab, nav, index) {
                    const href = nav.find('a').eq(index).attr('href');
                    return href !== '#summary'; // prevent direct click to summary
                }
            });

            // Show submit only on summary tab
            $wizard.find('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                const target = $(e.target).attr('href');
                const isSummary = target === '#summary';
                $submitBtn.toggleClass('d-none', !isSummary);
                if (isSummary) renderSummary();
            });

            // ---------------- Dynamic Lettered Lists ----------------
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

            $(document).on('click', '.add-next', function() {
                const targetSel = $(this).data('target');
                const $container = $(targetSel);
                if (!$container.length) return;

                const $rows = $container.find('.letter-row');
                const nextLabel = indexToLabel($rows.length) + '.';
                const name = $container.data('name') || $rows.find('input').first().attr('name') || '';
                const placeholder = $container.data('placeholder') || $rows.find('input').first().attr(
                    'placeholder') || '';

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
                updateRemoveButtons($container);
            });

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

                function renderList(selector) {
                    let listHtml = '<ul>';
                    form.querySelectorAll(selector).forEach(el => {
                        const v = el.value.trim();
                        if (v) listHtml += `<li>${v}</li>`;
                    });
                    listHtml += '</ul>';
                    return listHtml;
                }

                // Duty Officer Info
                html += `<h6>1. Duty Officer Info</h6>`;
                html += `<p><strong>Duty Officer:</strong> ${form.duty_officer?.value || ''}</p>`;
                html += `<p><strong>Dept/DTE:</strong> ${form.unit?.value || ''}</p>`;
                html += `<p><strong>Reporting Time:</strong> ${form.reporting_time?.value || ''}</p>`;
                html += `<p><strong>Contact Number:</strong> ${form.phone?.value || ''}</p>`;
                html += `<p><strong>Period Covered:</strong> ${form.period_covered?.value || ''}</p>`;

                // General
                html += `<h6 class='mt-3'>2. General</h6>`;
                html += `<p><strong>Sy Gen:</strong> ${form.gen_sy_gen?.value || ''}</p>`;
                html += `<p><strong>Significant Events:</strong> ${form.gen_sig_events?.value || ''}</p>`;

                // Ops Room
                html += `<h6 class='mt-3'>3. Ops Room</h6>`;
                html += `<p><strong>Comm State:</strong> ${form.ops_room_comm_state?.value || ''}</p>`;
                html +=
                `<p><strong>Messages / Correspondences:</strong> ${form.ops_room_messages?.value || ''}</p>`;
                html += `<p><strong>Visits:</strong> ${form.visit_ops_room?.value || ''}</p>`;
                html +=
                    `<p><strong>Photocopier Taking Over:</strong> ${form.photocopier_taking_over?.value || ''}</p>`;
                html +=
                    `<p><strong>Photocopier Handing Over:</strong> ${form.photocopier_handing_over?.value || ''}</p>`;

                // Special handling for Camp
                html += `<h6 class='mt-3'>4. SITREP - Camp</h6>`;
                html += `<p><strong>Sy Gen:</strong> ${form.sitrep_camp_sy_gen?.value || ''}</p>`;
                html += `<p><strong>Main Gate:</strong> ${form.sitrep_camp_main_gate?.value || ''}</p>`;
                html += `<p><strong>Comd Gate:</strong> ${form.sitrep_camp_command_gate?.value || ''}</p>`;
                html += `<p><strong>Congo Junction:</strong> ${form.sitrep_camp_congo_junction?.value || ''}</p>`;
                html += `<p><strong>GAFPO:</strong> ${form.sitrep_camp_gafto?.value || ''}</p>`;
                html += `<p><strong>Major Events:</strong> ${form.major_event?.value || ''}</p>`;

                // Handle the others in a loop
                ['army', 'navy', 'airforce'].forEach((branch, i) => {
                    const branchName = branch.charAt(0).toUpperCase() + branch.slice(1);
                    html += `<h6 class='mt-3'>${i + 5}. SITREP - ${branchName}</h6>`;
                    html +=
                        `<p><strong>Sy Gen:</strong> ${form[`sitrep_${branch}_sy_gen`]?.value || ''}</p>`;
                    html +=
                        `<p><strong>Significant Events:</strong><br>${form[`sitrep_${branch}_sig_event`]?.value || ''}</p>`;
                });


                // Misc
                html += `<h6 class='mt-3'>8. Misc</h6>`;
                html += `<p><strong>Duty Veh Note:</strong> ${form.misc_duty_veh_note?.value || ''}</p>`;
                html +=
                    `<p><strong>Taking Over Odometer:</strong> ${form.misc_duty_veh_taking_over?.value || ''}</p>`;
                html +=
                    `<p><strong>Handing Over Odometer:</strong> ${form.misc_duty_veh_handing_over?.value || ''}</p>`;
                html += `<p><strong>Major News:</strong> ${form.major_news_of_military?.value || ''}</p>`;
                html +=
                    `<p><strong>Admin Gen:</strong> Lighting: ${form.admin_gen_lighting?.value || ''}, Feeding: ${form.admin_gen_feeding?.value || ''}, Welfare: ${form.admin_gen_welfare?.value || ''}</p>`;
                html += `<p><strong>GHQ Office Keys:</strong> ${form.ghq_office_keys?.value || ''}</p>`;
                html += `<p><strong>GAF Fire Station:</strong> ${form.gaf_fire_station?.value || ''}</p>`;

                // Additional Info
                html += `<h6 class='mt-3'>9. Additional Information</h6>`;
                html += `<p>${form.additional_information?.value || ''}</p>`;

                $('#summary_render').html(html);
            }



            // ---------------- Reporting Time Format Fix ----------------
            $('input[name="reporting_time"]').on('input', function() {
                let val = this.value;
                if (val) {
                    let [h, m] = val.split(':');
                    h = ('0' + h).slice(-2);
                    this.value = `${h}:${m}`;
                }
            });

            // ---------------- Form Submit ----------------
            $submitBtn.removeClass('d-none'); // always show submit for testing
            $form.on('submit', function(e) {
                e.preventDefault();
                // Optional: add client-side validation here
                this.submit(); // finally submit
            });
        });
    </script>
@endsection

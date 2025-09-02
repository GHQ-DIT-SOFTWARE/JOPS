<form action="{{ route('superadmin.update.report', $report->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Duty Officer -->
    <div class="form-group">
        <label for="duty_officer">Duty Officer</label>
        <input type="text" name="duty_officer" id="duty_officer" class="form-control"
               value="{{ old('duty_officer', $report->duty_officer) }}" readonly>
    </div>

    <!-- Unit -->
    <div class="form-group">
        <label for="unit">Unit</label>
        <input type="text" name="unit" id="unit" class="form-control"
               value="{{ old('unit', $report->unit) }}" readonly>
    </div>

    <!-- Reporting Time -->
<div class="form-group">
    <label for="reporting_time">Reporting Time</label>
    <input type="time" name="reporting_time" id="reporting_time" class="form-control"
           value="{{ old('reporting_time', $report->reporting_time ?? '') }}">
</div>


    <!-- Phone -->
    <div class="form-group">
        <label for="phone">Contact Number</label>
        <input type="text" name="phone" id="phone" class="form-control"
               value="{{ old('phone', $report->phone) }}" readonly>
    </div>

    <!-- Period Covered -->
    <div class="form-group">
        <label for="period_covered">Period Covered</label>
        <input type="text" name="period_covered" id="period_covered" class="form-control"
               value="{{ old('period_covered', $report->period_covered) }}">
    </div>

    <!-- General Situation -->
    <div class="form-group">
        <label for="gen_sy_gen">General Situation</label>
        <textarea name="gen_sy_gen" id="gen_sy_gen" class="form-control" rows="3">{{ old('gen_sy_gen', is_array($report->gen_sy_gen) ? implode("\n", $report->gen_sy_gen) : $report->gen_sy_gen) }}</textarea>
    </div>

    <!-- Significant Events -->
    <div class="form-group">
        <label for="gen_sig_event">Significant Events</label>
        <textarea name="gen_sig_event" id="gen_sig_event" class="form-control" rows="3">{{ old('gen_sig_event', is_array($report->gen_sig_event) ? implode("\n", $report->gen_sig_event) : $report->gen_sig_event) }}</textarea>
    </div>

    <!-- Ops Room Comms State -->
    <div class="form-group">
        <label for="ops_room_comm_state">Ops Room Communication State</label>
        <textarea name="ops_room_comm_state" id="ops_room_comm_state" class="form-control" rows="3">{{ old('ops_room_comm_state', is_array($report->ops_room_comm_state) ? implode("\n", $report->ops_room_comm_state) : $report->ops_room_comm_state) }}</textarea>
    </div>

    <!-- Ops Room Messages -->
    <div class="form-group">
        <label for="ops_room_messages">Ops Room Messages</label>
        <textarea name="ops_room_messages" id="ops_room_messages" class="form-control" rows="3">{{ old('ops_room_messages', is_array($report->ops_room_messages) ? implode("\n", $report->ops_room_messages) : $report->ops_room_messages) }}</textarea>
    </div>

    <!-- Visit to Ops Room -->
    <div class="form-group">
        <label for="visit_ops_room">Visit to Ops Room</label>
        <textarea name="visit_ops_room" id="visit_ops_room" class="form-control" rows="3">{{ old('visit_ops_room', is_array($report->visit_ops_room) ? implode("\n", $report->visit_ops_room) : $report->visit_ops_room) }}</textarea>
    </div>

    <!-- Sitrep Camp -->
    <div class="form-group">
        <label for="sitrep_camp_sy_gen">Sitrep Camp - General Security</label>
        <input type="text" name="sitrep_camp_sy_gen" class="form-control"
               value="{{ old('sitrep_camp_sy_gen', $report->sitrep_camp_sy_gen) }}">
    </div>

    <div class="form-group">
        <label for="sitrep_camp_main_gate">Sitrep Camp - Main Gate</label>
        <input type="text" name="sitrep_camp_main_gate" class="form-control"
               value="{{ old('sitrep_camp_main_gate', $report->sitrep_camp_main_gate) }}">
    </div>

    <div class="form-group">
        <label for="sitrep_camp_command_gate">Sitrep Camp - Command Gate</label>
        <input type="text" name="sitrep_camp_command_gate" class="form-control"
               value="{{ old('sitrep_camp_command_gate', $report->sitrep_camp_command_gate) }}">
    </div>

    <div class="form-group">
        <label for="sitrep_camp_congo_junction">Sitrep Camp - Congo Junction</label>
        <input type="text" name="sitrep_camp_congo_junction" class="form-control"
               value="{{ old('sitrep_camp_congo_junction', $report->sitrep_camp_congo_junction) }}">
    </div>

    <div class="form-group">
        <label for="sitrep_camp_gafto">Sitrep Camp - GAFTU</label>
        <input type="text" name="sitrep_camp_gafto" class="form-control"
               value="{{ old('sitrep_camp_gafto', $report->sitrep_camp_gafto) }}">
    </div>

    <!-- Major Events -->
    <div class="form-group">
        <label for="major_event">Major Events</label>
        <textarea name="major_event" id="major_event" class="form-control" rows="3">{{ old('major_event', is_array($report->major_event) ? implode("\n", $report->major_event) : $report->major_event) }}</textarea>
    </div>

    <!-- Sitrep Service -->
    <div class="form-group">
        <label for="sitrep_army_sy_gen">Sitrep - Army General Security</label>
        <input type="text" name="sitrep_army_sy_gen" class="form-control"
               value="{{ old('sitrep_army_sy_gen', $report->sitrep_army_sy_gen) }}">
    </div>

    <div class="form-group">
        <label for="sitrep_navy_sy_gen">Sitrep - Navy General Security</label>
        <input type="text" name="sitrep_navy_sy_gen" class="form-control"
               value="{{ old('sitrep_navy_sy_gen', $report->sitrep_navy_sy_gen) }}">
    </div>

    <div class="form-group">
        <label for="sitrep_airforce_sy_gen">Sitrep - Airforce General Security</label>
        <input type="text" name="sitrep_airforce_sy_gen" class="form-control"
               value="{{ old('sitrep_airforce_sy_gen', $report->sitrep_airforce_sy_gen) }}">
    </div>

    <!-- Misc Duty Vehicle -->
    <div class="form-group">
        <label for="misc_duty_veh_note">Duty Vehicle Notes</label>
        <textarea name="misc_duty_veh_note" id="misc_duty_veh_note" class="form-control" rows="3">{{ old('misc_duty_veh_note', $report->misc_duty_veh_note) }}</textarea>
    </div>

    <div class="form-group">
        <label for="misc_duty_veh_taking_over">Duty Vehicle Taking Over</label>
        <input type="text" name="misc_duty_veh_taking_over" class="form-control"
               value="{{ old('misc_duty_veh_taking_over', $report->misc_duty_veh_taking_over) }}">
    </div>

    <div class="form-group">
        <label for="misc_duty_veh_handing_over">Duty Vehicle Handing Over</label>
        <input type="text" name="misc_duty_veh_handing_over" class="form-control"
               value="{{ old('misc_duty_veh_handing_over', $report->misc_duty_veh_handing_over) }}">
    </div>

    <!-- Major Military News -->
    <div class="form-group">
        <label for="major_news_of_military">Major News of Military</label>
        <textarea name="major_news_of_military" id="major_news_of_military" class="form-control" rows="3">{{ old('major_news_of_military', $report->major_news_of_military) }}</textarea>
    </div>

    <!-- Admin -->
    <div class="form-group">
        <label for="admin_gen_lighting">Admin - Lighting</label>
        <input type="text" name="admin_gen_lighting" class="form-control"
               value="{{ old('admin_gen_lighting', $report->admin_gen_lighting) }}">
    </div>

    <div class="form-group">
        <label for="admin_gen_feeding">Admin - Feeding</label>
        <input type="text" name="admin_gen_feeding" class="form-control"
               value="{{ old('admin_gen_feeding', $report->admin_gen_feeding) }}">
    </div>

    <div class="form-group">
        <label for="admin_gen_welfare">Admin - Welfare</label>
        <input type="text" name="admin_gen_welfare" class="form-control"
               value="{{ old('admin_gen_welfare', $report->admin_gen_welfare) }}">
    </div>

    <!-- Keys & Fire Station -->
    <div class="form-group">
        <label for="ghq_office_keys">GHQ Office Keys</label>
        <input type="text" name="ghq_office_keys" class="form-control"
               value="{{ old('ghq_office_keys', $report->ghq_office_keys) }}">
    </div>

    <div class="form-group">
        <label for="gaf_fire_station">GAF Fire Station</label>
        <textarea name="gaf_fire_station" id="gaf_fire_station" class="form-control" rows="3">{{ old('gaf_fire_station', is_array($report->gaf_fire_station) ? implode("\n", $report->gaf_fire_station) : $report->gaf_fire_station) }}</textarea>
    </div>

    <!-- Photocopier -->
    <div class="form-group">
        <label for="photocopier_taking_over">Photocopier Taking Over</label>
        <input type="text" name="photocopier_taking_over" class="form-control"
               value="{{ old('photocopier_taking_over', $report->photocopier_taking_over) }}">
    </div>

    <div class="form-group">
        <label for="photocopier_handing_over">Photocopier Handing Over</label>
        <input type="text" name="photocopier_handing_over" class="form-control"
               value="{{ old('photocopier_handing_over', $report->photocopier_handing_over) }}">
    </div>

    <!-- Additional Info -->
    <div class="form-group">
        <label for="additional_information">Additional Information</label>
        <textarea name="additional_information" id="additional_information" class="form-control" rows="3">{{ old('additional_information', $report->additional_information) }}</textarea>
    </div>

    <!-- Comments -->
    <div class="form-group">
        <label for="d_land_ops_comment">D/Land Ops Comment</label>
        <textarea name="d_land_ops_comment" id="d_land_ops_comment" class="form-control" rows="3">{{ old('d_land_ops_comment', $report->d_land_ops_comment) }}</textarea>
    </div>

    <div class="form-group">
        <label for="dg_remarks">DG Remarks</label>
        <textarea name="dg_remarks" id="dg_remarks" class="form-control" rows="3">{{ old('dg_remarks', $report->dg_remarks) }}</textarea>
    </div>

    <!-- Submit -->
    <button type="submit" class="btn btn-primary">Update Report</button>
</form>

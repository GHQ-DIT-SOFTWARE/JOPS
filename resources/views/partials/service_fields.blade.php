<div class="form-group col-md-3">
    <label for="arm_of_service">Arm of Service</label>
    <select name="arm_of_service" id="arm_of_service" class="form-control" required>
        <option value="">Select Arm</option>
        @foreach (['ARMY', 'NAVY', 'AIRFORCE', 'DCS'] as $arm)
            <option value="{{ $arm }}"
                {{ old('arm_of_service', $personnel->arm_of_service ?? '') == $arm ? 'selected' : '' }}>
                {{ $arm }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-3">
    <label for="level">Level</label>
    <select name="level" id="level" class="form-control" required>
        <option value="">Select Level</option>
        @foreach (['OFFICER', 'SOLDIER', 'RATING', 'AIRMAN', 'JUNIOR'] as $lvl)
            <option value="{{ $lvl }}" {{ old('level', $personnel->level ?? '') == $lvl ? 'selected' : '' }}>
                {{ $lvl }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-3">
    <label for="trade_category">Trade Category</label>
    <select name="trade_category" id="trade_category" class="form-control" required>
        <option value="">Select Category</option>
        <option value="military"
            {{ old('trade_category', $personnel->trade_category ?? '') == 'military' ? 'selected' : '' }}>Military
        </option>
        <option value="civilian"
            {{ old('trade_category', $personnel->trade_category ?? '') == 'civilian' ? 'selected' : '' }}>Civilian
        </option>
    </select>
</div>

<div class="form-group col-md-3">
    <label for="trade_group">Trade Group</label>
    <!-- Trade Group Dropdown -->
    <select name="trade_group" class="form-control">
        <option value="">Select Trade Group</option>

        @foreach($military_trade_groups as $tradeGroup)
            <option value="{{ $tradeGroup }}" 
                {{ $tradeGroup == old('trade_group', optional($personnel)->trade_group) ? 'selected' : '' }}>
                {{ $tradeGroup }}
            </option>
        @endforeach

        @foreach($civilian_trade_groups as $tradeGroup)
            <option value="{{ $tradeGroup }}" 
                {{ $tradeGroup == old('trade_group', optional($personnel)->trade_group) ? 'selected' : '' }}>
                {{ $tradeGroup }}
            </option>
        @endforeach
    </select>
</div>






<!-- Service Information Fields -->
<div class="form-group col-md-3">
    <label>Date of Enlistment</label>
    <input type="date" name="enlistment_date" id="enlistment_date" class="form-control"
        value="{{ old('enlistment_date', optional($personnel)->enlistment_date ? $personnel->enlistment_date->format('Y-m-d') : '') }}">
</div>

<div class="form-group col-md-3">
    <label>Date of Commission</label>
    <input type="date" name="commission_date" id="commission_date" class="form-control"
        value="{{ old('commission_date', optional($personnel)->commission_date ? $personnel->commission_date->format('Y-m-d') : '') }}">
</div>

<div class="form-group col-md-3">
    <label>Date of Joining Unit</label>
    <input type="date" name="date_of_joining" class="form-control"
        value="{{ old('date_of_joining', optional($personnel)->date_of_joining ? $personnel->date_of_joining->format('Y-m-d') : '') }}">
</div>

<div class="form-group col-md-3">
    <label>Last Date of Promotion</label>
    <input type="date" name="present_rank_date" class="form-control"
        value="{{ old('present_rank_date', optional($personnel)->present_rank_date ? $personnel->present_rank_date->format('Y-m-d') : '') }}">
</div>

<div class="form-group col-md-3">
    <label>Years in Service</label>
    <input type="text" name="years_in_service" id="years_in_service" class="form-control" readonly
        value="{{ old('years_in_service', '') }}">
</div>

<div class="form-group col-md-3">
    <label>SVC ID:</label>
    <input type="text" class="form-control" name="service_id_no" id="service_id_no"
        value="{{ old('service_id_no', $personnel->service_id_no ?? '') }}">
</div>

<div class="form-group col-md-3">
    <label>Current Deployment</label>
    <select name="current_depl_select" id="current_depl_select" class="form-control">
        <option value="">Select Deployment</option>
        @foreach ($deployments as $dep)
            <option value="{{ $dep }}"
                {{ old('current_depl', $personnel->current_depl ?? '') == $dep ? 'selected' : '' }}>
                {{ $dep }}
            </option>
        @endforeach
        <option value="other">Other (type below)</option>
    </select>
    <input type="text" name="current_depl" id="current_depl" class="form-control mt-1" placeholder="Enter deployment"
        value="{{ old('current_depl', $personnel->current_depl ?? '') }}">
</div>

{{-- <div class="form-group col-md-3">
    <label>Trade</label>
    <select name="trade_id" id="trade_id" class="form-control">
        <option value="">Select Trade</option>
        @foreach ($trades as $trade)
            <option value="{{ $trade->id }}" {{ old('trade_id', $personnel->trade_id ?? '') == $trade->id ? 'selected' : '' }}>
                {{ $trade->trade }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-3">
    <label>Trade Group Category</label>
    <select name="trade_group_category_id" id="trade_group_category_id" class="form-control">
        <option value="">Select Trade Group Category</option>
        @foreach ($trade_group_categories as $category)
            <option value="{{ $category->id }}" {{ old('trade_group_category_id', $personnel->trade_group_category_id ?? '') == $category->id ? 'selected' : '' }}>
                {{ $category->category }}
            </option>
        @endforeach
    </select>
</div> --}}

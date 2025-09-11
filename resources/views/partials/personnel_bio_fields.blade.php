

<!-- Personnel Bio Data Fields -->
<div class="form-group col-md-3">
    <label>Service No</label>
    <input type="text" name="service_no" class="form-control" value="{{ old('service_no', $personnel->service_no ?? '') }}">
</div>

<div class="form-group col-md-3" id="present_rank_wrapper">
    <label>Present Rank</label>
    <select name="present_rank" id="present_rank" class="form-control">
        <option value="">Select Rank</option>
        @php $selectedRank = old('present_rank', $personnel->present_rank ?? ''); @endphp
        @foreach ($ranks as $rank)
            <option 
                value="{{ $rank->rank_code }}" 
                data-army="{{ $rank->army_display }}" 
                data-navy="{{ $rank->navy_display }}" 
                data-airforce="{{ $rank->airforce_display }}"
                {{ $selectedRank == $rank->rank_code ? 'selected' : '' }}>
                {{ $rank->getDisplayForService($personnel->arm_of_service ?? '') ?? '-' }}
            </option>
        @endforeach
    </select>
</div>


<div class="form-group col-md-3">
    <label>Surname</label>
    <input type="text" name="surname" class="form-control" value="{{ old('surname', $personnel->surname ?? '') }}">
</div>

<div class="form-group col-md-3">
    <label>Other Names</label>
    <input type="text" name="other_names" class="form-control" value="{{ old('other_names', $personnel->other_names ?? '') }}">
</div>

<div class="form-group col-md-3">
    <label>First Name</label>
    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $personnel->first_name ?? '') }}">
</div>

<div class="form-group col-md-3">
    <label>Gender</label>
    <select name="sex" class="form-control">
        <option value="">Select</option>
        <option value="M" {{ old('sex', $personnel->sex ?? '') == 'M' ? 'selected' : '' }}>Male</option>
        <option value="F" {{ old('sex', $personnel->sex ?? '') == 'F' ? 'selected' : '' }}>Female</option>
    </select>
</div>

<div class="form-group col-md-3">
    <label>Date of Birth</label>
    <input type="date" name="date_of_birth" class="form-control" 
        value="{{ old('date_of_birth', optional($personnel)->date_of_birth ? $personnel->date_of_birth->format('Y-m-d') : '') }}">

</div>


<div class="form-group col-md-3">
    <label>Blood Group</label>
    <select name="blood_group" class="form-control">
        <option value="">Select</option>
        @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
            <option value="{{ $bg }}" {{ old('blood_group', $personnel->blood_group ?? '') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-3">
    <label>Height (m)</label>
    <select id="height_select" class="form-control mb-1">
        <option value="">Select height</option>
        @for ($i = 140; $i <= 200; $i++)
            @php $metres = number_format($i / 100, 2, '.', ''); @endphp
            <option value="{{ $metres }}" {{ old('height', $personnel->height ?? '') == $metres ? 'selected' : '' }}>
                {{ $metres }} m
            </option>
        @endfor
        <option value="other">Other (type below)</option>
    </select>
    <input type="text" name="height" id="height" class="form-control" placeholder="Enter height in metres (e.g. 1.75)" value="{{ old('height', $personnel->height ?? '') }}">
</div>

<div class="form-group col-md-3">
    <label>Weight (kg)</label>
    <select id="weight_select" class="form-control mb-1">
        <option value="">Select weight</option>
        @for ($i = 40; $i <= 120; $i++)
            <option value="{{ $i }}" {{ old('weight', $personnel->weight ?? '') == $i ? 'selected' : '' }}>{{ $i }} kg</option>
        @endfor
        <option value="other">Other (type below)</option>
    </select>
    <input type="text" name="weight" id="weight" class="form-control" placeholder="Enter weight" value="{{ old('weight', $personnel->weight ?? '') }}">
</div>

<div class="form-group col-md-3">
    <label>Visible Mark</label>
    <input type="text" name="mark" class="form-control" value="{{ old('mark', $personnel->mark ?? '') }}">
</div>

<div class="form-group col-md-3">
    <label>Contact Number</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $personnel->phone ?? '') }}">
</div>

<div class="form-group col-md-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $personnel->email ?? '') }}">
</div>

<div class="form-group col-md-3">
    <label>Hometown</label>
    <input type="text" name="hometown" class="form-control" value="{{ old('hometown', $personnel->hometown ?? '') }}">
</div>

<div class="form-group col-md-3">
    <label>Hometown Region</label>
    <select name="hometown_region" id="hometown_region" class="form-control">
        <option value="">Select Region</option>
        @foreach ($regions as $region)
            <option value="{{ $region->region }}" {{ old('hometown_region', $personnel->hometown_region ?? '') == $region->region ? 'selected' : '' }}>
                {{ $region->region }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-3">
    <label>Hometown District</label>
    <select name="hometown_district" id="hometown_district" class="form-control">
        <option value="">Select District</option>
        {{-- Options loaded dynamically --}}
    </select>
</div>

<div class="form-group col-md-3">
    <label>Residence</label>
    <input type="text" name="residential_address" class="form-control" value="{{ old('residential_address', $personnel->residential_address ?? '') }}">
</div>

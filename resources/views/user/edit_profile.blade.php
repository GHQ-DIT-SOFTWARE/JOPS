@extends('adminbackend.layouts.master')

@section('main')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <section class="pcoded-main-container">
        <div class="pcoded-content">

            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Profile</h4>

                        <form method="post" action="{{ route('profile.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>Service No <span class="text-danger"></span></h5>
                                        <input type="text" name="service_no" class="form-control"
                                            value="{{ $user->service_no }}" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>Arm of Service <span class="text-danger">*</span></h5>
                                        <select name="arm_of_service" id="arm_of_service" class="form-control" required onchange="updateRankOptions()">
                                            <option value="">Select</option>
                                            <option value="ARMY" {{ old('arm_of_service', $user->arm_of_service ?? '') == 'ARMY' ? 'selected' : '' }}>ARMY</option>
                                            <option value="NAVY" {{ old('arm_of_service', $user->arm_of_service ?? '') == 'NAVY' ? 'selected' : '' }}>NAVY</option>
                                            <option value="AIRFORCE" {{ old('arm_of_service', $user->arm_of_service ?? '') == 'AIRFORCE' ? 'selected' : '' }}>AIRFORCE</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>Rank <span class="text-danger">*</span></h5>
                                        <select name="rank_id" id="rank_id" class="form-control" required>
                                            <option value="">Select Rank</option>
                                            @foreach ($ranks as $rank)
                                                <option value="{{ $rank->id }}" 
                                                    data-army="{{ $rank->army_display ?? $rank->rank_code }}"
                                                    data-navy="{{ $rank->navy_display ?? $rank->rank_code }}"
                                                    data-airforce="{{ $rank->airforce_display ?? $rank->rank_code }}"
                                                    {{ old('rank_id', $user->rank_id) == $rank->id ? 'selected' : '' }}>
                                                    {{ $rank->getDisplayForService($user->arm_of_service) ?? $rank->rank_code }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>Full Name <span class="text-danger">*</span></h5>
                                        <input type="text" name="fname" class="form-control"
                                            value="{{ old('fname', $user->fname) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>Unit <span class="text-danger">*</span></h5>
                                        <select name="unit_id" class="form-control" required>
                                            <option value="">Select Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}" {{ old('unit_id', $user->unit_id) == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>User Email <span class="text-danger">*</span></h5>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>User Phone</h5>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ old('phone', $user->phone ?? '') }}">
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <h5>Gender</h5>
                                    <select name="gender" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-xs-right">
                                <input type="submit" class="btn btn-rounded btn-info mb-5" value="Update">
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <script>
        // Function to update rank options based on selected arm of service
        function updateRankOptions() {
            const armOfService = document.getElementById('arm_of_service').value;
            const rankSelect = document.getElementById('rank_id');
            
            if (!armOfService) {
                // Reset to default if no service selected
                for (let i = 0; i < rankSelect.options.length; i++) {
                    const option = rankSelect.options[i];
                    if (option.value && option.text) {
                        option.text = option.getAttribute('data-army') || option.value;
                    }
                }
                return;
            }
            
            // Update each option's display text based on the selected service
            for (let i = 0; i < rankSelect.options.length; i++) {
                const option = rankSelect.options[i];
                if (option.value) {
                    const dataAttribute = 'data-' + armOfService.toLowerCase();
                    option.text = option.getAttribute(dataAttribute) || option.value;
                }
            }
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Set initial state based on current arm of service
            updateRankOptions();
            
            // Add event listener to arm of service dropdown
            document.getElementById('arm_of_service').addEventListener('change', updateRankOptions);
        });
    </script>
@endsection
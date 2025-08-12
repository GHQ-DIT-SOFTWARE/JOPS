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
                                        <h5>Rank <span class="text-danger">*</span></h5>
                                        <input type="text" name="rank" class="form-control"
                                            value="{{ $user->rank }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>Full Name <span class="text-danger">*</span></h5>
                                        <input type="text" name="fname" class="form-control"
                                            value="{{ $user->fname }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>Unit <span class="text-danger">*</span></h5>
                                        <input type="text" name="unit" class="form-control"
                                            value="{{ $user->unit }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>User Email <span class="text-danger">*</span></h5>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $user->email }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <h5>User Phone</h5>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ $user->phone ?? '' }}">
                                    </div>
                                </div>


                                
                                <div class="form-group col-md-6">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Male"
                                            {{ old('gender', $user->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female"
                                            {{ old('gender', $user->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>


                                <div class="form-group col-md-6">
                                    <label>Arm of Service</label>
                                    <select name="arm_of_service" class="form-control">
                                        <option value="">Select</option>
                                        <option value="ARMY"
                                            {{ old('arm_of_service', $user->arm_of_service ?? '') == 'ARMY' ? 'selected' : '' }}>ARMY</option>
                                        <option value="NAVY"
                                            {{ old('arm_of_service', $user->arm_of_service ?? '') == 'NAVY' ? 'selected' : '' }}>NAVY</option>
                                            <option value="AIRFORCE"
                                            {{ old('arm_of_service', $user->arm_of_service ?? '') == 'AIRFORCE' ? 'selected' : '' }}>AIRFORCE</option>
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
@endsection

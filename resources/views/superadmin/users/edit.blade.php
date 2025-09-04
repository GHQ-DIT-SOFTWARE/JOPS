@extends('adminbackend.layouts.master')

@section('main')
<section class="pcoded-main-container">
    <div class="pcoded-content">

        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">User Management</h5>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white">
                            <ul class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('superadmin.users.list') }}"><i class="feather icon-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">{{ $nav_title }}</a></li>
                            </ul>
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-light mt-2 mt-md-0">
                                ← Back to Page
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{ route('superadmin.users.update', $user->id) }}" class="forms-sample">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="form-group col-md-6">
                                <label>Service No <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="service_no" value="{{ old('service_no', $user->service_no) }}" required placeholder="Service Number">
                                <div class="text-danger">{{ $errors->first('service_no') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Rank <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="rank" value="{{ old('rank', $user->rank) }}" required placeholder="Rank">
                                <div class="text-danger">{{ $errors->first('rank') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fname" value="{{ old('fname', $user->fname) }}" required placeholder="Full Name">
                                <div class="text-danger">{{ $errors->first('fname') }}</div>
                            </div>

                            <div class="form-group col-md-6">
    <label>Unit <span class="text-danger">*</span></label>
    <select class="form-control" name="unit_id" required>
        <option value="">-- Select Unit --</option>
        @foreach($units as $unit)
            <option value="{{ $unit->id }}" 
                {{ old('unit_id', $user->unit_id) == $unit->id ? 'selected' : '' }}>
                {{ $unit->unit }}
            </option>
        @endforeach
    </select>
    <div class="text-danger">{{ $errors->first('unit_id') }}</div>
</div>


                            <div class="form-group col-md-6">
                                <label>Arm of Service</label>
                                <select class="form-control" name="arm_of_service">
                                    <option value="">-- Select Arm of Service --</option>
                                    <option value="ARMY" {{ old('arm_of_service', $user->arm_of_service) == 'ARMY' ? 'selected' : '' }}>ARMY</option>
                                    <option value="NAVY" {{ old('arm_of_service', $user->arm_of_service) == 'NAVY' ? 'selected' : '' }}>NAVY</option>
                                    <option value="AIRFORCE" {{ old('arm_of_service', $user->arm_of_service) == 'AIRFORCE' ? 'selected' : '' }}>AIRFORCE</option>
                                </select>
                                <div class="text-danger">{{ $errors->first('arm_of_service') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Gender</label>
                                <select class="form-control" name="gender">
                                    <option value="">-- Select Gender --</option>
                                    <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                <div class="text-danger">{{ $errors->first('gender') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required placeholder="Email Address">
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Phone Number">
                                <div class="text-danger">{{ $errors->first('phone') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Role <span class="text-danger">*</span></label>
                                <select class="form-control" name="is_role" required>
                                    <option value="">-- Select Role --</option>
                                    <option value="0" {{ old('is_role', $user->is_role) == '0' ? 'selected' : '' }}>Super Admin</option>
                                    <option value="1" {{ old('is_role', $user->is_role) == '1' ? 'selected' : '' }}>Director General</option>
                                    <option value="2" {{ old('is_role', $user->is_role) == '2' ? 'selected' : '' }}>Director Lands</option>
                                    <option value="3" {{ old('is_role', $user->is_role) == '3' ? 'selected' : '' }}>Director Admin</option>
                                    <option value="4" {{ old('is_role', $user->is_role) == '4' ? 'selected' : '' }}>Duty Officer</option>
                                    <option value="5" {{ old('is_role', $user->is_role) == '5' ? 'selected' : '' }}>Duty Clerk</option>
                                    <option value="6" {{ old('is_role', $user->is_role) == '6' ? 'selected' : '' }}>Duty Wo</option>
                                    <option value="7" {{ old('is_role', $user->is_role) == '7' ? 'selected' : '' }}>Duty Driver</option>
                                    <option value="8" {{ old('is_role', $user->is_role) == '8' ? 'selected' : '' }}>Duty Radio/Operator</option>
                                </select>
                                <div class="text-danger">{{ $errors->first('is_role') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>New Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current">
                                <div class="text-danger">{{ $errors->first('password') }}</div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Confirm New Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password">
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                        <a href="{{ route('superadmin.users.list') }}" class="btn btn-light">Cancel</a>

                        <!-- Default password note -->
                        <p class="mt-3 text-muted">
                            Default password for new users is <strong>123456</strong> (please change on first login).
                        </p>

                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@extends('adminbackend.layouts.master')

@section('main')
<section class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">{{ $nav_title }}</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route($role.'.dashboard') }}"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- marquee -->
            <div class="card w-100">
                <div class="card-body py-2">
                    <marquee behavior="scroll" direction="left" scrollamount="5" class="text-deep-brown">
                        <b>
                            Breaking: New policy update released. •
                            Reminder: Submit duty reports by end of day. •
                            Incoming mails processed successfully. •
                            Outgoing mails dispatch scheduled for tomorrow.
                        </b>
                    </marquee>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Cards -->
            <div class="col-xl-3 col-md-6">
                <div class="card glass-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="{{ asset('assets/images/vector 1.png') }}" width="75" height="75" alt="">
                            </div>
                            <div class="col-auto">
                                <h6 class="text-muted m-b-10">Pending Reports</h6>
                                <h4>{{ $pendingCount ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card glass-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="{{ asset('assets/images/vector 5.png') }}" width="75" height="75" alt="">
                            </div>
                            <div class="col-auto">
                                <h6 class="text-muted m-b-10">Awaiting Approval</h6>
                                <h4>{{ $awaitingApprovalCount ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card glass-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="{{ asset('assets/images/vector 3.png') }}" width="75" height="75" alt="">
                            </div>
                            <div class="col-auto">
                                <h6 class="text-muted m-b-10">Approved Reports</h6>
                                <h4>{{ $approvedCount ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- You can add more role-specific cards here -->
        </div>
    </div>
</section>
@endsection

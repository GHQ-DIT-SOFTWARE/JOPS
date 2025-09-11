@php
use Carbon\Carbon;
@endphp
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
                            <h5 class="m-b-10">{{ $nav_title }}</h5>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white">
                            <ul class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">D Clerk Dashboard</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Main Content -->
        <div class="col-md-12">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="feather icon-users fa-2x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $accountStatus->total ?? 0 }}</h4>
                                    <p class="mb-0">Total Officers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="feather icon-user-plus fa-2x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $accountStatus->needed ?? 0 }}</h4>
                                    <p class="mb-0">Need Accounts</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="feather icon-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $accountStatus->created ?? 0 }}</h4>
                                    <p class="mb-0">Accounts Created</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('dclerk.accounts') }}" class="btn btn-primary w-100">
                                        <i class="feather icon-user-plus"></i> Manage Accounts
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('dclerk.roster.view') }}" class="btn btn-info w-100">
                                        <i class="feather icon-calendar"></i> View Roster
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('dclerk.communication') }}" class="btn btn-warning w-100">
                                        <i class="feather icon-mail"></i> Send Communications
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('dclerk.reports') }}" class="btn btn-success w-100">
                                        <i class="feather icon-file-text"></i> Generate Reports
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Recent Account Activity</h5>
                        </div>
                        <div class="card-body">
                            @if($recentActivity->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Officer</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentActivity as $activity)
                                            <tr>
                                                <td>{{ $activity->user->display_rank }} {{ $activity->user->fname }}</td>
                                                <td>
                                                    @if($activity->account_created)
                                                        <span class="badge bg-success">Created</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>{{ $activity->created_at->format('M d, Y') }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No recent activity found.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5>Roster Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <h3 class="text-{{ $rosterStatus && $rosterStatus->status == 'published' ? 'success' : 'warning' }}">
                                    {{ $rosterStatus ? ucfirst($rosterStatus->status) : 'Draft' }}
                                </h3>
                                <p class="text-muted">Current Roster Status for {{ Carbon::now()->format('F Y') }}</p>
                                
                                @if($rosterStatus && $rosterStatus->status == 'published')
                                    <div class="alert alert-success">
                                        <i class="feather icon-check-circle"></i> Roster is published and visible to duty officers.
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="feather icon-alert-triangle"></i> Roster is not yet published.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
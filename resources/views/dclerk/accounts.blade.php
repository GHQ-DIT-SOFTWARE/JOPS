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
                                <li class="breadcrumb-item"><a href="{{ route('dclerk.dashboard') }}">D Clerk Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#!">Manage Accounts</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Main Content -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Officer Accounts Management - {{ Carbon::create($year, $month, 1)->format('F Y') }}</h5>
                </div>
                <div class="card-body">
                    <!-- Month Selection -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('dclerk.accounts') }}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="month">Select Month</label>
                                                    <select class="form-control" id="month" name="month">
                                                        @for($m = 1; $m <= 12; $m++)
                                                            <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                                                {{ Carbon::create()->month($m)->format('F') }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="year">Select Year</label>
                                                    <select class="form-control" id="year" name="year">
                                                        @for($y = date('Y') - 1; $y <= date('Y') + 1; $y++)
                                                            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                                                {{ $y }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="submit" class="btn btn-primary w-100">Load</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accounts Summary -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="feather icon-info"></i> 
                                Found {{ $officersNeedingAccounts->count() }} officers needing accounts for {{ Carbon::create($year, $month, 1)->format('F Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Create Accounts Button -->
                    @if($officersNeedingAccounts->count() > 0)
                    <div class="row mb-4">
                        <div class="col-md-12 text-center">
                            <form method="POST" action="{{ route('dclerk.create-accounts') }}">
                                
                                @csrf
                                <input type="hidden" name="month" value="{{ $month }}">
                                <input type="hidden" name="year" value="{{ $year }}">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="feather icon-user-plus"></i> Create Accounts for {{ $officersNeedingAccounts->count() }} Officer(s)
                                </button>
                                <p class="text-muted mt-2">This will generate temporary passwords for all officers needing accounts</p>
                            </form>
                        </div>
                    </div>
                    @endif

                    
                    <!-- Officers Needing Accounts -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Officers Needing Accounts</h6>
                                </div>
                                <div class="card-body">
                                    @if($officersNeedingAccounts->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Service No</th>
                                                        <th>Name</th>
                                                        <th>Rank</th>
                                                        <th>Unit</th>
                                                        <th>Arm of Service</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($officersNeedingAccounts as $account)
                                                    <tr>
                                                        <td>{{ $account->user->service_no }}</td>
                                                        <td>{{ $account->user->fname }}</td>
                                                        <td>{{ $account->user->display_rank }}</td>
                                                        <td>{{ $account->user->unit->unit ?? 'N/A' }}</td>
                                                        <td>{{ $account->user->arm_of_service }}</td>
                                                        <td>
                                                            <span class="badge bg-warning">Needs Account</span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-success">
                                            <i class="feather icon-check-circle"></i> 
                                            All officers have accounts for {{ Carbon::create($year, $month, 1)->format('F Y') }}!
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
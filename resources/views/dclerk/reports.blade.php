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
                                <li class="breadcrumb-item"><a href="#!">Account Reports</a></li>
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
                    <h5>Account Creation Reports - {{ Carbon::create($year, $month, 1)->format('F Y') }}</h5>
                </div>
                <div class="card-body">
                    <!-- Report Filters -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('dclerk.reports') }}">
                                        <div class="row">
                                            <div class="col-md-4">
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Summary -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Monthly Summary</h6>
                                </div>
                                <div class="card-body">
                                    @if($monthlySummary->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Created By</th>
                                                        <th>Total Needed</th>
                                                        <th>Total Created</th>
                                                        <th>Completion Rate</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($monthlySummary as $summary)
                                                    <tr>
                                                        <td>{{ $summary->creator->fname ?? 'System' }}</td>
                                                        <td>{{ $summary->total_needed }}</td>
                                                        <td>{{ $summary->total_created }}</td>
                                                        <td>
                                                            @php
                                                                $rate = $summary->total_needed > 0 ? ($summary->total_created / $summary->total_needed) * 100 : 100;
                                                            @endphp
                                                            <div class="progress" style="height: 20px;">
                                                                <div class="progress-bar {{ $rate == 100 ? 'bg-success' : 'bg-warning' }}" 
                                                                     role="progressbar" style="width: {{ $rate }}%;" 
                                                                     aria-valuenow="{{ $rate }}" aria-valuemin="0" aria-valuemax="100">
                                                                    {{ round($rate) }}%
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="feather icon-info"></i> 
                                            No account activity found for {{ Carbon::create($year, $month, 1)->format('F Y') }}.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Report -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Detailed Account Activity</h6>
                                </div>
                                <div class="card-body">
                                    @if($accountStats->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Created By</th>
                                                        <th>Accounts Created</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($accountStats as $stat)
                                                    <tr>
                                                        <td>{{ Carbon::parse($stat->created_date)->format('M d, Y') }}</td>
                                                        <td>{{ $stat->creator->fname ?? 'System' }}</td>
                                                        <td>{{ $stat->total }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="feather icon-info"></i> 
                                            No detailed account activity found.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Export Buttons -->
                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-success">
                                <i class="feather icon-download"></i> Export to Excel
                            </button>
                            <button class="btn btn-danger">
                                <i class="feather icon-file-text"></i> Export to PDF
                            </button>
                            <button class="btn btn-primary" onclick="window.print()">
                                <i class="feather icon-printer"></i> Print Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
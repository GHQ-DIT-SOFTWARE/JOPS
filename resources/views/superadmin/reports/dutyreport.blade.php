@extends('adminbackend.layouts.master')

@section('main')
    @php
        // Count reports by status for the current user
        $approvedCount = $reports->where('status', 'approved')->count();
        $pendingDlandCount = $reports->where('status', 'pending_dland')->count();
        $awaitingApprovalCount = $reports->where('status', 'awaiting_approval')->count();
    @endphp

    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Duty Officer Dashboard</h5>
                            </div>

                            <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white mt-2">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="index.html"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">Duty Report</a></li>
                                </ul>

                                @php
                                    $user = auth()->user();
                                    $hasPendingReport =
                                        $reports->whereIn('status', ['pending_dland', 'awaiting_approval'])->count() >
                                        0;
                                @endphp

                                @if (!$hasPendingReport)
                                    <a href="{{ route('superadmin.reports.addreport') }}"
                                        class="btn btn-sm btn-light mt-2 mt-md-0">
                                        + Add New Report
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-light mt-2 mt-md-0" disabled
                                        title="You have a pending report that needs approval before submitting a new one">
                                        + Add New Report
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="card glass-card">
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/images/verify1.png') }}" alt="" width="70px"
                                height="75px">
                            <h4 class="m-t-20">Approved Reports</h4>
                            <span
                                style="display: inline-block; background-color: #42a116; color: white; width: 60px; height: 40px; text-align: center; line-height: 40px; font-size: 20px; font-weight: bold; border-radius: 10px;">
                                {{ $approvedCount }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card glass-card">
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/images/pending1.png') }}" alt="" width="75px"
                                height="75px">
                            <h4 class="m-t-20">Pending DLand</h4>
                            <span
                                style="display: inline-block; background-color: #daae2b; color: white; width: 60px; height: 40px; text-align: center; line-height: 40px; font-size: 20px; font-weight: bold; border-radius: 10px;">
                                {{ $pendingDlandCount }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card glass-card">
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/images/pending1.png') }}" alt="" width="75px"
                                height="75px">
                            <h4 class="m-t-20">Awaiting DG Approval</h4>
                            <span
                                style="display: inline-block; background-color: #2b7bda; color: white; width: 60px; height: 40px; text-align: center; line-height: 40px; font-size: 20px; font-weight: bold; border-radius: 10px;">
                                {{ $awaitingApprovalCount }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>My Duty Reports</h5>
                            <div class="card-header-right">
                                <div class="btn-group card-option">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="feather icon-more-horizontal"></i>
                                    </button>
                                    <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-item full-card"><a href="#!"><span><i
                                                        class="feather icon-maximize"></i> maximize</span><span
                                                    style="display:none"><i class="feather icon-minimize"></i>
                                                    Restore</span></a></li>
                                        <li class="dropdown-item minimize-card"><a href="#!"><span><i
                                                        class="feather icon-minus"></i> collapse</span><span
                                                    style="display:none"><i class="feather icon-plus"></i> expand</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="left-right-fix" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Service No</th>
                                            <th>Reporting Time</th>
                                            <th>Period Covered</th>
                                            <th>Status</th>
                                            <th>Submitted At</th>
                                            <th>Last Updated</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($reports as $report)
                                            <tr>
                                                <td>{{ $report->user_service_no }}</td>
                                                <td>{{ \Carbon\Carbon::parse($report->reporting_time)->format('h:i A') }}
                                                </td>
                                                <td>{{ $report->period_covered }}</td>
                                                <td>
                                                    @if ($report->status == 'approved')
                                                        <span class="badge bg-success">Approved</span>
                                                    @elseif($report->status == 'pending_dland')
                                                        <span class="badge bg-warning text-dark">Pending DLand</span>
                                                    @elseif($report->status == 'awaiting_approval')
                                                        <span class="badge bg-info">Awaiting DG Approval</span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ ucfirst($report->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($report->submitted_at)
                                                        {{ \Carbon\Carbon::parse($report->submitted_at)->format('Y-m-d h:i A') }}
                                                    @else
                                                        <span class="text-muted">Not submitted</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($report->updated_at)->format('Y-m-d h:i A') }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('superadmin.reports.view', $report->id) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="feather icon-eye"></i> View
                                                    </a>
                                                    @if (!$report->submitted_at)
                                                        <a href="{{ route('superadmin.reports.edit', $report->id) }}"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="feather icon-edit"></i> Edit
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No duty reports found. <a
                                                        href="{{ route('superadmin.reports.addreport') }}">Create your
                                                        first report</a></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script>
        $(document).ready(function() {
            $('#left-right-fix').DataTable({
                "order": [
                    [5, "desc"]
                ], // Sort by last updated column
                "responsive": true,
                "autoWidth": false,
                "columnDefs": [{
                        "responsivePriority": 1,
                        "targets": 0
                    }, // Service No
                    {
                        "responsivePriority": 2,
                        "targets": 6
                    }, // Actions
                    {
                        "responsivePriority": 3,
                        "targets": 3
                    } // Status
                ]
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
@endsection


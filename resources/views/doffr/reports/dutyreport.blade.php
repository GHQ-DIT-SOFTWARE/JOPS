@extends('adminbackend.layouts.master')

@section('main')
<section class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12 d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <div class="page-header-title">
                                <h5 class="m-b-10">{{ $nav_title ?? 'Duty Officer Dashboard' }}</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dg.dashboard') }}"><i class="feather icon-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">Duty Reports</a></li>
                            </ul>
                        </div>

                        @if (Auth::user()->is_role == 0 || Auth::user()->is_role == 4)
                            <a href="{{ route('doffr.reports.addreport') }}" class="btn btn-sm btn-primary">
                                + Add New Report
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
        @endif

        @if (session('notification'))
            <div class="alert alert-{{ session('notification')['alert-type'] }} alert-dismissible fade show" role="alert">
                {{ session('notification')['message'] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
        @endif

        {{-- Summary Boxes --}}
        @php
            $approvedCount = $reports->where('status', 'approved')->count();
            $pendingDlandCount = $reports->where('status', 'pending_dland')->count();
            $awaitingApprovalCount = $reports->where('status', 'awaiting_approval')->count();
        @endphp

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card glass-card clickable-summary-box" data-status="pending_dland" style="cursor:pointer;">
                    <div class="card-body text-center">
                        <img src="{{ asset('assets/images/pending1.png') }}" alt="" width="75px" height="75px">
                        <h4 class="m-t-20">Pending DLand</h4>
                        <span class="badge-status" style="background-color: #daae2b;">{{ $pendingDlandCount }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card glass-card clickable-summary-box" data-status="awaiting_approval" style="cursor:pointer;">
                    <div class="card-body text-center">
                        <img src="{{ asset('assets/images/pending1.png') }}" alt="" width="75px" height="75px">
                        <h4 class="m-t-20">Awaiting DG Approval</h4>
                        <span class="badge-status" style="background-color: #2b7bda;">{{ $awaitingApprovalCount }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card glass-card clickable-summary-box" data-status="approved" style="cursor:pointer;">
                    <div class="card-body text-center">
                        <img src="{{ asset('assets/images/verify1.png') }}" alt="" width="75px" height="75px">
                        <h4 class="m-t-20">Approved Reports</h4>
                        <span class="badge-status" style="background-color: #42a116;">{{ $approvedCount }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="mb-3 row align-items-end">
            <div class="col-md-3">
                <label>Status</label>
                <select id="statusFilter" class="form-control">
                    <option value="">-- All --</option>
                    <option value="approved">Approved</option>
                    <option value="pending_dland">Pending DLand</option>
                    <option value="awaiting_approval">Awaiting DG Approval</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Date Range (Updated At)</label>
                <input type="text" id="dateRange" class="form-control" placeholder="Select date range" readonly>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" id="filterBtn">Filter</button>
            </div>

            <div class="col-md-2">
                <button class="btn btn-secondary" id="resetBtn">Reset</button>
            </div>
        </div>

        {{-- Table --}}
        <div class="card">
            <div class="card-header">
                <h5>My Duty Reports</h5>
            </div>
            <div class="card-body table-responsive">
                <table id="dland-report-table" class="table table-striped table-bordered nowrap" style="width:100%">
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
                                <td>{{ \Carbon\Carbon::parse($report->reporting_time)->format('h:i A') }}</td>
                                <td>{{ $report->period_covered }}</td>
                                <td>
                                    @switch($report->status)
                                        @case('approved') <span class="badge bg-success">Approved</span> @break
                                        @case('pending_dland') <span class="badge bg-warning text-dark">Pending DLand</span> @break
                                        @case('awaiting_approval') <span class="badge bg-info">Awaiting DG Approval</span> @break
                                        @default <span class="badge bg-secondary">{{ ucfirst($report->status) }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    @if ($report->submitted_at)
                                        {{ \Carbon\Carbon::parse($report->submitted_at)->format('Y-m-d h:i A') }}
                                    @else
                                        <span class="text-muted">Not submitted</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($report->updated_at)->format('Y-m-d h:i A') }}</td>
                                <td>
                                    <a href="{{ route('doffr.reports.view', $report->id) }}" class="btn btn-sm btn-info">
                                        <i class="feather icon-eye"></i> View
                                    </a>
                                    <a href="{{ route('doffr.reports.pdf', $report->id) }}" target="_blank" class="btn btn-sm btn-danger">
                                        <i class="feather icon-printer"></i> PDF
                                    </a>

                                    @if (!$report->submitted_at)
                                        <a href="{{ route('doffr.reports.edit', $report->id) }}" class="btn btn-sm btn-warning">
                                            <i class="feather icon-edit"></i> Edit
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No reports found. <a href="{{ route('doffr.reports.addreport') }}">Create one</a>.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

{{-- Scripts --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    $(document).ready(function () {
        const table = $('#dland-report-table').DataTable({
            order: [[5, 'desc']],
            responsive: true
        });

        $('#dateRange').daterangepicker({
            autoUpdateInput: false,
            locale: { cancelLabel: 'Clear' }
        });

        $('#dateRange').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('#dateRange').on('cancel.daterangepicker', function () {
            $(this).val('');
        });

        let activeSummaryStatus = '';

        function filterTable() {
            const status = $('#statusFilter').val().toLowerCase();
            const range = $('#dateRange').val();

            table.rows().every(function () {
                const row = $(this.node());
                const rowStatus = row.find('td:nth-child(4) span').text().toLowerCase().trim();
                const updatedAt = row.find('td:nth-child(6)').text().trim();
                const updatedDate = moment(updatedAt, 'YYYY-MM-DD hh:mm A');

                let show = true;

                if (activeSummaryStatus && rowStatus !== activeSummaryStatus) show = false;
                else if (!activeSummaryStatus && status && !rowStatus.includes(status)) show = false;

                if (range) {
                    const [start, end] = range.split(' - ');
                    if (!updatedDate.isBetween(moment(start), moment(end).endOf('day'), null, '[]')) show = false;
                }

                row.toggle(show);
            });
        }

        $('#filterBtn').click(function () {
            activeSummaryStatus = '';
            $('.clickable-summary-box').removeClass('active');
            filterTable();
        });

        $('#resetBtn').click(function () {
            activeSummaryStatus = '';
            $('#statusFilter').val('');
            $('#dateRange').val('');
            $('.clickable-summary-box').removeClass('active');
            table.rows().every(function () { $(this.node()).show(); });
        });

        $('.clickable-summary-box').click(function () {
            $('.clickable-summary-box').removeClass('active');
            $(this).addClass('active');
            activeSummaryStatus = $(this).data('status');
            $('#statusFilter').val('');
            $('#dateRange').val('');
            filterTable();
        });

        setTimeout(function () {
            $('.alert').alert('close');
        }, 5000);
    });

    // Recall AJAX functionality (if used elsewhere)
    $(document).on('click', '.recall-btn', function () {
        const reportId = $(this).data('id');
        if (confirm('Are you sure you want to recall this report?')) {
            $.ajax({
                url: '{{ url('reports') }}/' + reportId + '/recall',
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function (res) {
                    if (res.success) location.href = res.redirect;
                    else alert(res.message);
                },
                error: function () {
                    alert('Error recalling report');
                }
            });
        }
    });
</script>

<style>
    .clickable-summary-box.active {
        border: 3px solid #007bff;
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }

    .badge-status {
        display: inline-block;
        color: white;
        width: 60px;
        height: 40px;
        text-align: center;
        line-height: 40px;
        font-size: 20px;
        font-weight: bold;
        border-radius: 10px;
    }
</style>
@endsection

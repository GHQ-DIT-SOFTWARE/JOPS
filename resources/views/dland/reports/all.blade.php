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
                                <li class="breadcrumb-item">
                                    <a href="{{ route('dg.dashboard') }}"><i class="feather icon-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">Reports</a></li>
                            </ul>
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

            @php
                // Calculate counts for summary boxes
                $approvedCount = $reports->where('status', 'approved')->count();
                $pendingDlandCount = $reports->where('status', 'pending_dland')->count();
                $awaitingApprovalCount = $reports->where('status', 'awaiting_approval')->count();
            @endphp

            {{-- Summary boxes with clickable filter --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card glass-card clickable-summary-box" data-status="pending_dland" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/images/pending1.png') }}" alt="" width="75px" height="75px">
                            <h4 class="m-t-20">Pending DLand</h4>
                            <span
                                style="display: inline-block; background-color: #daae2b; color: white; width: 60px; height: 40px; text-align: center; line-height: 40px; font-size: 20px; font-weight: bold; border-radius: 10px;">
                                {{ $pendingDlandCount }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card glass-card clickable-summary-box" data-status="awaiting_approval" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/images/pending1.png') }}" alt="" width="75px" height="75px">
                            <h4 class="m-t-20">Awaiting DG Approval</h4>
                            <span
                                style="display: inline-block; background-color: #2b7bda; color: white; width: 60px; height: 40px; text-align: center; line-height: 40px; font-size: 20px; font-weight: bold; border-radius: 10px;">
                                {{ $awaitingApprovalCount }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card glass-card clickable-summary-box" data-status="approved" style="cursor:pointer;">
                        <div class="card-body text-center">
                            <img src="{{ asset('assets/images/verify1.png') }}" alt="" width="75px" height="75px">
                            <h4 class="m-t-20">Approved Reports</h4>
                            <span
                                style="display: inline-block; background-color: #42a116; color: white; width: 60px; height: 40px; text-align: center; line-height: 40px; font-size: 20px; font-weight: bold; border-radius: 10px;">
                                {{ $approvedCount }}
                            </span>
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

            {{-- Reports table --}}
            <div class="card">
                <div class="card-header">
                    <h5>All Duty Reports</h5>
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
                                        @if ($report->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($report->status == 'pending_dland')
                                            <span class="badge bg-warning text-dark">Pending DLand</span>
                                        @elseif($report->status == 'awaiting_approval')
                                            <span class="badge bg-info">Awaiting DG Approval</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($report->status) }}</span>
                                        @endif
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
                                        <a href="{{ route('dland.reports.view', $report->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="feather icon-eye"></i> View
                                        </a>

                                        <a href="{{ route('doffr.reports.pdf', $report->id) }}" target="_blank"
                                            class="btn btn-sm btn-danger">
                                            <i class="feather icon-printer"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No reports found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery here -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> <!-- moment.js -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> <!-- DataTables -->
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> <!-- daterangepicker -->


    <script>
        $(document).ready(function () {
            const table = $('#dland-report-table').DataTable({
                order: [[5, "desc"]],
                responsive: true
            });

            // Initialize date range picker
            $('#dateRange').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            });

            $('#dateRange').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#dateRange').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            // Variables to track filters
            let activeSummaryStatus = ''; // status filter from summary boxes

            // Function to filter table rows based on current filters
            function filterTable() {
                const statusFilter = $('#statusFilter').val().toLowerCase();
                const dateRange = $('#dateRange').val();

                table.rows().every(function () {
                    const row = this.node();
                    const rowData = this.data();

                    const rowStatus = $(row).find('td:nth-child(4) span').text().trim().toLowerCase();
                    const updatedAt = $(row).find('td:nth-child(6)').text().trim(); // 6th col = updated_at

                    let showRow = true;

                    // Priority to summary box filter if set
                    if (activeSummaryStatus) {
                        if (rowStatus !== activeSummaryStatus) {
                            showRow = false;
                        }
                    } else if (statusFilter) {
                        if (!rowStatus.includes(statusFilter)) {
                            showRow = false;
                        }
                    }

                    // Filter by date range if set
                    if (dateRange) {
                        const [start, end] = dateRange.split(' - ');
                        const updatedDate = moment(updatedAt, 'YYYY-MM-DD hh:mm A');
                        if (!updatedDate.isBetween(moment(start), moment(end).endOf('day'), null, '[]')) {
                            showRow = false;
                        }
                    }

                    $(row).toggle(showRow);
                });
            }

            // Filter button click
            $('#filterBtn').on('click', function () {
                activeSummaryStatus = ''; // Clear summary filter on manual filter
                $('.clickable-summary-box').removeClass('active');
                filterTable();
            });

            // Reset button click
            $('#resetBtn').on('click', function () {
                activeSummaryStatus = '';
                $('#statusFilter').val('');
                $('#dateRange').val('');
                $('.clickable-summary-box').removeClass('active');
                table.rows().every(function () {
                    $(this.node()).show();
                });
            });

            // Click event for summary boxes to filter by status
            $('.clickable-summary-box').on('click', function () {
                // Remove active class from all boxes
                $('.clickable-summary-box').removeClass('active');

                // Set this one as active
                $(this).addClass('active');

                // Get status filter from data attribute
                activeSummaryStatus = $(this).data('status');

                // Clear filters form controls
                $('#statusFilter').val('');
                $('#dateRange').val('');

                filterTable();
            });

            // Optional: Auto-dismiss alerts after 5 seconds
            setTimeout(function () {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>

    <style>
        /* Highlight the active summary box */
        .clickable-summary-box.active {
            border: 3px solid #007bff;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            transition: box-shadow 0.3s, border-color 0.3s;
        }
    </style>
@endsection

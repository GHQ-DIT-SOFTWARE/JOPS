@extends('adminbackend.layouts.master')

@section('main')
    <!-- Load external CSS libraries first -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            background-color: #ffffff;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card .card-header {
            border-radius: 15px 15px 0 0;
            background: linear-gradient(135deg, #3b87b3 0%, #2c6e9b 100%);
            color: #ffffff;
            padding: 15px 20px;
            font-weight: 600;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b87b3 0%, #2c6e9b 100%);
            border: none;
            border-radius: 8px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 135, 179, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-outline-light {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 5px 15px;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background-color: #3b87b3;
            color: white;
            border-color: #3b87b3;
        }

        #deployment-table.table {
            font-size: 14px;
            border-radius: 10px;
            overflow: hidden;
        }

        #deployment-table thead th {
            background: linear-gradient(135deg, #3b87b3 0%, #2c6e9b 100%);
            color: #ffffff;
            font-weight: 600;
            text-align: center;
            padding: 15px;
            border: none;
        }

        #deployment-table tbody td {
            padding: 12px 15px;
            text-align: center;
            vertical-align: middle;
        }

        #deployment-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        #deployment-table tbody tr:hover {
            background-color: #e3f2fd;
            transition: background-color 0.3s ease;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, #3b87b3 0%, #2c6e9b 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            border: none;
            padding: 20px;
        }

        .modal-title {
            font-weight: 600;
        }

        .modal-body {
            padding: 25px;
        }

        .modal-footer {
            border-radius: 0 0 15px 15px;
            border: none;
            padding: 20px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .stats-card {
            background: linear-gradient(135deg, #3b87b3 0%, #2c6e9b 100%);
            color: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
    </style>

    <section class="pcoded-main-container">
        <div class="pcoded-content">

            <!-- Breadcrumb -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">{{ $nav_title }}</h5>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ url('/') }}"><i class="feather icon-home"></i></a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="#!">{{ $nav_title }}</a></li>
                                </ul>
                                <a href="{{ route('duty_roster.select') }}" class="btn btn-primary">
                                    <i class="fas fa-users"></i> Manage Availability
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-number">{{ $rosters->count() }}</div>
                        <div class="stats-label">Total Rosters</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-number">{{ $rosters->where('created_at', '>=', now()->startOfWeek())->count() }}
                        </div>
                        <div class="stats-label">This Week</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-number">{{ $personnel->count() }}</div>
                        <div class="stats-label">Available Personnel</div>
                    </div>
                </div>
            </div>

            <!-- DataTable Card -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Duty Rosters</h5>
                            <div class="btn-group">
                                <button class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#generateRosterModal">
                                    <i class="fas fa-plus-circle"></i> Generate New Roster
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-4">

                            <!-- Generate Roster Modal -->
                            <div class="modal fade" id="generateRosterModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Generate New Duty Roster</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('duty_roster.generate') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="week_start_date" class="form-label">Week Start Date</label>
                                                    <input type="date" class="form-control" name="week_start_date"
                                                        id="week_start_date"
                                                        value="{{ now()->startOfWeek()->format('Y-m-d') }}" required>
                                                    <div class="form-text">Select the Monday of the week you want to
                                                        generate roster for</div>
                                                </div>
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle"></i> This will generate a roster using
                                                    currently available personnel.
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-play-circle"></i> Generate Roster
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover" id="deployment-table">
                                    <thead>
                                        <tr>
                                            <th>Week Period</th>
                                            <th>Duration</th>
                                            <th>Created By</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rosters as $roster)
                                            <tr>
                                                <td>
                                                    <strong>{{ $roster->week_start_date->format('M d') }}</strong>
                                                    to
                                                    <strong>{{ $roster->week_end_date->format('M d, Y') }}</strong>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">
                                                        {{ $roster->week_start_date->diffInDays($roster->week_end_date) + 1 }}
                                                        days
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-muted">{{ $roster->createdBy->name ?? 'System' }}</span>
                                                    <br>
                                                    <small
                                                        class="text-muted">{{ $roster->created_at->format('M d, Y H:i') }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-status bg-success">Active</span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="{{ route('duty_roster.show', $roster->id) }}"
                                                            class="btn btn-sm btn-primary" title="View Roster">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                        <a href="{{ route('duty_roster.export.pdf', $roster->id) }}"
                                                            class="btn btn-sm btn-outline-danger" title="View PDF"
                                                            target="_blank">
                                                            <i class="fas fa-file-pdf"></i> PDF
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- DataTables Script -->
    <script>
        $(document).ready(function() {
            $('#deployment-table').DataTable({
                order: [
                    [0, 'desc']
                ],
                pageLength: 10,
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search rosters..."
                }
            });
        });
    </script>
@endsection

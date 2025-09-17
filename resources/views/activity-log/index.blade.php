<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log - GHQ Ops System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    
    <style>
        :root {
            --primary-color: #3f80ea;
            --secondary-color: #6c757d;
            --success-color: #1cbb8c;
            --info-color: #17a2b8;
            --warning-color: #fcb92c;
            --danger-color: #dc3545;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
        }
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: none;
            margin-bottom: 24px;
        }
        
        .card-header {
            background: linear-gradient(120deg, #3f80ea, #5a93f1);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            border-bottom: none;
        }
        
        .page-title {
            font-weight: 600;
            font-size: 1.4rem;
            margin: 0;
        }
        
        .filter-section {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .filter-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #4a5568;
        }
        
        .table th {
            background-color: #f1f5f9;
            color: #4a5568;
            font-weight: 600;
            border-top: none;
            padding: 12px 15px;
        }
        
        .table td {
            padding: 12px 15px;
            vertical-align: middle;
        }
        
        .badge {
            font-weight: 500;
            padding: 6px 10px;
            border-radius: 20px;
        }
        
        .action-badge {
            font-size: 0.85rem;
        }
        
        .stats-card {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .stats-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .stats-number {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stats-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            background-color: #3f80ea;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        
        .pagination .page-link {
            border-radius: 6px;
            margin: 0 3px;
            border: 1px solid #dee2e6;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #3f80ea;
            border-color: #3f80ea;
        }
        
        .export-btn {
            background: linear-gradient(120deg, #1cbb8c, #20c997);
            border: none;
            border-radius: 6px;
            padding: 8px 16px;
            color: white;
            font-weight: 500;
        }
        
        .export-btn:hover {
            background: linear-gradient(120deg, #18a87c, #1cbb8c);
            color: white;
        }
        
        .filter-toggle {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 15px;
            font-weight: 500;
            color: #4a5568;
        }
        
        .filter-toggle:hover {
            background-color: #edf2f7;
        }
        
        .details-toggle {
            cursor: pointer;
            color: #3f80ea;
        }
        
        .details-toggle:hover {
            color: #2c5fb7;
        }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="page-title mb-0"><i class="fas fa-history me-2"></i>Activity Log</h5>
                    <div>
                        <a href="{{ route('activity-log.replacements') }}" class="btn btn-light btn-sm me-2">
                            <i class="fas fa-exchange-alt me-1"></i> View Replacements
                        </a>
                        <button class="btn btn-light btn-sm" onclick="window.print()">
                            <i class="fas fa-print me-1"></i> Print
                        </button>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Stats Overview -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="stats-card" style="background: linear-gradient(120deg, #e1f0ff, #cfe5ff);">
                                <div class="stats-icon text-primary">
                                    <i class="fas fa-history"></i>
                                </div>
                                <div class="stats-number text-primary">{{ $activities->total() }}</div>
                                <div class="stats-label">Total Activities</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card" style="background: linear-gradient(120deg, #fff2cc, #ffe999);">
                                <div class="stats-icon text-warning">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div class="stats-number text-warning">
                                    {{ \App\Models\ActivityLog::where('action', 'replaced')->count() }}
                                </div>
                                <div class="stats-label">Replacements</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card" style="background: linear-gradient(120deg, #d5f5e3, #abebc6);">
                                <div class="stats-icon text-success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="stats-number text-success">
                                    {{ \App\Models\ActivityLog::where('action', 'published')->count() }}
                                </div>
                                <div class="stats-label">Published Rosters</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card" style="background: linear-gradient(120deg, #ffcccc, #ff9999);">
                                <div class="stats-icon text-danger">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div class="stats-number text-danger">
                                    {{ \App\Models\ActivityLog::where('action', 'removed')->count() }}
                                </div>
                                <div class="stats-label">Removed Assignments</div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Stats Row -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="stats-card" style="background: linear-gradient(120deg, #d4edda, #c3e6cb);">
                                <div class="stats-icon text-success">
                                    <i class="fas fa-sign-in-alt"></i>
                                </div>
                                <div class="stats-number text-success">
                                    {{ \App\Models\ActivityLog::where('action', 'logged_in')->count() }}
                                </div>
                                <div class="stats-label">Successful Logins</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card" style="background: linear-gradient(120deg, #fff3cd, #ffeaa7);">
                                <div class="stats-icon text-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="stats-number text-warning">
                                    {{ \App\Models\ActivityLog::where('action', 'login_failed')->count() }}
                                </div>
                                <div class="stats-label">Failed Logins</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card" style="background: linear-gradient(120deg, #d1ecf1, #bee5eb);">
                                <div class="stats-icon text-info">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="stats-number text-info">
                                    {{ \App\Models\ActivityLog::whereIn('action', ['sms_sent', 'email_sent', 'bulk_communication'])->count() }}
                                </div>
                                <div class="stats-label">Communications</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card" style="background: linear-gradient(120deg, #f8d7da, #f5c6cb);">
                                <div class="stats-icon text-danger">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="stats-number text-danger">
                                    {{ \App\Models\ActivityLog::whereIn('action', ['unauthorized_access', 'system_error'])->count() }}
                                </div>
                                <div class="stats-label">Security Events</div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters Section -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Activities</h6>
                            <button class="filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                                <i class="fas fa-sliders-h me-1"></i> Toggle Filters
                            </button>
                        </div>
                        
                        <div class="collapse show" id="filterCollapse">
                            <form method="GET" action="{{ route('activity-log.index') }}">
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="filter-label">Action Type</label>
                                        <select name="action" class="form-select">
                                            <option value="">All Actions</option>
                                            <optgroup label="Authentication">
                                                <option value="logged_in" {{ request('action') == 'logged_in' ? 'selected' : '' }}>Successful Logins</option>
                                                <option value="logged_out" {{ request('action') == 'logged_out' ? 'selected' : '' }}>Logouts</option>
                                                <option value="login_failed" {{ request('action') == 'login_failed' ? 'selected' : '' }}>Failed Logins</option>
                                                <option value="password_changed" {{ request('action') == 'password_changed' ? 'selected' : '' }}>Password Changes</option>
                                            </optgroup>
                                            <optgroup label="Duty Roster">
                                                <option value="submitted" {{ request('action') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                                                <option value="published" {{ request('action') == 'published' ? 'selected' : '' }}>Published</option>
                                                <option value="replaced" {{ request('action') == 'replaced' ? 'selected' : '' }}>Replaced</option>
                                                <option value="assigned" {{ request('action') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                                <option value="extra_duty" {{ request('action') == 'extra_duty' ? 'selected' : '' }}>Extra Duty</option>
                                                <option value="removed" {{ request('action') == 'removed' ? 'selected' : '' }}>Removed</option>
                                            </optgroup>
                                            <optgroup label="User Management">
                                                <option value="user_created" {{ request('action') == 'user_created' ? 'selected' : '' }}>User Created</option>
                                                <option value="user_updated" {{ request('action') == 'user_updated' ? 'selected' : '' }}>User Updated</option>
                                                <option value="user_deleted" {{ request('action') == 'user_deleted' ? 'selected' : '' }}>User Deleted</option>
                                                <option value="account_created" {{ request('action') == 'account_created' ? 'selected' : '' }}>Account Created</option>
                                                <option value="temp_password_generated" {{ request('action') == 'temp_password_generated' ? 'selected' : '' }}>Temp Password</option>
                                            </optgroup>
                                            <optgroup label="Communication">
                                                <option value="sms_sent" {{ request('action') == 'sms_sent' ? 'selected' : '' }}>SMS Sent</option>
                                                <option value="email_sent" {{ request('action') == 'email_sent' ? 'selected' : '' }}>Email Sent</option>
                                                <option value="bulk_communication" {{ request('action') == 'bulk_communication' ? 'selected' : '' }}>Bulk Communication</option>
                                            </optgroup>
                                            <optgroup label="Security">
                                                <option value="unauthorized_access" {{ request('action') == 'unauthorized_access' ? 'selected' : '' }}>Unauthorized Access</option>
                                                <option value="system_error" {{ request('action') == 'system_error' ? 'selected' : '' }}>System Errors</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label class="filter-label">Date From</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label class="filter-label">Date To</label>
                                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label class="filter-label">Search</label>
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search description or details..." value="{{ request('search') }}">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary w-100 me-2">Apply</button>
                                        <a href="{{ route('activity-log.index') }}" class="btn btn-secondary w-100">Clear</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Activity Log Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Description</th>
                                    <th>IP Address</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities as $activity)
                                <tr>
                                    <td>
                                        <div class="d-flex flex-column">
                                           <span class="fw-bold">{{ optional($activity->date_time)->format('M j, Y') }}</span>
<small class="text-muted">{{ optional($activity->date_time)->format('H:i:s') }}</small>

                                        </div>
                                    </td>
                                    <td>
                                        @if($activity->user_id)
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2">
                                                {{ substr($activity->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $activity->name }}</div>
                                                @if($activity->service_no)
                                                    <small class="text-muted">{{ $activity->service_no }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        @else
                                        <span class="text-muted">System</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = 'bg-secondary';
                                            $iconClass = 'fa-history';
                                            
                                            // Authentication
                                            if ($activity->action == 'logged_in') { $badgeClass = 'bg-success'; $iconClass = 'fa-sign-in-alt'; }
                                            elseif ($activity->action == 'logged_out') { $badgeClass = 'bg-info'; $iconClass = 'fa-sign-out-alt'; }
                                            elseif ($activity->action == 'login_failed') { $badgeClass = 'bg-danger'; $iconClass = 'fa-exclamation-triangle'; }
                                            elseif ($activity->action == 'password_changed') { $badgeClass = 'bg-warning'; $iconClass = 'fa-key'; }
                                            
                                            // Duty Roster
                                            elseif ($activity->action == 'published') { $badgeClass = 'bg-success'; $iconClass = 'fa-check-circle'; }
                                            elseif ($activity->action == 'submitted') { $badgeClass = 'bg-info'; $iconClass = 'fa-paper-plane'; }
                                            elseif ($activity->action == 'replaced') { $badgeClass = 'bg-warning'; $iconClass = 'fa-exchange-alt'; }
                                            elseif ($activity->action == 'assigned') { $badgeClass = 'bg-primary'; $iconClass = 'fa-user-check'; }
                                            elseif ($activity->action == 'extra_duty') { $badgeClass = 'bg-danger'; $iconClass = 'fa-plus-circle'; }
                                            elseif ($activity->action == 'removed') { $badgeClass = 'bg-dark'; $iconClass = 'fa-user-times'; }
                                            
                                            // User Management
                                            elseif ($activity->action == 'user_created') { $badgeClass = 'bg-success'; $iconClass = 'fa-user-plus'; }
                                            elseif ($activity->action == 'user_updated') { $badgeClass = 'bg-info'; $iconClass = 'fa-user-edit'; }
                                            elseif ($activity->action == 'user_deleted') { $badgeClass = 'bg-danger'; $iconClass = 'fa-user-times'; }
                                            elseif ($activity->action == 'account_created') { $badgeClass = 'bg-success'; $iconClass = 'fa-id-card'; }
                                            elseif ($activity->action == 'temp_password_generated') { $badgeClass = 'bg-warning'; $iconClass = 'fa-key'; }
                                            
                                            // Communication
                                            elseif ($activity->action == 'sms_sent') { $badgeClass = 'bg-info'; $iconClass = 'fa-sms'; }
                                            elseif ($activity->action == 'email_sent') { $badgeClass = 'bg-primary'; $iconClass = 'fa-envelope'; }
                                            elseif ($activity->action == 'bulk_communication') { $badgeClass = 'bg-secondary'; $iconClass = 'fa-bullhorn'; }
                                            
                                            // Security
                                            elseif ($activity->action == 'unauthorized_access') { $badgeClass = 'bg-danger'; $iconClass = 'fa-shield-alt'; }
                                            elseif ($activity->action == 'system_error') { $badgeClass = 'bg-dark'; $iconClass = 'fa-bug'; }
                                        @endphp
                                        <span class="badge action-badge {{ $badgeClass }}">
                                            <i class="fas {{ $iconClass }} me-1"></i>
                                            {{ ucfirst(str_replace('_', ' ', $activity->action)) }}
                                        </span>
                                    </td>
                                    <td>{{ $activity->description }}</td>
                                    <td>
                                        <span class="text-muted font-monospace">{{ $activity->ip_address }}</span>
                                    </td>
                                    <td>
                                        @if($activity->details && is_array($activity->details) && count($activity->details) > 0)
                                        <span class="details-toggle" data-bs-toggle="popover" title="Activity Details" 
                                              data-bs-content="<pre>@{{ json_encode($activity->details, JSON_PRETTY_PRINT) }}</pre>">
                                            <i class="fas fa-info-circle"></i> View Details
                                        </span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No activity log entries found</h5>
                                            <p class="text-muted">There are no activities matching your filters.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($activities->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $activities->firstItem() }} to {{ $activities->lastItem() }} of {{ $activities->total() }} entries
                        </div>
                        <div>
                            {{ $activities->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize popovers for details
        $('[data-bs-toggle="popover"]').popover({
            html: true,
            trigger: 'hover',
            placement: 'left',
            template: '<div class="popover" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        });
        
        // Auto-close alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);
        
        // Format JSON in popovers
        $('.details-toggle').on('inserted.bs.popover', function () {
            const popover = $(this).data('bs.popover');
            const content = popover.config.content;
            popover.config.content = content.replace('@{{', '{{').replace('}}', '}}');
        });
    });
</script>

</body>
</html>
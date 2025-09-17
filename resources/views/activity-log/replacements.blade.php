<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Replacement History - GHQ Ops System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #3f80ea;
            --secondary-color: #6c757d;
            --success-color: #1cbb8c;
            --warning-color: #fcb92c;
            --danger-color: #dc3545;
            --dark-color: #343a40;
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
        
        .replacement-badge {
            background: linear-gradient(120deg, #ffd166, #ffb74d);
            color: #7d6608;
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
        
        .replacement-card {
            border-left: 4px solid #ffb74d;
            transition: all 0.3s ease;
        }
        
        .replacement-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }
        
        .user-change {
            display: inline-flex;
            align-items: center;
            background: #f8f9fa;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .arrow-icon {
            margin: 0 10px;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="page-title mb-0"><i class="fas fa-exchange-alt me-2"></i>Replacement History</h5>
                    <div>
                        <a href="{{ route('activity-log.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to Activity Log
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Stats Overview -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="stats-card" style="background: linear-gradient(120deg, #fff2cc, #ffe999);">
                                <div class="stats-icon text-warning">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div class="stats-number text-warning">{{ $replacements->total() }}</div>
                                <div class="stats-label">Total Replacements</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card" style="background: linear-gradient(120deg, #e1f0ff, #cfe5ff);">
                                <div class="stats-icon text-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stats-number text-primary">
                                    {{ \App\Models\ActivityLog::where('action', 'replaced')->distinct('user_id')->count('user_id') }}
                                </div>
                                <div class="stats-label">Unique Officers Involved</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card" style="background: linear-gradient(120deg, #ffcccc, #ff9999);">
                                <div class="stats-icon text-danger">
                                    <i class="fas fa-calendar-times"></i>
                                </div>
                                <div class="stats-number text-danger">
                                    {{ \App\Models\ActivityLog::where('action', 'replaced')->distinct('details->duty_date')->count() }}
                                </div>
                                <div class="stats-label">Affected Duty Dates</div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters Section -->
                    <div class="filter-section">
                        <h6 class="mb-3"><i class="fas fa-filter me-2"></i>Filter Replacements</h6>
                        <form method="GET" action="{{ route('activity-log.replacements') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="filter-label">Date From</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="filter-label">Date To</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="filter-label">Search Officer</label>
                                    <input type="text" name="search" class="form-control" placeholder="Search by officer name..." value="{{ request('search') }}">
                                </div>
                                
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100 me-2">Apply</button>
                                    <a href="{{ route('activity-log.replacements') }}" class="btn btn-secondary w-100">Clear</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Replacements Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date & Time</th>
                                    <th>Performed By</th>
                                    <th>Replacement</th>
                                    <th>Duty Date</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($replacements as $replacement)
                                <tr class="replacement-card">
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold">{{ $replacement->date_time->format('M j, Y') }}</span>
                                            <small class="text-muted">{{ $replacement->date_time->format('H:i:s') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2">
                                                {{ substr($replacement->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $replacement->name }}</div>
                                                @if($replacement->service_no)
                                                    <small class="text-muted">{{ $replacement->service_no }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-change">
                                            <span class="text-danger">
                                                @if(isset($replacement->details['replaced_user_name']))
                                                    {{ $replacement->details['replaced_user_name'] }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                            <span class="arrow-icon"><i class="fas fa-arrow-right"></i></span>
                                            <span class="text-success">
                                                @if(isset($replacement->details['new_user_name']))
                                                    {{ $replacement->details['new_user_name'] }}
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        @if(isset($replacement->details['duty_date']))
                                            <span class="badge replacement-badge">
                                                <i class="fas fa-calendar-day me-1"></i>
                                                {{ \Carbon\Carbon::parse($replacement->details['duty_date'])->format('M j, Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $replacement->description }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No replacement history found</h5>
                                            <p class="text-muted">There are no replacements matching your filters.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($replacements->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $replacements->firstItem() }} to {{ $replacements->lastItem() }} of {{ $replacements->total() }} entries
                        </div>
                        <div>
                            {{ $replacements->links() }}
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

<script>
    $(document).ready(function() {
        // Auto-close alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);
        
        // Highlight recent replacements (last 24 hours)
        $('.replacement-card').each(function() {
            const dateText = $(this).find('.fw-bold').text();
            const replacementDate = new Date(dateText);
            const now = new Date();
            const diffTime = Math.abs(now - replacementDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays <= 1) {
                $(this).css('background-color', '#fffaf0');
            }
        });
    });
</script>

</body>
</html>
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
                                <li class="breadcrumb-item active">D Clerk Dashboard</li>
                            </ul>
                            <div class="d-flex gap-2">
                                <span class="badge bg-info mt-2 mt-md-0 d-flex align-items-center">
                                    <i class="feather icon-calendar me-1"></i> {{ Carbon::now()->format('F Y') }}
                                </span>
                                <span class="badge bg-{{ $rosterStatus && $rosterStatus->status == 'published' ? 'success' : 'warning' }} mt-2 mt-md-0">
                                    {{ $rosterStatus ? strtoupper($rosterStatus->status) : 'DRAFT' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Main Content -->
        <div class="col-md-12">
            <!-- Roster Status Alert -->
            @if($rosterStatus && $rosterStatus->status === 'submitted')
            <div class="alert alert-info alert-dismissible fade show mb-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="feather icon-alert-triangle fa-2x"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="alert-heading mb-1">Roster Ready for Publication</h6>
                        <p class="mb-0">The duty roster has been submitted and is ready to be published to all officers.</p>
                    </div>
                    <div class="flex-shrink-0">
                        <form action="{{ route('dclerk.publish-roster') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="month" value="{{ date('m') }}">
                            <input type="hidden" name="year" value="{{ date('Y') }}">
                            <button type="submit" class="btn btn-success" 
                                    onclick="return confirm('Publish this roster? This will notify all duty officers.')">
                                <i class="feather icon-send me-1"></i> Publish Roster
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-primary">
                        <div class="stats-icon">
                            <i class="feather icon-users"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ $accountStatus->total ?? 0 }}</div>
                            <div class="stats-label">Total Officers</div>
                        </div>
                        <div class="stats-footer">
                            <small>This Month</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-warning">
                        <div class="stats-icon">
                            <i class="feather icon-user-plus"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ $accountStatus->needed ?? 0 }}</div>
                            <div class="stats-label">Need Accounts</div>
                        </div>
                        <div class="stats-footer">
                            <small>Pending Setup</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-success">
                        <div class="stats-icon">
                            <i class="feather icon-check-circle"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ $accountStatus->created ?? 0 }}</div>
                            <div class="stats-label">Accounts Created</div>
                        </div>
                        <div class="stats-footer">
                            <small>Completed</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-info">
                        <div class="stats-icon">
                            <i class="feather icon-calendar"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ $recentActivity->count() }}</div>
                            <div class="stats-label">Recent Activities</div>
                        </div>
                        <div class="stats-footer">
                            <small>Last 7 days</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0">
                            <h5 class="mb-0"><i class="feather icon-zap text-warning me-2"></i>Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xl-3 col-md-6">
                                    <a href="{{ route('dclerk.accounts') }}" class="action-card bg-primary">
                                        <div class="action-icon">
                                            <i class="feather icon-user-plus"></i>
                                        </div>
                                        <div class="action-content">
                                            <h6>Manage Accounts</h6>
                                            <p>Create officer accounts</p>
                                        </div>
                                        <div class="action-badge">
                                            <span class="badge bg-white text-primary">{{ $accountStatus->needed ?? 0 }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <a href="{{ route('dclerk.password-list') }}" class="action-card bg-success">
                                        <div class="action-icon">
                                            <i class="fa-solid fa-key"></i>
                                        </div>
                                        <div class="action-content">
                                            <h6>Password List</h6>
                                            <p>View temporary passwords</p>
                                        </div>
                                        <div class="action-badge">
                                            <span class="badge bg-white text-success">{{ $accountStatus->created ?? 0 }}</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <a href="{{ route('dclerk.communication') }}" class="action-card bg-info">
                                        <div class="action-icon">
                                            <i class="feather icon-mail"></i>
                                        </div>
                                        <div class="action-content">
                                            <h6>Communications</h6>
                                            <p>Send notifications</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <a href="{{ route('dclerk.roster.view') }}" class="action-card bg-warning">
                                        <div class="action-icon">
                                            <i class="feather icon-calendar"></i>
                                        </div>
                                        <div class="action-content">
                                            <h6>View Roster</h6>
                                            <p>Check duty schedule</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="row">
                <!-- Recent Activity -->
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="feather icon-activity me-2"></i>Recent Account Activity</h5>
                            <a href="{{ route('dclerk.accounts') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                        <div class="card-body p-0">
                            @if($recentActivity->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Officer</th>
                                                <th>Service</th>
                                                <th>Status</th>
                                                <th>Date & Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentActivity as $activity)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="officer-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                             style="width: 32px; height: 32px; font-size: 12px; font-weight: 600;">
                                                            {{ substr($activity->user->fname, 0, 1) }}{{ substr($activity->user->fname, strpos($activity->user->fname, ' ') + 1, 1) ?? '' }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-medium">{{ $activity->user->display_rank }} {{ $activity->user->fname }}</div>
                                                            <small class="text-muted">{{ $activity->user->service_no }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $activity->user->arm_of_service == 'ARMY' ? 'primary' : ($activity->user->arm_of_service == 'NAVY' ? 'info' : 'warning') }}">
                                                        {{ $activity->user->arm_of_service }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($activity->account_created)
                                                        <span class="badge bg-success"><i class="feather icon-check-circle me-1"></i> Created</span>
                                                    @else
                                                        <span class="badge bg-warning"><i class="feather icon-clock me-1"></i> Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small>{{ $activity->created_at->format('M d, Y') }}</small>
                                                    <br>
                                                    <small class="text-muted">{{ $activity->created_at->format('H:i') }}</small>
                                                </td>
                                                <td>
                                                    @if($activity->account_created)
                                                        <a href="{{ route('dclerk.password-list') }}" class="btn btn-sm btn-outline-success">
                                                            <i class="feather icon-key"></i> Password
                                                        </a>
                                                    @else
                                                        <a href="{{ route('dclerk.accounts') }}" class="btn btn-sm btn-outline-warning">
                                                            <i class="feather icon-user-plus"></i> Create
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="feather icon-activity fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">No Recent Activity</h6>
                                    <p class="text-muted mb-0">No account activity found for this month.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Roster Status & Quick Stats -->
                <div class="col-xl-4">
                    <!-- Roster Status Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-{{ $rosterStatus && $rosterStatus->status == 'published' ? 'success' : 'warning' }} text-white">
                            <h5 class="mb-0"><i class="feather icon-calendar me-2"></i>Roster Status</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="roster-status-indicator mb-3">
                                <div class="status-icon 
                                    @if($rosterStatus && $rosterStatus->status == 'published') bg-success
                                    @elseif($rosterStatus && $rosterStatus->status == 'submitted') bg-info
                                    @else bg-warning @endif">
                                    <i class="feather 
                                        @if($rosterStatus && $rosterStatus->status == 'published') icon-check-circle
                                        @elseif($rosterStatus && $rosterStatus->status == 'submitted') icon-alert-triangle
                                        @else icon-edit @endif"></i>
                                </div>
                            </div>
                            <h4 class="text-{{ $rosterStatus && $rosterStatus->status == 'published' ? 'success' : 'warning' }}">
                                {{ $rosterStatus ? strtoupper($rosterStatus->status) : 'DRAFT' }}
                            </h4>
                            <p class="text-muted mb-3">Current Roster Status</p>
                            
                            @if($rosterStatus && $rosterStatus->status == 'published')
                                <div class="alert alert-success">
                                    <i class="feather icon-check-circle me-2"></i>
                                    Roster is published and visible to all duty officers.
                                </div>
                            @elseif($rosterStatus && $rosterStatus->status == 'submitted')
                                <div class="alert alert-info">
                                    <i class="feather icon-alert-triangle me-2"></i>
                                    Ready for publication. All accounts have been created.
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="feather icon-edit me-2"></i>
                                    Roster is in draft mode. Not visible to officers.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="feather icon-bar-chart text-info me-2"></i>Quick Stats</h5>
                        </div>
                        <div class="card-body">
                            <div class="stats-list">
                                <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                                    <div class="stat-label">
                                        <i class="feather icon-users text-primary me-2"></i>
                                        <span>Total Officers</span>
                                    </div>
                                    <div class="stat-value fw-bold">{{ $accountStatus->total ?? 0 }}</div>
                                </div>
                                <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                                    <div class="stat-label">
                                        <i class="feather icon-user-plus text-warning me-2"></i>
                                        <span>Pending Accounts</span>
                                    </div>
                                    <div class="stat-value fw-bold">{{ $accountStatus->needed ?? 0 }}</div>
                                </div>
                                <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                                    <div class="stat-label">
                                        <i class="feather icon-check-circle text-success me-2"></i>
                                        <span>Completed Accounts</span>
                                    </div>
                                    <div class="stat-value fw-bold">{{ $accountStatus->created ?? 0 }}</div>
                                </div>
                                <div class="stat-item d-flex justify-content-between align-items-center">
                                    <div class="stat-label">
                                        <i class="feather icon-activity text-info me-2"></i>
                                        <span>Recent Activities</span>
                                    </div>
                                    <div class="stat-value fw-bold">{{ $recentActivity->count() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .stats-card {
        border-radius: 12px;
        padding: 20px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .bg-gradient-primary { background: linear-gradient(135deg, #3f80ea, #5a93f1); }
    .bg-gradient-warning { background: linear-gradient(135deg, #ffb74d, #ffa726); }
    .bg-gradient-success { background: linear-gradient(135deg, #1cbb8c, #18a87c); }
    .bg-gradient-info { background: linear-gradient(135deg, #17a2b8, #138496); }
    
    .stats-icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        opacity: 0.8;
    }
    
    .stats-number {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-bottom: 10px;
    }
    
    .stats-footer {
        border-top: 1px solid rgba(255,255,255,0.2);
        padding-top: 10px;
        margin-top: 10px;
        font-size: 0.8rem;
        opacity: 0.8;
    }
    
    .action-card {
        display: block;
        padding: 20px;
        border-radius: 10px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        color: white;
        text-decoration: none;
    }
    
    .action-icon {
        font-size: 2rem;
        margin-bottom: 10px;
        opacity: 0.9;
    }
    
    .action-content h6 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .action-content p {
        font-size: 0.85rem;
        opacity: 0.9;
        margin-bottom: 0;
    }
    
    .action-badge {
        position: absolute;
        top: 15px;
        right: 15px;
    }
    
    .roster-status-indicator {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .status-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
    }
    
    .officer-avatar {
        font-weight: 600;
    }
    
    .stats-list .stat-item {
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .stats-list .stat-item:last-child {
        border-bottom: none;
    }
    
    .stat-label {
        display: flex;
        align-items: center;
    }
    
    .stat-value {
        font-size: 1.1rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add animation to stats cards
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate__animated', 'animate__fadeInUp');
        });
        
        // Add animation to action cards
        const actionCards = document.querySelectorAll('.action-card');
        actionCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.2}s`;
            card.classList.add('animate__animated', 'animate__fadeInRight');
        });
    });
</script>
@endsection
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
                                <li class="breadcrumb-item active">Account Management</li>
                            </ul>
                            <div class="d-flex gap-2">
                                <a href="{{ route('dclerk.password-list', ['month' => $month, 'year' => $year]) }}" 
                                   class="btn btn-sm btn-outline-light mt-2 mt-md-0">
                                    <i class="feather icon-key"></i> View Passwords
                                </a>
                                <span class="badge bg-info mt-2 mt-md-0 d-flex align-items-center">
                                    <i class="feather icon-calendar me-1"></i> {{ Carbon::create($year, $month, 1)->format('F Y') }}
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
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card bg-gradient-primary">
                        <div class="stats-icon">
                            <i class="feather icon-users"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ $allOfficers->count() }}</div>
                            <div class="stats-label">Total Officers</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card bg-gradient-warning">
                        <div class="stats-icon">
                            <i class="feather icon-user-plus"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ $officersNeedingAccounts->count() }}</div>
                            <div class="stats-label">Need Accounts</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card bg-gradient-success">
                        <div class="stats-icon">
                            <i class="feather icon-check-circle"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ $allOfficers->count() - $officersNeedingAccounts->count() }}</div>
                            <div class="stats-label">Accounts Created</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Month Selection Card -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0"><i class="feather icon-calendar text-primary me-2"></i>Select Month & Year</h6>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('dclerk.accounts') }}">
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <label class="form-label fw-bold">Month</label>
                                        <select class="form-select form-select-lg" id="month" name="month">
                                            @for($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                                    {{ Carbon::create()->month($m)->format('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label fw-bold">Year</label>
                                        <select class="form-select form-select-lg" id="year" name="year">
                                            @for($y = date('Y') - 1; $y <= date('Y') + 1; $y++)
                                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="feather icon-refresh-cw"></i> Load
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Create Accounts Section -->
            @if($officersNeedingAccounts->count() > 0)
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0"><i class="feather icon-alert-triangle me-2"></i>Action Required</h6>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="text-warning mb-2">{{ $officersNeedingAccounts->count() }} Officer(s) Need Accounts</h5>
                                    <p class="text-muted mb-0">
                                        These officers require temporary accounts for {{ Carbon::create($year, $month, 1)->format('F Y') }} duty roster.
                                        Accounts will be created with temporary passwords that expire after first login.
                                    </p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <form method="POST" action="{{ route('dclerk.create-accounts') }}">
                                        @csrf
                                        <input type="hidden" name="month" value="{{ $month }}">
                                        <input type="hidden" name="year" value="{{ $year }}">
                                        <button type="submit" class="btn btn-success btn-lg px-4" 
                                                onclick="return confirm('Create accounts for {{ $officersNeedingAccounts->count() }} officers? Temporary passwords will be generated.')">
                                            <i class="feather icon-user-plus me-2"></i> 
                                            Create Accounts
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="feather icon-check-circle me-2"></i>All Accounts Created</h6>
                        </div>
                        <div class="card-body text-center py-5">
                            <i class="feather icon-check-circle fa-4x text-success mb-3"></i>
                            <h4 class="text-success mb-2">All Accounts Are Ready!</h4>
                            <p class="text-muted mb-4">
                                All officers have accounts for {{ Carbon::create($year, $month, 1)->format('F Y') }} duty roster.
                            </p>
                            <a href="{{ route('dclerk.password-list', ['month' => $month, 'year' => $year]) }}" 
                               class="btn btn-outline-success btn-lg">
                                <i class="feather icon-key me-2"></i> View Password List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Officers Needing Accounts -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="feather icon-list me-2"></i>
                                Officers Needing Accounts
                                <span class="badge bg-warning ms-2">{{ $officersNeedingAccounts->count() }}</span>
                            </h6>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                                    <i class="feather icon-printer"></i> Print
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($officersNeedingAccounts->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Officer Details</th>
                                                <th>Service Information</th>
                                                <th>Unit</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($officersNeedingAccounts as $account)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="officer-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                             style="width: 40px; height: 40px; font-weight: 600;">
                                                            {{ substr($account->user->fname, 0, 1) }}{{ substr($account->user->fname, strpos($account->user->fname, ' ') + 1, 1) ?? '' }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold">{{ $account->user->display_rank }} {{ $account->user->fname }}</div>
                                                            <small class="text-muted">{{ $account->user->service_no }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="badge bg-{{ $account->user->arm_of_service == 'ARMY' ? 'primary' : ($account->user->arm_of_service == 'NAVY' ? 'info' : 'warning') }} mb-1">
                                                            {{ $account->user->arm_of_service }}
                                                        </span>
                                                        <small class="text-muted">{{ $account->user->rank_code }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-medium">{{ $account->user->unit->unit ?? 'N/A' }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-warning">
                                                        <i class="feather icon-clock me-1"></i> Needs Account
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="feather icon-users fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">No Officers Need Accounts</h6>
                                    <p class="text-muted">All accounts have been created for the selected month.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center">
                            <div class="btn-group">
                                <a href="{{ route('dclerk.dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="feather icon-arrow-left me-2"></i> Back to Dashboard
                                </a>
                                <a href="{{ route('dclerk.password-list', ['month' => $month, 'year' => $year]) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="feather icon-key me-2"></i> View Passwords
                                </a>
                                <a href="{{ route('dclerk.communication') }}" class="btn btn-outline-info">
                                    <i class="feather icon-mail me-2"></i> Send Notifications
                                </a>
                                <a href="{{ route('dclerk.roster.view', ['month' => $month, 'year' => $year]) }}" 
                                   class="btn btn-outline-warning">
                                    <i class="feather icon-calendar me-2"></i> View Roster
                                </a>
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
        text-align: center;
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
    
    .stats-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
        opacity: 0.9;
    }
    
    .stats-number {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .stats-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    
    .officer-avatar {
        font-weight: 600;
    }
    
    .table th {
        background-color: #f8f9fa;
        color: #4a5568;
        font-weight: 600;
        border-top: none;
        padding: 12px 15px;
    }
    
    .table td {
        padding: 12px 15px;
        vertical-align: middle;
    }
    
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e9ecef;
        padding: 15px 20px;
    }
    
    @media (max-width: 768px) {
        .btn-group {
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .btn-group .btn {
            margin-bottom: 5px;
        }
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
        
        // Auto-focus on month select
        document.getElementById('month').focus();
    });
</script>
@endsection
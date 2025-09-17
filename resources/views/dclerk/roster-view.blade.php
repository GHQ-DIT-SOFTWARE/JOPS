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
                                <li class="breadcrumb-item active">Duty Roster View</li>
                            </ul>
                            <div class="d-flex gap-2">
                                <a href="{{ route('dclerk.dashboard') }}" class="btn btn-sm btn-outline-light mt-2 mt-md-0">
                                    <i class="feather icon-arrow-left"></i> Dashboard
                                </a>
                                <span class="badge bg-{{ $status === 'published' ? 'success' : ($status === 'submitted' ? 'info' : 'warning') }} mt-2 mt-md-0 d-flex align-items-center">
                                    <i class="feather icon-{{ $status === 'published' ? 'check-circle' : ($status === 'submitted' ? 'alert-triangle' : 'edit') }} me-1"></i>
                                    {{ strtoupper($status) }}
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
            <!-- Publish Alert -->
            @if($status === 'submitted')
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
                            <input type="hidden" name="month" value="{{ $month }}">
                            <input type="hidden" name="year" value="{{ $year }}">
                            <button type="submit" class="btn btn-success" 
                                    onclick="return confirm('Publish this roster? This will notify all duty officers.')">
                                <i class="feather icon-send me-1"></i> Publish Roster
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Status Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-primary">
                        <div class="stats-icon">
                            <i class="feather icon-calendar"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ $startDate->daysInMonth }}</div>
                            <div class="stats-label">Days in Month</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-info">
                        <div class="stats-icon">
                            <i class="feather icon-user-check"></i>
                        </div>
                        <div class="stats-content">
                            @php
                                $totalAssignments = 0;
                                foreach ($dutyRosters as $date => $assignments) {
                                    $totalAssignments += $assignments->count();
                                }
                            @endphp
                            <div class="stats-number">{{ $totalAssignments }}</div>
                            <div class="stats-label">Total Assignments</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-success">
                        <div class="stats-icon">
                            <i class="feather icon-users"></i>
                        </div>
                        <div class="stats-content">
                            @php
                                $uniqueOfficers = collect();
                                foreach ($dutyRosters as $assignments) {
                                    foreach ($assignments as $assignment) {
                                        $uniqueOfficers->put($assignment->user_id, $assignment->user);
                                    }
                                }
                            @endphp
                            <div class="stats-number">{{ $uniqueOfficers->count() }}</div>
                            <div class="stats-label">Unique Officers</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-{{ $status === 'published' ? 'success' : ($status === 'submitted' ? 'info' : 'warning') }}">
                        <div class="stats-icon">
                            <i class="feather icon-{{ $status === 'published' ? 'check-circle' : ($status === 'submitted' ? 'alert-triangle' : 'edit') }}"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ strtoupper($status) }}</div>
                            <div class="stats-label">Roster Status</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Month Navigation -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('dclerk.roster.view', ['month' => $prevMonth, 'year' => $prevYear]) }}" 
                                   class="btn btn-outline-primary btn-lg">
                                    <i class="feather icon-chevron-left"></i> {{ Carbon::create($prevYear, $prevMonth, 1)->format('M Y') }}
                                </a>
                                
                                <div class="text-center">
                                    <h3 class="mb-1 text-primary">{{ $startDate->format('F Y') }}</h3>
                                    <p class="text-muted mb-0">Duty Roster Overview</p>
                                </div>
                                
                                <a href="{{ route('dclerk.roster.view', ['month' => $nextMonth, 'year' => $nextYear]) }}" 
                                   class="btn btn-outline-primary btn-lg">
                                    {{ Carbon::create($nextYear, $nextMonth, 1)->format('M Y') }} <i class="feather icon-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar View -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="feather icon-grid me-2"></i>Monthly Calendar</h5>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-{{ $status === 'published' ? 'success' : ($status === 'submitted' ? 'info' : 'warning') }} me-2">
                                    {{ strtoupper($status) }}
                                </span>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                                        <i class="feather icon-printer"></i> Print
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0 calendar-table">
                                    <thead class="table-light">
                                        <tr>
                                            @foreach(['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'] as $day)
                                            <th class="text-center {{ $day === 'SUN' || $day === 'SAT' ? 'weekend-header' : '' }}">
                                                {{ $day }}
                                            </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $firstDay = $startDate->copy()->startOfMonth();
                                            $lastDay = $startDate->copy()->endOfMonth();
                                            $startDay = $firstDay->copy()->startOfWeek(Carbon::SUNDAY);
                                            $endDay = $lastDay->copy()->endOfWeek(Carbon::SATURDAY);
                                            $currentDay = $startDay->copy();
                                        @endphp
                                        @while($currentDay <= $endDay)
                                            <tr>
                                                @for($i = 0; $i < 7; $i++)
                                                    @php
                                                        $isCurrentMonth = $currentDay->month == $month;
                                                        $isToday = $currentDay->isToday();
                                                        $isWeekend = $currentDay->isWeekend();
                                                        $dateString = $currentDay->format('Y-m-d');
                                                        $duties = $dutyRosters->get($dateString) ?? collect();
                                                    @endphp
                                                    <td class="calendar-day {{ $isCurrentMonth ? '' : 'other-month' }} {{ $isToday ? 'today' : '' }} {{ $isWeekend ? 'weekend' : '' }}" 
                                                        style="height: 140px; vertical-align: top; position: relative;">
                                                        <div class="day-header {{ $isToday ? 'today-header' : '' }}">
                                                            <span class="day-number">{{ $currentDay->day }}</span>
                                                            @if($isToday)
                                                                <span class="badge bg-danger today-badge">TODAY</span>
                                                            @endif
                                                        </div>
                                                        <div class="officer-list mt-2">
                                                            @foreach($duties as $duty)
                                                                <div class="officer-item {{ $duty->is_extra ? 'extra-duty' : 'regular-duty' }} p-2 mb-2 rounded">
                                                                    <div class="d-flex justify-content-between align-items-start">
                                                                        <div class="officer-info">
                                                                            <strong class="officer-name">{{ $duty->user->display_rank }} {{ $duty->user->fname }}</strong>
                                                                            <div class="officer-details">
                                                                                <small>{{ $duty->user->service_no }} | {{ $duty->user->unit->unit ?? 'N/A' }}</small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="officer-status">
                                                                            @if($duty->is_extra)
                                                                                <span class="badge bg-warning badge-sm">EXTRA</span>
                                                                            @endif
                                                                            @php
                                                                                $accountStatus = $duty->user->getAccountStatusForMonth($month, $year);
                                                                            @endphp
                                                                            @if($accountStatus === 'created')
                                                                                <span class="badge bg-success badge-sm">AVAILABLE</span>
                                                                            @elseif($accountStatus === 'needed')
                                                                                <span class="badge bg-warning badge-sm">NEEDS ACCOUNT</span>
                                                                            @else
                                                                                <span class="badge bg-secondary badge-sm">NO ACCOUNT</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    @php
                                                        $currentDay->addDay();
                                                    @endphp
                                                @endfor
                                            </tr>
                                        @endwhile
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Legend & Actions -->
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="feather icon-help-circle me-2"></i>Legend</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="legend-color regular-duty me-3"></div>
                                        <div>
                                            <strong>Regular Duty</strong>
                                            <p class="text-muted mb-0">Standard assignment</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="legend-color extra-duty me-3"></div>
                                        <div>
                                            <strong>Extra Duty</strong>
                                            <p class="text-muted mb-0">Additional assignment</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-success me-3">AVAILABLE</span>
                                        <div>
                                            <strong>Account Ready</strong>
                                            <p class="text-muted mb-0">Account created</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-warning me-3">NEEDS ACCOUNT</span>
                                        <div>
                                            <strong>Needs Account</strong>
                                            <p class="text-muted mb-0">Account required</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-secondary me-3">NO ACCOUNT</span>
                                        <div>
                                            <strong>No Account</strong>
                                            <p class="text-muted mb-0">Not required</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="feather icon-zap me-2"></i>Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('dclerk.accounts') }}" class="btn btn-primary">
                                    <i class="feather icon-user-plus me-2"></i> Manage Accounts
                                </a>
                                <a href="{{ route('dclerk.password-list') }}" class="btn btn-success">
                                    <i class="feather icon-key me-2"></i> View Passwords
                                </a>
                                <a href="{{ route('dclerk.communication') }}" class="btn btn-info">
                                    <i class="feather icon-mail me-2"></i> Send Notifications
                                </a>
                                @if($status === 'submitted')
                                <form action="{{ route('dclerk.publish-roster') }}" method="POST" class="d-grid">
                                    @csrf
                                    <input type="hidden" name="month" value="{{ $month }}">
                                    <input type="hidden" name="year" value="{{ $year }}">
                                    <button type="submit" class="btn btn-warning" 
                                            onclick="return confirm('Publish this roster? This will notify all duty officers.')">
                                        <i class="feather icon-send me-2"></i> Publish Roster
                                    </button>
                                </form>
                                @endif
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
    .bg-gradient-info { background: linear-gradient(135deg, #17a2b8, #138496); }
    .bg-gradient-success { background: linear-gradient(135deg, #1cbb8c, #18a87c); }
    .bg-gradient-warning { background: linear-gradient(135deg, #ffb74d, #ffa726); }
    
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
    
    .calendar-table {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .calendar-day {
        border: 1px solid #e9ecef;
        position: relative;
        transition: background-color 0.2s ease;
    }
    
    .calendar-day:hover {
        background-color: #f8f9fa;
    }
    
    .other-month {
        background-color: #f8f9fa;
        color: #6c757d;
    }
    
    .weekend {
        background-color: #f8fafc;
    }
    
    .weekend-header {
        background-color: #e9ecef;
        color: #6c757d;
    }
    
    .today {
        background-color: #e7f5ff;
    }
    
    .today-header {
        background-color: #007bff;
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        margin-right: 4px;
    }
    
    .today-badge {
        font-size: 0.6rem;
        padding: 2px 4px;
    }
    
    .day-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 4px;
        margin-bottom: 4px;
    }
    
    .day-number {
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .officer-list {
        max-height: 110px;
        overflow-y: auto;
    }
    
    .officer-item {
        font-size: 0.75rem;
        border: 1px solid #dee2e6;
    }
    
    .regular-duty {
        background-color: #e8f5e8;
        border-color: #d4edda !important;
    }
    
    .extra-duty {
        background-color: #fff3cd;
        border-color: #ffeaa7 !important;
    }
    
    .officer-name {
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .officer-details {
        font-size: 0.7rem;
        color: #6c757d;
    }
    
    .badge-sm {
        font-size: 0.6rem;
        padding: 2px 4px;
    }
    
    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }
    
    .regular-duty-legend {
        background-color: #e8f5e8;
        border-color: #d4edda;
    }
    
    .extra-duty-legend {
        background-color: #fff3cd;
        border-color: #ffeaa7;
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
        
        // Highlight today's date
        const todayCells = document.querySelectorAll('.today');
        todayCells.forEach(cell => {
            cell.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    });
</script>
@endsection
<!-- resources/views/duty-roster/index.blade.php -->
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
                                <li class="breadcrumb-item"><a href="#!">Duty Roster</a></li>
                                <li class="breadcrumb-item active">{{ $startDate->format('F Y') }}</li>
                            </ul>
                            <div class="d-flex gap-2">
                                <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-light mt-2 mt-md-0">
                                    <i class="feather icon-arrow-left"></i> Back
                                </a>
                                @if(Auth::user()->canManageDutyRoster())
                                <div class="btn-group mt-2 mt-md-0">
                                    @if($status === 'draft')
                                    <form action="{{ route('duty-roster.submit') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="month" value="{{ $month }}">
                                        <input type="hidden" name="year" value="{{ $year }}">
                                        <button type="submit" class="btn btn-success btn-sm" 
                                                onclick="return confirm('Submit this roster for review?')">
                                            <i class="feather icon-check-circle"></i> Submit Roster
                                        </button>
                                    </form>
                                    @elseif($status === 'submitted' && Auth::user()->canPublishDutyRoster())
                                    <form action="{{ route('duty-roster.publish') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="month" value="{{ $month }}">
                                        <input type="hidden" name="year" value="{{ $year }}">
                                        <button type="submit" class="btn btn-primary btn-sm" 
                                                onclick="return confirm('Publish this roster? This will notify all duty officers.')">
                                            <i class="feather icon-send"></i> Publish Roster
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Main Content -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="feather icon-calendar me-2"></i>Officer Duty Roster - {{ $startDate->format('F Y') }}</h5>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-{{ $status === 'published' ? 'success' : ($status === 'submitted' ? 'info' : 'warning') }} me-2">
                            {{ ucfirst($status) }}
                        </span>
                        <div class="btn-group">
                            <a href="{{ route('duty-roster.index', ['month' => $startDate->copy()->subMonth()->format('m'), 'year' => $startDate->copy()->subMonth()->format('Y')]) }}" 
                               class="btn btn-sm btn-outline-secondary">
                                <i class="feather icon-chevron-left"></i>
                            </a>
                            <a href="{{ route('duty-roster.index', ['month' => date('m'), 'year' => date('Y')]) }}" 
                               class="btn btn-sm btn-outline-secondary">
                                Current Month
                            </a>
                            <a href="{{ route('duty-roster.index', ['month' => $startDate->copy()->addMonth()->format('m'), 'year' => $startDate->copy()->addMonth()->format('Y')]) }}" 
                               class="btn btn-sm btn-outline-secondary">
                                <i class="feather icon-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Status and Role Information -->
                    <div class="alert alert-{{ $status === 'published' ? 'success' : ($status === 'submitted' ? 'info' : 'warning') }} mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>
                                    @if(Auth::user()->is_role === App\Models\User::ROLE_SUPERADMIN)
                                        Your Role: Scheduler
                                    @elseif(Auth::user()->is_role === App\Models\User::ROLE_DCLERK)
                                        Your Role: D Clerk
                                    @elseif(Auth::user()->is_role === App\Models\User::ROLE_DOFFR)
                                        Your Role: Duty Officer
                                    @endif
                                </strong>
                                <span class="mx-2">•</span>
                                Roster Status: <span class="badge bg-{{ $status === 'published' ? 'success' : ($status === 'submitted' ? 'info' : 'warning') }}">{{ ucfirst($status) }}</span>
                                
                                @if($status === 'submitted')
                                <span class="mx-2">•</span>
                                <small>Awaiting publication by D Clerk</small>
                                @elseif($status === 'published')
                                <span class="mx-2">•</span>
                                <small>Published and visible to duty officers</small>
                                @endif
                            </div>
                            @if(Auth::user()->canManageDutyRoster())
                            <a href="{{ route('duty-roster.manage-officers', ['month' => $month, 'year' => $year]) }}" 
                               class="btn btn-sm btn-outline-{{ $status === 'published' ? 'success' : ($status === 'submitted' ? 'info' : 'warning') }}">
                               <i class="feather icon-users"></i> Manage Available Officers
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Scheduler Tools Section -->
                    @if(Auth::user()->canManageDutyRoster())
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="feather icon-tool me-2"></i>Scheduler Tools</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="d-flex gap-2 mb-3">
                                                <button type="button" class="btn btn-warning flex-fill" data-toggle="modal" data-target="#extraDutyModal">
                                                    <i class="feather icon-alert-triangle me-1"></i> Assign Extra Duty
                                                </button>
                                                <button type="button" class="btn btn-info flex-fill" data-toggle="modal" data-target="#quickAssignModal">
                                                    <i class="feather icon-zap me-1"></i> Quick Assign
                                                </button>
                                            </div>
                                            
                                            <form method="POST" action="{{ route('duty-roster.store') }}" class="mb-3" id="assignmentForm">
                                                @csrf
                                                <div class="card border">
                                                    <div class="card-header bg-light py-2">
                                                        <h6 class="mb-0">Manual Assignment</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-2">
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Select Officer</label>
                                                                <select class="form-select form-select-sm" id="user_id" name="user_id" required>
                                                                    <option value="">Choose officer...</option>
                                                                    @foreach($users as $user)
                                                                        <option value="{{ $user->id }}">
                                                                            {{ $user->display_rank }} {{ $user->fname }} 
                                                                            ({{ $user->service_no }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label small fw-bold">Duty Type</label>
                                                                <div class="d-flex align-items-center h-100">
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input" type="checkbox" id="is_extra" name="is_extra">
                                                                        <label class="form-check-label small" for="is_extra">
                                                                            Extra Duty
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Hidden field for selected dates -->
                                                        <input type="hidden" name="duty_dates" id="selectedDates">
                                                        
                                                        <button type="submit" class="btn btn-primary btn-sm mt-2 w-100" onclick="prepareAssignment()">
                                                            <i class="feather icon-save me-1"></i> Save Assignment
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="card border h-100">
                                                <div class="card-header bg-light py-2">
                                                    <h6 class="mb-0">Select Duty Days</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="duty-days-grid">
                                                        @for($day = 1; $day <= $startDate->daysInMonth; $day++)
                                                            @php
                                                                $currentDate = Carbon::create($year, $month, $day)->format('Y-m-d');
                                                                $isAssigned = isset($dutyRosters[$currentDate]);
                                                                $isWeekend = Carbon::create($year, $month, $day)->isWeekend();
                                                            @endphp
                                                            <div class="day-checkbox-container">
                                                                <input class="form-check-input day-checkbox" type="checkbox" 
                                                                       name="duty_dates[]" value="{{ $currentDate }}" 
                                                                       id="day{{ $day }}" {{ $isAssigned ? 'disabled' : '' }}>
                                                                <label class="form-check-label day-label {{ $isAssigned ? 'assigned' : '' }} {{ $isWeekend ? 'weekend' : '' }}" 
                                                                       for="day{{ $day }}" data-bs-toggle="tooltip" 
                                                                       title="{{ $isAssigned ? 'Already assigned' : 'Available' }}">
                                                                    {{ $day }}
                                                                    @if($isAssigned)
                                                                        <span class="assigned-dot"></span>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Notifications Section for Duty Officers -->
                    @if(Auth::user()->is_role === App\Models\User::ROLE_DOFFR && $status === 'published')
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <span><i class="feather icon-bell me-1"></i>Your Duty Assignments</span>
                                    <button class="btn btn-sm btn-light" onclick="loadNotifications()">
                                        <i class="feather icon-refresh-cw"></i> Refresh
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div id="notifications-container">
                                        <div class="text-center text-muted py-3">
                                            <i class="feather icon-loader fa-spin"></i> Loading your assignments...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Calendar View -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><i class="feather icon-grid me-2"></i>Monthly Calendar View</h6>
                                    <div class="text-muted small">
                                        {{ $startDate->format('F Y') }} • {{ $startDate->daysInMonth }} days
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                                    <th class="text-center {{ $day === 'Sun' || $day === 'Sat' ? 'weekend-header' : '' }}">
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
                                                                style="height: 120px; vertical-align: top; position: relative;">
                                                                <div class="day-header {{ $isToday ? 'today-header' : '' }}">
                                                                    <span class="day-number">{{ $currentDay->day }}</span>
                                                                    @if($isToday)
                                                                        <span class="badge bg-danger today-badge">Today</span>
                                                                    @endif
                                                                </div>
                                                                <div class="officer-list mt-2">
                                                                    @foreach($duties as $duty)
                                                                        <div class="officer-item {{ $duty->is_extra ? 'extra-duty' : 'regular-duty' }} p-1 mb-1 rounded">
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <div class="officer-info">
                                                                                    <strong class="officer-name">{{ $duty->user->display_rank }} {{ $duty->user->fname }}</strong>
                                                                                    <div class="officer-details">
                                                                                        <small>{{ $duty->user->service_no }} | {{ $duty->user->unit->unit ?? 'N/A' }}</small>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="officer-actions">
                                                                                    @if($duty->is_extra)
                                                                                        <span class="badge bg-warning badge-sm">Extra</span>
                                                                                    @endif
                                                                                    @if(Auth::user()->canManageDutyRoster())
                                                                                    <form action="{{ route('duty-roster.destroy', $duty->id) }}" method="POST" class="d-inline">
                                                                                        @csrf
                                                                                        @method('DELETE')
                                                                                        <button type="submit" class="btn btn-sm btn-danger p-0 px-1" 
                                                                                                onclick="return confirm('Remove this assignment?')" title="Remove assignment">
                                                                                            &times;
                                                                                        </button>
                                                                                    </form>
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

                </div>
            </div>
        </div>

    </div>
</section>

<!-- Extra Duty Assignment Modal -->
@if(Auth::user()->canManageDutyRoster())
<div class="modal fade" id="extraDutyModal" tabindex="-1" role="dialog" aria-labelledby="extraDutyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="extraDutyModalLabel"><i class="feather icon-alert-triangle me-2"></i>Assign Extra Duty</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('duty-roster.extra-duty') }}">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="feather icon-info"></i> Extra duty assignments will automatically replace any existing assignments on selected dates.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="extra_user_id" class="form-label fw-bold">Officer Receiving Extra Duty</label>
                                <select class="form-select" id="extra_user_id" name="user_id" required>
                                    <option value="">Choose officer...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->display_rank }} {{ $user->fname }} 
                                            ({{ $user->service_no }}) - {{ $user->unit->unit ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="reason" class="form-label fw-bold">Reason for Extra Duty</label>
                                <textarea class="form-control" id="reason" name="reason" rows="2" maxlength="500" 
                                          placeholder="Enter reason for extra duty assignment..."></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Days for Extra Duty</label>
                        <div class="extra-duty-days-grid">
                            @for($day = 1; $day <= $startDate->daysInMonth; $day++)
                                @php
                                    $currentDate = Carbon::create($year, $month, $day)->format('Y-m-d');
                                    $isAssigned = isset($dutyRosters[$currentDate]);
                                    $currentOfficer = $isAssigned ? $dutyRosters[$currentDate]->first()->user->fname ?? 'Unknown' : '';
                                    $isWeekend = Carbon::create($year, $month, $day)->isWeekend();
                                @endphp
                                <div class="extra-day-checkbox-container">
                                    <input class="form-check-input extra-day-checkbox" type="checkbox" 
                                           name="duty_dates[]" value="{{ $currentDate }}" 
                                           id="extra_day{{ $day }}">
                                    <label class="form-check-label extra-day-label {{ $isWeekend ? 'weekend' : '' }}" 
                                           for="extra_day{{ $day }}" data-bs-toggle="tooltip" 
                                           title="{{ $isAssigned ? 'Currently: ' . $currentOfficer : 'Available' }}">
                                        {{ $day }}
                                        @if($isAssigned)
                                            <span class="current-assignment-dot" title="Currently assigned to {{ $currentOfficer }}"></span>
                                        @endif
                                    </label>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Assign Extra Duty</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<style>
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
        max-height: 90px;
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
    
    /* Duty days grid */
    .duty-days-grid, .extra-duty-days-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        max-height: 200px;
        overflow-y: auto;
    }
    .day-checkbox-container, .extra-day-checkbox-container {
        position: relative;
        text-align: center;
    }
    .day-checkbox, .extra-day-checkbox {
        display: none;
    }
    .day-label, .extra-day-label {
        display: block;
        padding: 6px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .day-label:hover, .extra-day-label:hover {
        background-color: #e9ecef;
    }
    .day-checkbox:checked + .day-label,
    .extra-day-checkbox:checked + .extra-day-label {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }
    .day-label.assigned {
        background-color: #f8d7da;
        color: #721c24;
        cursor: not-allowed;
        opacity: 0.6;
    }
    .day-label.weekend, .extra-day-label.weekend {
        background-color: #f8f9fa;
        color: #6c757d;
    }
    .assigned-dot, .current-assignment-dot {
        display: inline-block;
        width: 6px;
        height: 6px;
        background-color: #dc3545;
        border-radius: 50%;
        margin-left: 2px;
    }
    .current-assignment-dot {
        background-color: #28a745;
    }
    
    /* Enhanced checkbox styles */
    .day-checkbox:checked + .day-label {
        background-color: #007bff !important;
        color: white !important;
        border-color: #007bff !important;
    }
    .extra-day-checkbox:checked + .extra-day-label {
        background-color: #ffc107 !important;
        color: #000 !important;
        border-color: #ffc107 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        // Toggle day selection with visual feedback
        const checkboxes = document.querySelectorAll('.day-checkbox:not([disabled])');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const label = this.nextElementSibling;
                if (this.checked) {
                    label.classList.add('bg-primary', 'text-white');
                } else {
                    label.classList.remove('bg-primary', 'text-white');
                }
            });
        });
        
        // Toggle extra day selection with visual feedback
        const extraCheckboxes = document.querySelectorAll('.extra-day-checkbox');
        extraCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const label = this.nextElementSibling;
                if (this.checked) {
                    label.classList.add('bg-warning', 'text-dark');
                } else {
                    label.classList.remove('bg-warning', 'text-dark');
                }
            });
        });
        
        // Show confirmation for extra duty assignment
        const extraDutyForm = document.querySelector('#extraDutyModal form');
        if (extraDutyForm) {
            extraDutyForm.addEventListener('submit', function(e) {
                const selectedDates = Array.from(this.querySelectorAll('input[name="duty_dates[]"]:checked')).map(cb => cb.value);
                const officerSelect = this.querySelector('select[name="user_id"]');
                
                if (selectedDates.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one day for extra duty.');
                    return;
                }
                
                if (!officerSelect.value) {
                    e.preventDefault();
                    alert('Please select an officer to receive extra duty.');
                    return;
                }
                
                const confirmed = confirm(`Assign ${selectedDates.length} days of extra duty to ${officerSelect.options[officerSelect.selectedIndex].text}?\n\nAny officers currently assigned to these dates will be unassigned automatically.`);
                
                if (!confirmed) {
                    e.preventDefault();
                }
            });
        }
        
        // Highlight today's date in the calendar
        const todayCells = document.querySelectorAll('.today');
        todayCells.forEach(cell => {
            cell.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    });
    
    // Prepare assignment by collecting selected dates
    function prepareAssignment() {
        const selectedDates = Array.from(document.querySelectorAll('.day-checkbox:checked:not([disabled])'))
            .map(checkbox => checkbox.value);
        
        if (selectedDates.length === 0) {
            alert('Please select at least one day for duty assignment.');
            event.preventDefault();
            return false;
        }
        
        const officerSelect = document.getElementById('user_id');
        if (!officerSelect.value) {
            alert('Please select an officer for duty assignment.');
            event.preventDefault();
            return false;
        }
        
        document.getElementById('selectedDates').value = JSON.stringify(selectedDates);
        return true;
    }
    
    // Notifications functions for duty officers
    @if(Auth::user()->is_role === App\Models\User::ROLE_DOFFR && $status === 'published')
    function loadNotifications() {
        $('#notifications-container').html(`
            <div class="text-center text-muted py-3">
                <i class="feather icon-loader fa-spin"></i> Loading your assignments...
            </div>
        `);
        
        $.ajax({
            url: '{{ route("duty-roster.notifications") }}',
            method: 'GET',
            data: {
                month: '{{ $month }}',
                year: '{{ $year }}'
            },
            success: function(response) {
                if (response.length > 0) {
                    let html = '<div class="assignment-list">';
                    response.forEach(function(notification) {
                        html += `
                            <div class="alert ${notification.is_read ? 'alert-light' : 'alert-info'} alert-dismissible fade show mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="feather icon-calendar me-2"></i>
                                    <div>${notification.message}</div>
                                </div>
                                <button type="button" class="btn-close" onclick="markNotificationRead(${notification.id})"></button>
                            </div>
                        `;
                    });
                    html += '</div>';
                    $('#notifications-container').html(html);
                } else {
                    $('#notifications-container').html(`
                        <div class="text-center text-muted py-4">
                            <i class="feather icon-check-circle fa-2x mb-2"></i>
                            <p>No duty assignments notifications</p>
                        </div>
                    `);
                }
            },
            error: function() {
                $('#notifications-container').html(`
                    <div class="alert alert-danger">
                        <i class="feather icon-alert-triangle me-2"></i>
                        Failed to load notifications. Please try again.
                    </div>
                `);
            }
        });
    }

    function markNotificationRead(id) {
        $.ajax({
            url: '{{ url("duty-roster/notification") }}/' + id + '/read',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                loadNotifications();
            }
        });
    }

    // Load notifications on page load
    $(document).ready(function() {
        loadNotifications();
        
        // Auto-refresh notifications every 30 seconds
        setInterval(loadNotifications, 30000);
    });
    @endif
</script>

@endsection
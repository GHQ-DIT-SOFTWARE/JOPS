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
                            <h5 class="m-b-10">Duty Roster Management</h5>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white">
                            <ul class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Duty Roster</a></li>
                            </ul>
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-light mt-2 mt-md-0">← Back to Page</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <!-- Main Content -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">Officer Duty Roster - {{ $startDate->format('F Y') }}</h5>
                </div>
                <div class="card-body">
                    
                    <!-- Role-based information -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                @if(Auth::user()->is_role === App\Models\User::ROLE_SUPERADMIN)
                                    <strong>Your Role: Scheduler</strong> - Create roster and publish when ready.
                                @elseif(Auth::user()->is_role === App\Models\User::ROLE_DCLERK)
                                    <strong>Your Role: D Clerk</strong> - Create accounts for duty officers.
                                @elseif(Auth::user()->is_role === App\Models\User::ROLE_DOFFR)
                                    <strong>Your Role: Duty Officer</strong> - View your assigned duties (once roster is published).
                                @endif
                                | Status: <span class="badge bg-info">{{ ucfirst($status) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @if(Auth::user()->canManageDutyRoster() && $status === 'draft')
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-warning">
                                <strong>Note:</strong> Before assigning duties, make sure you have the list of available officers for this month.
                                <a href="{{ route('duty-roster.manage-officers', ['month' => $month, 'year' => $year]) }}" 
                                   class="btn btn-sm btn-outline-warning ms-2">
                                   <i class="feather icon-users"></i> Manage Available Officers
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Scheduler Section (Super Admin) -->
                    @if(Auth::user()->canManageDutyRoster())
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Assign Duties</div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('duty-roster.store') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="user_id" class="form-label">Select Duty Officer</label>
                                                    <select class="form-select" id="user_id" name="user_id" required>
                                                        <option value="">Choose officer...</option>
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id }}">
                                                                {{ $user->display_rank }} {{ $user->fname }} 
                                                                ({{ $user->service_no }}) - {{ $user->unit->unit ?? 'N/A' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="is_extra" name="is_extra">
                                                    <label class="form-check-label" for="is_extra">
                                                        Mark as extra duty
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save Assignments</button>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label">Select Days</label>
                                                <div class="d-flex flex-wrap">
                                                    @for($day = 1; $day <= $startDate->daysInMonth; $day++)
                                                        @php
                                                            $currentDate = Carbon::create($year, $month, $day)->format('Y-m-d');
                                                            $isAssigned = isset($dutyRosters[$currentDate]);
                                                        @endphp
                                                        <div class="form-check me-2 mb-2">
                                                            <input class="form-check-input day-checkbox" type="checkbox" 
                                                                   name="duty_dates[]" value="{{ $currentDate }}" 
                                                                   id="day{{ $day }}" {{ $isAssigned ? 'disabled' : '' }}>
                                                            <label class="form-check-label {{ $isAssigned ? 'text-muted' : '' }}" for="day{{ $day }}">
                                                                {{ $day }}
                                                                @if($isAssigned)
                                                                    <br><small class="text-danger">(Assigned)</small>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Calendar View -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Calendar View</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sun</th>
                                                    <th>Mon</th>
                                                    <th>Tue</th>
                                                    <th>Wed</th>
                                                    <th>Thu</th>
                                                    <th>Fri</th>
                                                    <th>Sat</th>
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
                                                                $dateString = $currentDay->format('Y-m-d');
                                                                $duties = $dutyRosters->get($dateString) ?? collect();
                                                            @endphp
                                                            <td class="calendar-day {{ $isCurrentMonth ? '' : 'bg-light' }}" style="height: 120px; vertical-align: top;">
                                                                <div class="day-number">{{ $currentDay->day }}</div>
                                                                <div class="officer-list">
                                                                    @foreach($duties as $duty)
                                                                        <div class="officer-item {{ $duty->is_extra ? 'extra-duty' : '' }} p-1 mb-1 rounded">
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <div>
                                                                                    <strong>{{ $duty->user->display_rank }} {{ $duty->user->fname }}</strong>
                                                                                    <br>
                                                                                    <small>{{ $duty->user->service_no }} | {{ $duty->user->unit->unit ?? 'N/A' }}</small>
                                                                                    @if($duty->is_extra)
                                                                                        <span class="badge bg-warning ms-1">Extra</span>
                                                                                    @endif
                                                                                </div>
                                                                                @if(Auth::user()->canManageDutyRoster() && $status === 'draft')
                                                                                <form action="{{ route('duty-roster.destroy', $duty->id) }}" method="POST" class="d-inline">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="btn btn-sm btn-danger p-0 px-1" onclick="return confirm('Remove this assignment?')">&times;</button>
                                                                                </form>
                                                                                @endif
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

<style>
    .calendar-day {
        border: 1px solid #dee2e6;
        position: relative;
    }
    .day-number {
        position: absolute;
        top: 5px;
        right: 5px;
        font-weight: bold;
    }
    .officer-list {
        margin-top: 25px;
    }
    .officer-item {
        font-size: 0.8rem;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }
    .extra-duty {
        background-color: #fff3cd !important;
        border-color: #ffecb5 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle day selection with visual feedback
        const checkboxes = document.querySelectorAll('.day-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                this.parentElement.classList.toggle('bg-primary', this.checked);
                this.parentElement.classList.toggle('text-white', this.checked);
            });
        });
    });
</script>

@endsection
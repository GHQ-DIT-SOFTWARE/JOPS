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
                            <h5 class="m-b-10">Duty Roster View</h5>
                        </div>
                        <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white">
                            <ul class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('dclerk.dashboard') }}">D Clerk Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#!">Duty Roster View</a></li>
                            </ul>
                            <a href="{{ route('dclerk.dashboard') }}" class="btn btn-sm btn-outline-light mt-2 mt-md-0">← Back to Dashboard</a>
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
                                <strong>Your Role: D Clerk</strong> - View duty roster for account management purposes.
                                | Status: <span class="badge bg-info">{{ ucfirst($status) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Month Navigation -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('dclerk.roster.view', ['month' => $prevMonth, 'year' => $prevYear]) }}" 
                                   class="btn btn-outline-primary">
                                    <i class="feather icon-chevron-left"></i> Previous Month
                                </a>
                                
                                <h4 class="mb-0 text-center">{{ $startDate->format('F Y') }}</h4>
                                
                                <a href="{{ route('dclerk.roster.view', ['month' => $nextMonth, 'year' => $nextYear]) }}" 
                                   class="btn btn-outline-primary">
                                    Next Month <i class="feather icon-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar View -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span>Calendar View</span>
                                    <span class="badge bg-{{ $status === 'published' ? 'success' : 'warning' }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </div>
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
                                                                $isToday = $currentDay->isToday();
                                                            @endphp
                                                            <td class="calendar-day {{ $isCurrentMonth ? '' : 'bg-light' }} {{ $isToday ? 'today' : '' }}" 
                                                                style="height: 120px; vertical-align: top;">
                                                                <div class="day-number {{ $isToday ? 'text-danger fw-bold' : '' }}">{{ $currentDay->day }}</div>
                                                                <div class="officer-list">
                                                                    @foreach($duties as $duty)
                                                                        <div class="officer-item {{ $duty->is_extra ? 'extra-duty' : 'regular-duty' }} p-1 mb-1 rounded">
                                                                            <div>
                                                                                <strong>{{ $duty->user->display_rank }} {{ $duty->user->fname }}</strong>
                                                                                <br>
                                                                                <small>{{ $duty->user->service_no }} | {{ $duty->user->unit->unit ?? 'N/A' }}</small>
                                                                                @if($duty->is_extra)
                                                                                    <span class="badge bg-warning ms-1">Extra</span>
                                                                                @endif
                                                                                
                                                                                <!-- Account Status Badge -->
                                                                                @php
                                                                                    $accountStatus = $duty->user->getAccountStatusForMonth($month, $year);
                                                                                @endphp
                                                                                @if($accountStatus === 'created')
                                                                                    <span class="badge bg-success ms-1">Account Ready</span>
                                                                                @elseif($accountStatus === 'needed')
                                                                                    <span class="badge bg-warning ms-1">Needs Account</span>
                                                                                @else
                                                                                    <span class="badge bg-secondary ms-1">No Account</span>
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

                    <!-- Legend -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Legend</div>
                                <div class="card-body">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="d-flex align-items-center">
                                            <div class="legend-color regular-duty me-2" style="width: 20px; height: 20px; background-color: #e9ecef; border: 1px solid #dee2e6;"></div>
                                            <span>Regular Duty</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="legend-color extra-duty me-2" style="width: 20px; height: 20px; background-color: #fff3cd; border: 1px solid #ffecb5;"></div>
                                            <span>Extra Duty</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2">Account Ready</span>
                                            <span>Account Created</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-warning me-2">Needs Account</span>
                                            <span>Account Needed</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-secondary me-2">No Account</span>
                                            <span>No Account Required</span>
                                        </div>
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
        border: 1px solid #dee2e6;
    }
    .regular-duty {
        background-color: #e9ecef;
    }
    .extra-duty {
        background-color: #fff3cd;
        border-color: #ffecb5 !important;
    }
    .today {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    .legend-color {
        border-radius: 3px;
    }
</style>
@endsection
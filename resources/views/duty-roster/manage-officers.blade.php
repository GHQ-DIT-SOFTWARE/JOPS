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
                                <li class="breadcrumb-item"><a href="{{ route('duty-roster.index') }}">Duty Roster</a></li>
                                <li class="breadcrumb-item"><a href="#!">Manage Officers</a></li>
                            </ul>
                            <a href="{{ route('duty-roster.index') }}" class="btn btn-sm btn-outline-light mt-2 mt-md-0">← Back to Roster</a>
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
                    <h5>Select Available Duty Officers for {{ Carbon::parse($dutyMonth)->format('F Y') }}</h5>
                </div>
                <div class="card-body">
                    
                    <!-- Add New Officer Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="feather icon-user-plus"></i> Add New Officer</h6>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('duty-roster.add-officer') }}">
                                        @csrf
                                        <input type="hidden" name="duty_month" value="{{ $dutyMonth }}">
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="service_no">Service Number *</label>
                                                    <input type="text" class="form-control" id="service_no" name="service_no" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="fname">Full Name *</label>
                                                    <input type="text" class="form-control" id="fname" name="fname" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="unit_id">Unit *</label>
                                                    <select class="form-control" id="unit_id" name="unit_id" required>
                                                        <option value="">Select Unit</option>
                                                        @foreach($units as $unit)
                                                            <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="arm_of_service">Arm of Service *</label>
                                                    <select class="form-control" id="arm_of_service" name="arm_of_service" required onchange="updateRankOptions()">
                                                        <option value="">Select Arm of Service</option>
                                                        <option value="ARMY">ARMY</option>
                                                        <option value="NAVY">NAVY</option>
                                                        <option value="AIRFORCE">AIRFORCE</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="rank">Rank *</label>
                                                    <select class="form-control" id="rank" name="rank_code" required>
                                                        <option value="">Select Arm of Service First</option>
                                                        <!-- Rank options will be populated by JavaScript -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="gender">Gender *</label>
                                                    <select class="form-control" id="gender" name="gender" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" class="form-control" id="phone" name="phone">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding-top: 2rem;">
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="feather icon-save"></i> Add Officer
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Select Available Officers -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6>Select Available Officers for This Month</h6>
                                    <p class="text-muted mb-0">Check the officers who are available for duty this month</p>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('duty-roster.update-available-officers') }}">
                                        @csrf
                                        <input type="hidden" name="duty_month" value="{{ $dutyMonth }}">
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" id="selectAll">
                                                            <i class="feather icon-check-square"></i> Select All
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAll">
                                                            <i class="feather icon-square"></i> Deselect All
                                                        </button>
                                                    </div>
                                                    <div>
                                                        <span class="badge bg-info" id="selectedCount">0 officers selected</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        @if($allOfficers->count() > 0)
                                                            @foreach($allOfficers as $officer)
                                                            <div class="col-md-4 mb-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input officer-checkbox" type="checkbox" 
                                                                           name="officers[]" value="{{ $officer->id }}" 
                                                                           id="officer{{ $officer->id }}"
                                                                           {{ isset($availableOfficers[$officer->id]) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="officer{{ $officer->id }}">
                                                                        <strong>{{ $officer->display_rank }} {{ $officer->fname }}</strong>
                                                                        <br>
                                                                        <small class="text-muted">
                                                                            {{ $officer->service_no }} | 
                                                                            {{ $officer->unit->unit ?? 'N/A' }} | 
                                                                            {{ $officer->arm_of_service }}
                                                                        </small>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        @else
                                                            <div class="col-md-12">
                                                                <div class="alert alert-info">
                                                                    <i class="feather icon-info"></i> No officers found in the system. 
                                                                    Please add officers using the form above.
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @if($allOfficers->count() > 0)
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="feather icon-check"></i> Save Available Officers
                                                </button>
                                                <a href="{{ route('duty-roster.index') }}" class="btn btn-secondary">Cancel</a>
                                            </div>
                                        </div>
                                        @endif
                                    </form>
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
    .form-check-label {
        font-size: 0.9rem;
    }
    .form-check {
        padding: 0.5rem;
        border-radius: 4px;
    }
    .form-check:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
    // Rank data structure - convert PHP ranks to JavaScript object
    const rankData = {
        @foreach($ranks as $rank)
        '{{ $rank->rank_code }}': {
            army: '{{ addslashes($rank->army_display) }}',
            navy: '{{ addslashes($rank->navy_display) }}',
            airforce: '{{ addslashes($rank->airforce_display) }}'
        },
        @endforeach
    };

    function updateRankOptions() {
        const armOfService = document.getElementById('arm_of_service').value;
        const rankSelect = document.getElementById('rank');
        
        // Clear existing options
        rankSelect.innerHTML = '<option value="">Select Rank</option>';
        
        if (!armOfService) {
            rankSelect.innerHTML = '<option value="">Select Arm of Service First</option>';
            return;
        }
        
        // Add ranks for the selected service
        Object.entries(rankData).forEach(([rankCode, rankInfo]) => {
            let rankDisplay = '';
            
            switch(armOfService) {
                case 'ARMY':
                    rankDisplay = rankInfo.army;
                    break;
                case 'NAVY':
                    rankDisplay = rankInfo.navy;
                    break;
                case 'AIRFORCE':
                    rankDisplay = rankInfo.airforce;
                    break;
            }
            
            if (rankDisplay && rankDisplay !== '') {
                const option = document.createElement('option');
                option.value = rankCode;
                option.textContent = `${rankCode} - ${rankDisplay}`;
                rankSelect.appendChild(option);
            }
        });
        
        // If no ranks found for this service
        if (rankSelect.options.length === 1) {
            rankSelect.innerHTML = '<option value="">No ranks available for this service</option>';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize when page loads
        const armSelect = document.getElementById('arm_of_service');
        if (armSelect) {
            armSelect.addEventListener('change', updateRankOptions);
        }
        
        // Select all / deselect all functionality
        document.getElementById('selectAll').addEventListener('click', function() {
            document.querySelectorAll('.officer-checkbox').forEach(checkbox => {
                checkbox.checked = true;
            });
            updateSelectedCount();
        });
        
        document.getElementById('deselectAll').addEventListener('click', function() {
            document.querySelectorAll('.officer-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            updateSelectedCount();
        });
        
        // Update selected count
        function updateSelectedCount() {
            const selected = document.querySelectorAll('.officer-checkbox:checked').length;
            document.getElementById('selectedCount').textContent = selected + ' officers selected';
        }
        
        // Initial count update
        updateSelectedCount();
        
        // Update count when checkboxes change
        document.querySelectorAll('.officer-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });
        
        // Form validation for add officer
        const addOfficerForm = document.querySelector('form[action="{{ route('duty-roster.add-officer') }}"]');
        if (addOfficerForm) {
            addOfficerForm.addEventListener('submit', function(e) {
                const serviceNo = document.getElementById('service_no').value;
                const rank = document.getElementById('rank').value;
                const fname = document.getElementById('fname').value;
                const unit = document.getElementById('unit_id').value;
                const armOfService = document.getElementById('arm_of_service').value;
                const gender = document.getElementById('gender').value;
                
                if (!serviceNo || !rank || !fname || !unit || !armOfService || !gender) {
                    e.preventDefault();
                    alert('Please fill in all required fields marked with *');
                }
            });
        }
    });
</script>

@endsection
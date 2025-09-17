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
                                <li class="breadcrumb-item active">Manage Officers</li>
                            </ul>
                            <div class="d-flex gap-2">
                                <a href="{{ route('duty-roster.index') }}" class="btn btn-sm btn-outline-light mt-2 mt-md-0">
                                    <i class="feather icon-arrow-left"></i> Back to Roster
                                </a>
                                <span class="badge bg-info mt-2 mt-md-0 d-flex align-items-center">
                                    <i class="feather icon-calendar me-1"></i> {{ Carbon::parse($dutyMonth)->format('F Y') }}
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
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="feather icon-users me-2"></i>Manage Duty Officers</h5>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2" id="totalOfficers">{{ $allOfficers->count() }} officers</span>
                        <span class="badge bg-success" id="availableCount">
                            {{ $availableOfficers->count() }} available
                        </span>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Stats Overview -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="stats-card bg-light-primary text-primary">
                                <div class="stats-icon">
                                    <i class="feather icon-users"></i>
                                </div>
                                <div class="stats-number">{{ $allOfficers->count() }}</div>
                                <div class="stats-label">Total Officers</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card bg-light-success text-success">
                                <div class="stats-icon">
                                    <i class="feather icon-user-check"></i>
                                </div>
                                <div class="stats-number">{{ $availableOfficers->count() }}</div>
                                <div class="stats-label">Available This Month</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card bg-light-warning text-warning">
                                <div class="stats-icon">
                                    <i class="feather icon-user-x"></i>
                                </div>
                                <div class="stats-number">{{ $allOfficers->count() - $availableOfficers->count() }}</div>
                                <div class="stats-label">Not Available</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stats-card bg-light-info text-info">
                                <div class="stats-icon">
                                    <i class="feather icon-shield"></i>
                                </div>
                                <div class="stats-number">{{ $units->count() }}</div>
                                <div class="stats-label">Total Units</div>
                            </div>
                        </div>
                    </div>

                    <!-- Add New Officer Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><i class="feather icon-user-plus me-2"></i>Add New Officer</h6>
                                    <button type="button" class="btn btn-sm btn-light" data-toggle="collapse" data-target="#addOfficerForm">
                                        <i class="feather icon-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="card-body collapse show" id="addOfficerForm">
                                    <form method="POST" action="{{ route('duty-roster.add-officer') }}" id="officerForm">
                                        @csrf
                                        <input type="hidden" name="duty_month" value="{{ $dutyMonth }}">
                                        
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="service_no" class="form-label fw-bold">Service Number *</label>
                                                    <input type="text" class="form-control" id="service_no" name="service_no" required 
                                                           placeholder="e.g., NA12345">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="fname" class="form-label fw-bold">Full Name *</label>
                                                    <input type="text" class="form-control" id="fname" name="fname" required 
                                                           placeholder="e.g., John Doe">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="unit_id" class="form-label fw-bold">Unit *</label>
                                                    <select class="form-select" id="unit_id" name="unit_id" required>
                                                        <option value="">Select Unit</option>
                                                        @foreach($units as $unit)
                                                            <option value="{{ $unit->id }}">{{ $unit->unit }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="arm_of_service" class="form-label fw-bold">Arm of Service *</label>
                                                    <select class="form-select" id="arm_of_service" name="arm_of_service" required onchange="updateRankOptions()">
                                                        <option value="">Select Arm</option>
                                                        <option value="ARMY">ARMY</option>
                                                        <option value="NAVY">NAVY</option>
                                                        <option value="AIRFORCE">AIRFORCE</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="rank" class="form-label fw-bold">Rank *</label>
                                                    <select class="form-select" id="rank" name="rank_code" required>
                                                        <option value="">Select Arm First</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="gender" class="form-label fw-bold">Gender *</label>
                                                    <select class="form-select" id="gender" name="gender" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" 
                                                           placeholder="e.g., +2348012345678">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="email" name="email" 
                                                           placeholder="e.g., officer@example.com">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-4">
                                            <div class="col-md-12 text-end">
                                                <button type="reset" class="btn btn-secondary me-2">
                                                    <i class="feather icon-refresh-ccw"></i> Reset
                                                </button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="feather icon-save"></i> Add Officer
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Available Officers Selection -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0"><i class="feather icon-check-circle me-2"></i>Available Officers for {{ Carbon::parse($dutyMonth)->format('F Y') }}</h6>
                                        <p class="text-muted mb-0 mt-1">Select officers who are available for duty this month</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="btn-group me-3">
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="selectAll">
                                                <i class="feather icon-check-square"></i> Select All
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAll">
                                                <i class="feather icon-square"></i> Deselect All
                                            </button>
                                        </div>
                                        <span class="badge bg-info" id="selectedCount">{{ $availableOfficers->count() }} selected</span>
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <form method="POST" action="{{ route('duty-roster.update-available-officers') }}" id="availabilityForm">
                                        @csrf
                                        <input type="hidden" name="duty_month" value="{{ $dutyMonth }}">
                                        
                                        <!-- Search and Filter -->
                                        <div class="row mb-4">
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="feather icon-search"></i></span>
                                                    <input type="text" class="form-control" id="officerSearch" placeholder="Search officers by name, service number, or unit...">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <select class="form-select" id="unitFilter">
                                                    <option value="">Filter by Unit</option>
                                                    @foreach($units as $unit)
                                                        <option value="{{ $unit->unit }}">{{ $unit->unit }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Officers Grid -->
                                        <div class="row" id="officersContainer">
                                            @if($allOfficers->count() > 0)
                                                @foreach($allOfficers as $officer)
                                                <div class="col-md-4 mb-3 officer-card" data-unit="{{ $officer->unit->unit ?? '' }}" 
                                                     data-name="{{ strtolower($officer->fname) }}" data-service="{{ $officer->service_no }}">
                                                    <div class="card border h-100 officer-item {{ isset($availableOfficers[$officer->id]) ? 'border-success' : '' }}">
                                                        <div class="card-body p-3">
                                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input officer-checkbox" type="checkbox" 
                                                                           name="officers[]" value="{{ $officer->id }}" 
                                                                           id="officer{{ $officer->id }}"
                                                                           {{ isset($availableOfficers[$officer->id]) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="officer{{ $officer->id }}"></label>
                                                                </div>
                                                                <span class="badge bg-{{ $officer->arm_of_service == 'ARMY' ? 'primary' : ($officer->arm_of_service == 'NAVY' ? 'info' : 'warning') }} badge-sm">
                                                                    {{ $officer->arm_of_service }}
                                                                </span>
                                                            </div>
                                                            
                                                            <div class="d-flex align-items-center mb-2">
                                                                <div class="officer-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                                     style="width: 40px; height: 40px; font-weight: 600;">
                                                                    {{ substr($officer->fname, 0, 1) }}{{ substr($officer->fname, strpos($officer->fname, ' ') + 1, 1) ?? '' }}
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 officer-name">{{ $officer->display_rank }} {{ $officer->fname }}</h6>
                                                                    <small class="text-muted">{{ $officer->service_no }}</small>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="officer-details">
                                                                <div class="d-flex justify-content-between text-sm mb-1">
                                                                    <span class="text-muted">Unit:</span>
                                                                    <span class="fw-medium">{{ $officer->unit->unit ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between text-sm mb-1">
                                                                    <span class="text-muted">Rank:</span>
                                                                    <span class="fw-medium">{{ $officer->rank_code }}</span>
                                                                </div>
                                                                <div class="d-flex justify-content-between text-sm">
                                                                    <span class="text-muted">Gender:</span>
                                                                    <span class="fw-medium">{{ $officer->gender }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <div class="col-md-12">
                                                    <div class="alert alert-info text-center py-4">
                                                        <i class="feather icon-users fa-2x mb-3"></i>
                                                        <h5>No Officers Found</h5>
                                                        <p class="mb-0">Add officers using the form above to get started.</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        @if($allOfficers->count() > 0)
                                        <div class="row mt-4">
                                            <div class="col-md-12 text-center">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    <i class="feather icon-check-circle me-2"></i> Save Available Officers
                                                </button>
                                                <a href="{{ route('duty-roster.index') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
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
    .stats-card {
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        transition: transform 0.2s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-2px);
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
    
    .bg-light-primary { background-color: #e3f2fd; }
    .bg-light-success { background-color: #e8f5e9; }
    .bg-light-warning { background-color: #fff3e0; }
    .bg-light-info { background-color: #e0f7fa; }
    
    .officer-card {
        transition: transform 0.2s ease;
    }
    
    .officer-card:hover {
        transform: translateY(-2px);
    }
    
    .officer-item {
        transition: all 0.3s ease;
    }
    
    .officer-item:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .officer-avatar {
        font-size: 14px;
    }
    
    .officer-name {
        font-weight: 600;
        color: #2c3e50;
    }
    
    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    .card-header .btn[data-toggle="collapse"] .feather-chevron-down {
        transition: transform 0.3s ease;
    }
    
    .card-header .btn[data-toggle="collapse"].collapsed .feather-chevron-down {
        transform: rotate(-90deg);
    }
</style>

<script>
    // Rank data structure
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
        
        rankSelect.innerHTML = '<option value="">Select Rank</option>';
        
        if (!armOfService) {
            rankSelect.innerHTML = '<option value="">Select Arm of Service First</option>';
            return;
        }
        
        Object.entries(rankData).forEach(([rankCode, rankInfo]) => {
            let rankDisplay = '';
            
            switch(armOfService) {
                case 'ARMY': rankDisplay = rankInfo.army; break;
                case 'NAVY': rankDisplay = rankInfo.navy; break;
                case 'AIRFORCE': rankDisplay = rankInfo.airforce; break;
            }
            
            if (rankDisplay && rankDisplay !== '') {
                const option = document.createElement('option');
                option.value = rankCode;
                option.textContent = `${rankCode} - ${rankDisplay}`;
                rankSelect.appendChild(option);
            }
        });
        
        if (rankSelect.options.length === 1) {
            rankSelect.innerHTML = '<option value="">No ranks available for this service</option>';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize form functionality
        const armSelect = document.getElementById('arm_of_service');
        if (armSelect) {
            armSelect.addEventListener('change', updateRankOptions);
        }
        
        // Select all / deselect all functionality
        document.getElementById('selectAll').addEventListener('click', function() {
            document.querySelectorAll('.officer-checkbox').forEach(checkbox => {
                checkbox.checked = true;
                checkbox.closest('.officer-item').classList.add('border-success');
            });
            updateSelectedCount();
        });
        
        document.getElementById('deselectAll').addEventListener('click', function() {
            document.querySelectorAll('.officer-checkbox').forEach(checkbox => {
                checkbox.checked = false;
                checkbox.closest('.officer-item').classList.remove('border-success');
            });
            updateSelectedCount();
        });
        
        // Update selected count and visual feedback
        function updateSelectedCount() {
            const selected = document.querySelectorAll('.officer-checkbox:checked').length;
            document.getElementById('selectedCount').textContent = selected + ' selected';
            
            // Update visual feedback
            document.querySelectorAll('.officer-checkbox').forEach(checkbox => {
                const card = checkbox.closest('.officer-item');
                if (checkbox.checked) {
                    card.classList.add('border-success');
                } else {
                    card.classList.remove('border-success');
                }
            });
        }
        
        // Initial count update
        updateSelectedCount();
        
        // Update count when checkboxes change
        document.querySelectorAll('.officer-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCount);
        });
        
        // Search functionality
        const searchInput = document.getElementById('officerSearch');
        const unitFilter = document.getElementById('unitFilter');
        const officerCards = document.querySelectorAll('.officer-card');
        
        function filterOfficers() {
            const searchTerm = searchInput.value.toLowerCase();
            const unitValue = unitFilter.value;
            
            officerCards.forEach(card => {
                const name = card.getAttribute('data-name');
                const service = card.getAttribute('data-service');
                const unit = card.getAttribute('data-unit');
                const matchesSearch = name.includes(searchTerm) || service.includes(searchTerm);
                const matchesUnit = !unitValue || unit === unitValue;
                
                card.style.display = (matchesSearch && matchesUnit) ? 'block' : 'none';
            });
        }
        
        searchInput.addEventListener('input', filterOfficers);
        unitFilter.addEventListener('change', filterOfficers);
        
        // Form validation
        const officerForm = document.getElementById('officerForm');
        if (officerForm) {
            officerForm.addEventListener('submit', function(e) {
                const requiredFields = ['service_no', 'fname', 'unit_id', 'arm_of_service', 'rank', 'gender'];
                let isValid = true;
                
                requiredFields.forEach(field => {
                    const element = document.getElementById(field);
                    if (!element.value) {
                        isValid = false;
                        element.classList.add('is-invalid');
                    } else {
                        element.classList.remove('is-invalid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields marked with *');
                }
            });
        }
        
        // Add animation to stats cards
        const statsCards = document.querySelectorAll('.stats-card');
        statsCards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate__animated', 'animate__fadeInUp');
        });
    });
</script>

@endsection
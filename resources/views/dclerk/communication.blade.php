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
                                <li class="breadcrumb-item active">Officer Communication</li>
                            </ul>
                            <div class="d-flex gap-2">
                                <span class="badge bg-info mt-2 mt-md-0 d-flex align-items-center">
                                    <i class="feather icon-calendar me-1"></i> Last 30 Days
                                </span>
                                <span class="badge bg-success mt-2 mt-md-0">
                                    {{ $recentAccounts->count() }} Accounts
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
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-primary">
                        <div class="stats-icon">
                            <i class="feather icon-users"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ $recentAccounts->count() }}</div>
                            <div class="stats-label">Recent Accounts</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-info">
                        <div class="stats-icon">
                            <i class="feather icon-smartphone"></i>
                        </div>
                        <div class="stats-content">
                            @php
                                $withPhones = $recentAccounts->filter(function($account) {
                                    return !empty($account->user->phone);
                                })->count();
                            @endphp
                            <div class="stats-number">{{ $withPhones }}</div>
                            <div class="stats-label">With Phone Numbers</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-success">
                        <div class="stats-icon">
                            <i class="feather icon-mail"></i>
                        </div>
                        <div class="stats-content">
                            @php
                                $withEmails = $recentAccounts->filter(function($account) {
                                    return !empty($account->user->email);
                                })->count();
                            @endphp
                            <div class="stats-number">{{ $withEmails }}</div>
                            <div class="stats-label">With Email Addresses</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card bg-gradient-warning">
                        <div class="stats-icon">
                            <i class="feather icon-clock"></i>
                        </div>
                        <div class="stats-content">
                            <div class="stats-number">{{ $recentAccounts->count() - $withPhones - $withEmails }}</div>
                            <div class="stats-label">Need Contact Info</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Communication Channels -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="feather icon-send text-primary me-2"></i>Communication Channels</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-xl-4 col-md-6">
                                    <div class="com-channel-card bg-primary">
                                        <div class="com-channel-icon">
                                            <i class="feather icon-mail"></i>
                                        </div>
                                        <div class="com-channel-content">
                                            <h6>Email Communication</h6>
                                            <p>Send email notifications to officers</p>
                                            <small class="d-block mb-2">{{ $withEmails }} officers have email addresses</small>
                                            <button class="btn btn-light btn-sm" onclick="openBulkModal('email')">
                                                <i class="feather icon-send me-1"></i> Send Bulk Email
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="com-channel-card bg-success">
                                        <div class="com-channel-icon">
                                            <i class="feather icon-message-square"></i>
                                        </div>
                                        <div class="com-channel-content">
                                            <h6>SMS Messaging</h6>
                                            <p>Send text messages to officers</p>
                                            <small class="d-block mb-2">{{ $withPhones }} officers have phone numbers</small>
                                            <button class="btn btn-light btn-sm" onclick="openBulkModal('sms')">
                                                <i class="feather icon-send me-1"></i> Send Bulk SMS
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="com-channel-card bg-info">
                                        <div class="com-channel-icon">
                                            <i class="feather icon-printer"></i>
                                        </div>
                                        <div class="com-channel-content">
                                            <h6>Print Documents</h6>
                                            <p>Generate printable communications</p>
                                            <small class="d-block mb-2">Physical documentation</small>
                                            <button class="btn btn-light btn-sm" onclick="window.print()">
                                                <i class="feather icon-printer me-1"></i> Print List
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recently Created Accounts -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="feather icon-user-plus me-2"></i>
                                Recently Created Accounts (Last 30 Days)
                                <span class="badge bg-primary ms-2">{{ $recentAccounts->count() }}</span>
                            </h5>
                            <div class="d-flex gap-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="check-all">
                                    <label class="form-check-label small" for="check-all">Select All</label>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                                    <i class="feather icon-printer"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($recentAccounts->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 40px;">
                                                    <input type="checkbox" id="check-all-main">
                                                </th>
                                                <th>Officer Details</th>
                                                <th>Contact Information</th>
                                                <th>Unit & Service</th>
                                                <th>Account Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentAccounts as $account)
                                                <tr class="officer-row">
                                                    <td>
                                                        <input type="checkbox" name="user_ids[]" 
                                                               value="{{ $account->user->id }}" 
                                                               class="user-checkbox">
                                                    </td>
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
                                                        <div class="contact-info">
                                                            @if($account->user->phone)
                                                                <div class="d-flex align-items-center mb-1">
                                                                    <i class="feather icon-phone text-success me-2"></i>
                                                                    <span>{{ $account->user->phone }}</span>
                                                                </div>
                                                            @endif
                                                            @if($account->user->email)
                                                                <div class="d-flex align-items-center">
                                                                    <i class="feather icon-mail text-primary me-2"></i>
                                                                    <span class="text-truncate" style="max-width: 200px;">{{ $account->user->email }}</span>
                                                                </div>
                                                            @endif
                                                            @if(!$account->user->phone && !$account->user->email)
                                                                <span class="text-muted">No contact information</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="unit-info">
                                                            <div class="badge bg-{{ $account->user->arm_of_service == 'ARMY' ? 'primary' : ($account->user->arm_of_service == 'NAVY' ? 'info' : 'warning') }} mb-1">
                                                                {{ $account->user->arm_of_service }}
                                                            </div>
                                                            <div class="text-muted small">{{ $account->user->unit->unit ?? 'N/A' }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="created-info">
                                                            <div class="fw-medium">{{ $account->account_created_at->format('M d, Y') }}</div>
                                                            <div class="text-muted small">{{ $account->account_created_at->format('H:i') }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            @if($account->user->phone)
                                                                <button type="button" class="btn btn-sm btn-outline-success send-single-sms" 
                                                                        data-user-id="{{ $account->user->id }}"
                                                                        data-user-name="{{ $account->user->display_rank }} {{ $account->user->fname }}">
                                                                    <i class="feather icon-message-square"></i> SMS
                                                                </button>
                                                            @endif
                                                            @if($account->user->email)
                                                                <button type="button" class="btn btn-sm btn-outline-primary send-single-email" 
                                                                        data-user-id="{{ $account->user->id }}"
                                                                        data-user-name="{{ $account->user->display_rank }} {{ $account->user->fname }}">
                                                                    <i class="feather icon-mail"></i> Email
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="feather icon-user-x fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No Recent Accounts</h5>
                                    <p class="text-muted">No accounts have been created in the last 30 days.</p>
                                    <a href="{{ route('dclerk.accounts') }}" class="btn btn-primary">
                                        <i class="feather icon-user-plus me-2"></i> Manage Accounts
                                    </a>
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
                                <a href="{{ route('dclerk.accounts') }}" class="btn btn-outline-primary">
                                    <i class="feather icon-user-plus me-2"></i> Manage Accounts
                                </a>
                                <a href="{{ route('dclerk.password-list') }}" class="btn btn-outline-success">
                                    <i class="feather icon-key me-2"></i> View Passwords
                                </a>
                                <a href="{{ route('dclerk.roster.view') }}" class="btn btn-outline-info">
                                    <i class="feather icon-calendar me-2"></i> View Roster
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Communication Modal -->
    <div class="modal fade" id="bulkCommunicationModal" tabindex="-1" role="dialog" aria-labelledby="bulkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="bulkModalLabel">Confirm Bulk Communication</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="feather icon-send fa-2x text-primary mb-2"></i>
                        <h6 id="modal-type-label">Send Communication</h6>
                    </div>
                    <p>Are you sure you want to send <strong id="modal-type-desc">this message</strong> to the selected officers?</p>
                    <div class="alert alert-info" id="selected-count">
                        <i class="feather icon-info me-2"></i>
                        <span id="selected-count-text">0 officers selected</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirm-send-btn">
                        <i class="feather icon-send me-2"></i> Confirm Send
                    </button>
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
    
    .com-channel-card {
        border-radius: 12px;
        padding: 25px;
        color: white;
        text-align: center;
        height: 100%;
        transition: transform 0.3s ease;
    }
    
    .com-channel-card:hover {
        transform: translateY(-3px);
    }
    
    .com-channel-icon {
        font-size: 3rem;
        margin-bottom: 15px;
        opacity: 0.9;
    }
    
    .com-channel-content h6 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .com-channel-content p {
        margin-bottom: 15px;
        opacity: 0.9;
    }
    
    .officer-row:hover {
        background-color: #f8f9fa;
    }
    
    .officer-avatar {
        font-weight: 600;
    }
    
    .contact-info i {
        width: 16px;
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
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    
    @media (max-width: 768px) {
        .com-channel-card {
            margin-bottom: 20px;
        }
        
        .btn-group {
            flex-wrap: wrap;
            gap: 5px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize checkboxes
        const checkAll = document.getElementById('check-all');
        const checkAllMain = document.getElementById('check-all-main');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');
        
        // Select all functionality
        function setupCheckboxToggle(master, slaves) {
            if (master) {
                master.addEventListener('change', function() {
                    slaves.forEach(cb => {
                        cb.checked = this.checked;
                    });
                    updateSelectedCount();
                });
            }
        }
        
        setupCheckboxToggle(checkAll, userCheckboxes);
        setupCheckboxToggle(checkAllMain, userCheckboxes);
        
        // Update selected count
        function updateSelectedCount() {
            const selected = document.querySelectorAll('.user-checkbox:checked').length;
            const countElement = document.getElementById('selected-count-text');
            if (countElement) {
                countElement.textContent = `${selected} officer(s) selected`;
            }
        }
        
        // Update count when checkboxes change
        userCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateSelectedCount);
        });
        
        // Single SMS sending
        document.querySelectorAll('.send-single-sms').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const userName = this.getAttribute('data-user-name');
                
                if (confirm(`Send SMS to ${userName}?`)) {
                    sendSingleCommunication(userId, 'sms', this);
                }
            });
        });
        
        // Single Email sending
        document.querySelectorAll('.send-single-email').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const userName = this.getAttribute('data-user-name');
                
                if (confirm(`Send email to ${userName}?`)) {
                    sendSingleCommunication(userId, 'email', this);
                }
            });
        });
        
        // Bulk modal handling
        window.openBulkModal = function(type) {
            const selectedCheckboxes = document.querySelectorAll('input.user-checkbox:checked');
            
            if (selectedCheckboxes.length === 0) {
                alert('Please select at least one officer.');
                return;
            }

            // Update modal content
            const typeLabel = type === 'email' ? 'Email' : 'SMS';
            const typeDesc = type === 'email' ? 'an email' : 'an SMS';
            document.getElementById('modal-type-label').textContent = `Send ${typeLabel}`;
            document.getElementById('modal-type-desc').textContent = typeDesc;
            updateSelectedCount();

            // Set up confirm button
            const confirmBtn = document.getElementById('confirm-send-btn');
            confirmBtn.onclick = function() {
                sendBulkCommunication(type, selectedCheckboxes);
                $('#bulkCommunicationModal').modal('hide');
            };

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('bulkCommunicationModal'));
            modal.show();
        };
    });

    function sendSingleCommunication(userId, type, buttonElement) {
        console.log(`Sending ${type} for user:`, userId);
        
        // Show loading state
        const button = buttonElement;
        const originalHtml = button.innerHTML;
        button.innerHTML = '<i class="feather icon-loader spin"></i> Sending...';
        button.disabled = true;

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        // Use correct endpoints
        const endpoint = type === 'sms' 
    ? '{{ route("dclerk.communication.sendSms", "") }}/' + userId 
    : '{{ route("dclerk.communication.sendEmail", "") }}/' + userId;


        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`${type.toUpperCase()} sent successfully to ${data.recipient || 'officer'}!`);
            } else {
                alert(`Failed to send ${type}: ${data.message || 'Unknown error'}`);
            }
        })
        .catch(error => {
            console.error(`${type} error:`, error);
            alert(`Error sending ${type}: ${error.message}`);
        })
        .finally(() => {
            // Reset button state
            button.innerHTML = originalHtml;
            button.disabled = false;
        });
    }

    function sendBulkCommunication(type, selectedCheckboxes) {
        const userIds = Array.from(selectedCheckboxes).map(cb => cb.value);
        
        // Show loading state
        const originalText = document.getElementById('confirm-send-btn').innerHTML;
        document.getElementById('confirm-send-btn').innerHTML = '<i class="feather icon-loader spin"></i> Sending...';
        document.getElementById('confirm-send-btn').disabled = true;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        const endpoint = type === 'sms' 
    ? '{{ route("dclerk.communication.sendBulkSms") }}'
    : '{{ route("dclerk.communication.sendBulkEmail") }}';


        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ user_ids: userIds })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => {
            alert('Error: ' + error.message);
        })
        .finally(() => {
            document.getElementById('confirm-send-btn').innerHTML = originalText;
            document.getElementById('confirm-send-btn').disabled = false;
        });
    }

    // Add spinner animation CSS
    const style = document.createElement('style');
    style.textContent = `
        .spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection
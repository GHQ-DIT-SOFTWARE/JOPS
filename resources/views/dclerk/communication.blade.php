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
                                <h5 class="m-b-10">Officer Communication</h5>
                            </div>
                            <div class="d-flex justify-content-between align-items-center flex-wrap breadcrumb-white">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('dclerk.dashboard') }}">D Clerk Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="#!">Officer Communication</a></li>
                                </ul>
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
                        <h5>Communicate with Duty Officers</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <!-- Communication Options -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Communication Methods</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <i class="feather icon-mail fa-3x text-primary mb-3"></i>
                                                        <h5>Email</h5>
                                                        <p>Send email notifications to officers</p>
                                                        <button class="btn btn-primary" onclick="openBulkModal('email')">Send Emails</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <i class="feather icon-message-square fa-3x text-success mb-3"></i>
                                                        <h5>SMS</h5>
                                                        <p>Send text messages to officers</p>
                                                        <button class="btn btn-success" onclick="openBulkModal('sms')">Send SMS</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <i class="feather icon-printer fa-3x text-info mb-3"></i>
                                                        <h5>Print</h5>
                                                        <p>Generate printable documents</p>
                                                        <button class="btn btn-info" onclick="window.print()">Print List</button>
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
                                    <div class="card-header">
                                        <h6>Recently Created Accounts (Last 7 Days)</h6>
                                    </div>
                                    <div class="card-body">
                                        @if($recentAccounts->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th><input type="checkbox" id="check-all"></th>
                                                            <th>Officer</th>
                                                            <th>Service No</th>
                                                            <th>Phone</th>
                                                            <th>Email</th>
                                                            <th>Unit</th>
                                                            <th>Account Created</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($recentAccounts as $account)
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox" name="user_ids[]" 
                                                                           value="{{ $account->user->id }}" 
                                                                           class="user-checkbox">
                                                                </td>
                                                                <td>{{ $account->user->display_rank }} {{ $account->user->fname }}</td>
                                                                <td>{{ $account->user->service_no }}</td>
                                                                <td>{{ $account->user->phone ?? 'N/A' }}</td>
                                                                <td>{{ $account->user->email ?? 'N/A' }}</td>
                                                                <td>{{ $account->user->unit->unit ?? 'N/A' }}</td>
                                                                <td>{{ $account->account_created_at->format('M d, Y H:i') }}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-sm btn-success send-single-sms" 
                                                                            data-user-id="{{ $account->user->id }}"
                                                                            data-user-name="{{ $account->user->display_rank }} {{ $account->user->fname }}">
                                                                        Send SMS
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="alert alert-info">
                                                <i class="feather icon-info"></i>
                                                No accounts have been created in the last 7 days.
                                            </div>
                                        @endif
                                    </div>
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
                <form method="POST" action="{{ route('dclerk.sendBulkCommunication') }}" id="bulk-modal-form">
                    @csrf
                    <input type="hidden" name="type" id="modal-communication-type">
                    <div id="user-checkboxes"></div>
                    
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bulkModalLabel">Confirm Bulk Communication</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="feather icon-x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to send <strong id="modal-type-label">this message</strong> to the selected officers?</p>
                            <div id="selected-count" class="text-info"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Yes, Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Wait for document to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded - initializing communication functions');
        
        // Select all checkboxes
        const checkAllCheckbox = document.getElementById('check-all');
        if (checkAllCheckbox) {
            checkAllCheckbox.addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('.user-checkbox');
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                console.log('Select all changed: ', this.checked);
            });
        }

        // Single SMS sending
        const singleSmsButtons = document.querySelectorAll('.send-single-sms');
        singleSmsButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const userName = this.getAttribute('data-user-name');
                
                console.log('SMS button clicked for user:', userId, userName);
                
                if (confirm(`Send SMS to ${userName}?`)) {
                    sendSingleSMS(userId, this);
                }
            });
        });

        // Bulk modal form submission
        const bulkModalForm = document.getElementById('bulk-modal-form');
        if (bulkModalForm) {
            bulkModalForm.addEventListener('submit', function(e) {
                e.preventDefault();
                console.log('Bulk form submitted');
                
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="feather icon-loader spin"></i> Sending...';
                submitBtn.disabled = true;

                // Submit form via AJAX
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Bulk response:', data);
                    if (data.success) {
                        alert(data.message);
                        $('#bulkCommunicationModal').modal('hide');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Bulk error:', error);
                    alert('Error: ' + error.message);
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        }
    });

    function openBulkModal(type) {
        console.log('Opening bulk modal for type:', type);
        
        const selectedCheckboxes = document.querySelectorAll('input.user-checkbox:checked');
        
        if (selectedCheckboxes.length === 0) {
            alert('Please select at least one officer.');
            return;
        }

        // Clear previous hidden inputs
        const userCheckboxesContainer = document.getElementById('user-checkboxes');
        userCheckboxesContainer.innerHTML = '';

        // Add hidden inputs for selected users
        selectedCheckboxes.forEach(cb => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'user_ids[]';
            hiddenInput.value = cb.value;
            userCheckboxesContainer.appendChild(hiddenInput);
        });

        // Set communication type
        document.getElementById('modal-communication-type').value = type;

        // Update modal label and count
        const typeLabel = type === 'email' ? 'an email' : 'an SMS';
        document.getElementById('modal-type-label').textContent = typeLabel;
        document.getElementById('selected-count').textContent = `Selected officers: ${selectedCheckboxes.length}`;

        // Show modal using jQuery (since Bootstrap modals need jQuery)
        $('#bulkCommunicationModal').modal('show');
    }

    function sendSingleSMS(userId, buttonElement) {
        console.log('Sending single SMS for user:', userId);
        
        // Show loading state
        const button = buttonElement || document.querySelector(`.send-single-sms[data-user-id="${userId}"]`);
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="feather icon-loader spin"></i> Sending...';
        button.disabled = true;

        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        fetch('{{ route("dclerk.sendSms", "") }}/' + userId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('SMS response:', data);
            if (data.success) {
                alert('SMS sent successfully!');
            } else {
                alert('Failed to send SMS: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('SMS error:', error);
            alert('Error sending SMS: ' + error.message);
        })
        .finally(() => {
            // Reset button state
            button.innerHTML = originalText;
            button.disabled = false;
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
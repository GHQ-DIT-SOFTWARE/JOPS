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
                                <li class="breadcrumb-item active">Password Management</li>
                            </ul>
                            <div class="d-flex gap-2">
                                <a href="{{ route('duty-roster.index', ['month' => $month, 'year' => $year]) }}" 
                                   class="btn btn-sm btn-outline-light mt-2 mt-md-0">
                                    <i class="feather icon-arrow-left"></i> Back to Roster
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
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="feather icon-shield me-2"></i>Temporary Passwords</h5>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-success me-2">
                            <i class="feather icon-check-circle"></i> {{ $processedCount }} Active
                        </span>
                        <div class="btn-group">
                            <a href="{{ route('dclerk.password-list', ['month' => $month, 'year' => $year]) }}" 
                               class="btn btn-sm btn-outline-primary">
                                <i class="feather icon-refresh-cw"></i> Refresh
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Security Notice -->
                    <div class="alert alert-warning">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <i class="feather icon-alert-triangle fa-2x"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="alert-heading">Security Notice</h6>
                                <p class="mb-1">Temporary passwords expire after 5 minutes. Regenerate if expired.</p>
                                <small class="text-muted">Passwords are automatically hidden for security.</small>
                            </div>
                        </div>
                    </div>

                    @if(session('message'))
                    <div class="alert alert-{{ session('alert-type', 'info') }} alert-dismissible fade show">
                        <i class="feather icon-{{ session('alert-type') === 'success' ? 'check-circle' : 'info' }} me-2"></i>
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    <!-- Password List -->
                    <div class="card">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="feather icon-list me-2"></i>Password List</h6>
                            <span class="badge bg-info">{{ count($passwords) }} accounts</span>
                        </div>
                        <div class="card-body p-0">
                            @if(count($passwords) > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Officer Details</th>
                                            <th>Service Information</th>
                                            <th>Temporary Password</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($passwords as $item)
                                        <tr class="password-row">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="officer-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 40px; height: 40px; font-weight: 600;">
                                                        {{ substr($item['officer'], 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $item['officer'] }}</div>
                                                        <small class="text-muted">{{ $item['email'] ?? 'No email' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="badge bg-{{ $item['arm_of_service'] == 'ARMY' ? 'primary' : ($item['arm_of_service'] == 'NAVY' ? 'info' : 'warning') }} mb-1">
                                                        {{ $item['arm_of_service'] }}
                                                    </span>
                                                    <small class="text-muted">{{ $item['unit'] }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="password-display" id="password-{{ $loop->index }}">
                                                        <code class="bg-light p-2 rounded">••••••••</code>
                                                    </div>
                                                    <button class="btn btn-sm btn-outline-primary ms-2 toggle-password" 
                                                            data-password="{{ $item['temp_password'] }}" 
                                                            data-target="password-{{ $loop->index }}">
                                                        <i class="feather icon-eye"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-success ms-1 copy-password" 
                                                            data-password="{{ $item['temp_password'] }}">
                                                        <i class="feather icon-copy"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                @if($item['is_expired'])
                                                <span class="badge bg-danger">
                                                    <i class="feather icon-clock me-1"></i> Expired
                                                </span>
                                                @else
                                                <span class="badge bg-success">
                                                    <i class="feather icon-check-circle me-1"></i> Valid
                                                    <br>
                                                    <small>Expires: {{ $item['expires_at']->diffForHumans() }}</small>
                                                </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    @if($item['is_expired'])
                                                    <form action="{{ route('dclerk.regenerate-password', $item['user_id']) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="month" value="{{ $month }}">
                                                        <input type="hidden" name="year" value="{{ $year }}">
                                                        <button type="submit" class="btn btn-sm btn-warning" 
                                                                onclick="return confirm('Regenerate password for {{ $item['officer'] }}?')">
                                                            <i class="feather icon-refresh-cw"></i> Regenerate
                                                        </button>
                                                    </form>
                                                    @else
                                                    <span class="text-muted small">Active</span>
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
                                <i class="feather icon-shield-off fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Temporary Passwords</h5>
                                <p class="text-muted">No accounts with temporary passwords found for this month.</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button class="btn btn-outline-primary" id="revealAllPasswords">
                                        <i class="feather icon-eye me-1"></i> Reveal All
                                    </button>
                                    <button class="btn btn-outline-secondary" id="hideAllPasswords">
                                        <i class="feather icon-eye-off me-1"></i> Hide All
                                    </button>
                                </div>
                                
                                <div class="btn-group">
                                    <a href="{{ route('duty-roster.index', ['month' => $month, 'year' => $year]) }}" 
                                       class="btn btn-secondary">
                                        <i class="feather icon-arrow-left me-1"></i> Back to Roster
                                    </a>
                                    <button class="btn btn-success" onclick="window.print()">
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
</section>

<style>
    .password-row:hover {
        background-color: #f8f9fa;
    }
    
    .password-display code {
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        letter-spacing: 1px;
    }
    
    .officer-avatar {
        font-weight: 600;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let allPasswordsVisible = false;
        
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const password = this.getAttribute('data-password');
                const targetId = this.getAttribute('data-target');
                const target = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (target.textContent.includes('••••••••')) {
                    target.innerHTML = `<code class="bg-light p-2 rounded">${password}</code>`;
                    icon.classList.remove('icon-eye');
                    icon.classList.add('icon-eye-off');
                } else {
                    target.innerHTML = `<code class="bg-light p-2 rounded">••••••••</code>`;
                    icon.classList.remove('icon-eye-off');
                    icon.classList.add('icon-eye');
                }
            });
        });
        
        // Copy password to clipboard
        document.querySelectorAll('.copy-password').forEach(button => {
            button.addEventListener('click', function() {
                const password = this.getAttribute('data-password');
                copyToClipboard(password);
                
                // Show feedback
                const originalHtml = this.innerHTML;
                this.innerHTML = '<i class="feather icon-check"></i>';
                this.classList.add('btn-success');
                this.classList.remove('btn-outline-success');
                
                setTimeout(() => {
                    this.innerHTML = originalHtml;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-success');
                }, 2000);
            });
        });
        
        // Reveal all passwords
        document.getElementById('revealAllPasswords').addEventListener('click', function() {
            document.querySelectorAll('.toggle-password').forEach(button => {
                const targetId = button.getAttribute('data-target');
                const target = document.getElementById(targetId);
                const password = button.getAttribute('data-password');
                
                target.innerHTML = `<code class="bg-light p-2 rounded">${password}</code>`;
                button.querySelector('i').classList.remove('icon-eye');
                button.querySelector('i').classList.add('icon-eye-off');
            });
            allPasswordsVisible = true;
        });
        
        // Hide all passwords
        document.getElementById('hideAllPasswords').addEventListener('click', function() {
            document.querySelectorAll('.toggle-password').forEach(button => {
                const targetId = button.getAttribute('data-target');
                const target = document.getElementById(targetId);
                
                target.innerHTML = `<code class="bg-light p-2 rounded">••••••••</code>`;
                button.querySelector('i').classList.remove('icon-eye-off');
                button.querySelector('i').classList.add('icon-eye');
            });
            allPasswordsVisible = false;
        });
        
        // Copy to clipboard function
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Show toast notification
                const toast = document.createElement('div');
                toast.style.cssText = `
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    background: #28a745;
                    color: white;
                    padding: 12px 20px;
                    border-radius: 6px;
                    z-index: 1000;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                `;
                toast.innerHTML = `<i class="feather icon-check-circle me-2"></i> Password copied to clipboard`;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 3000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
                alert('Failed to copy password. Please try again.');
            });
        }
        
        // Auto-hide passwords after 30 seconds
        setTimeout(() => {
            if (allPasswordsVisible) {
                document.getElementById('hideAllPasswords').click();
            }
        }, 30000);
    });
</script>
@endsection
<!-- resources/views/dclerk/password-list.blade.php -->

@php
    use Carbon\Carbon;
@endphp
@extends('adminbackend.layouts.master')

@section('main')
    <style>
        /* Button tweaks */
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

        .password-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        code.password-text {
            font-family: monospace;
            font-size: 1rem;
            user-select: text;
        }

        button.toggle-password {
            cursor: pointer;
        }

        button.copy-password {
            transition: background-color 0.3s ease;
        }

        button.copy-password.btn-success {
            background-color: #28a745 !important;
            color: white !important;
            border-color: #28a745 !important;
        }

        /* Search box styling */
        #password-search {
            margin-bottom: 1rem;
            max-width: 300px;
        }
    </style>

    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">{{ $nav_title }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Temporary Passwords for {{ Carbon::create($year, $month, 1)->format('F Y') }}</h5>
                        <p class="text-muted mb-0">Generated for {{ $processedCount }} officers</p>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="feather icon-alert-triangle"></i>
                            <strong>Important:</strong> These passwords are temporary and will expire.
                            Officers should change their password after first login.
                        </div>

                        @if (count($passwords) > 0)
                            <!-- Search input -->
                            <input type="search" id="password-search" class="form-control"
                                placeholder="Search by Service No, Officer, Rank, or Unit..." aria-label="Search passwords">

                            <div class="table-responsive">
                                <table class="table table-striped" id="password-table">
                                    <thead>
                                        <tr>
                                            <th>Service No</th>
                                            <th>Officer</th>
                                            <th>Rank</th>
                                            <th>Unit</th>
                                            <th>Temporary Password</th>
                                            <th>Expires At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($passwords as $account)
    <tr>
        <td>{{ $account->user->service_no }}</td>
        <td>{{ $account->user->fname }}</td>
        <td>{{ $account->user->display_rank }}</td>
        <td>{{ $account->user->unit->unit ?? 'N/A' }}</td>
        <td>
            <code class="text-primary password-text" id="password-{{ $loop->index }}">
                {{ $account->temp_password }}
            </code>
        </td>
        <td>{{ $account->expires_at ? $account->expires_at->format('M j, Y H:i') : 'N/A' }}</td>
        <td class="password-actions">
            <button class="btn btn-sm btn-outline-secondary toggle-password"
                    type="button" data-target="password-{{ $loop->index }}"
                    aria-label="Toggle password visibility" title="Show/Hide Password">
                <i class="feather icon-eye"></i>
            </button>
            <button class="btn btn-sm btn-outline-primary copy-password"
                    data-target="password-{{ $loop->index }}"
                    aria-label="Copy password to clipboard" title="Copy Password">
                <i class="feather icon-copy"></i>
            </button>

            @if ($account->expires_at && $account->expires_at->isPast())
                <form action="{{ route('dclerk.regenerate-temp-password', $account->user->id) }}"
                      method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm">Regenerate Password</button>
                </form>
            @endif
        </td>
    </tr>
@endforeach

                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="feather icon-info"></i> No active temporary passwords found.
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('dclerk.accounts') }}" class="btn btn-secondary">
                                <i class="feather icon-arrow-left"></i> Back to Accounts
                            </a>
                            <a href="{{ route('dclerk.communication') }}" class="btn btn-primary">
                                <i class="feather icon-message-circle"></i> Send Communications
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Copy password button handler
        document.querySelectorAll('.copy-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordElement = document.getElementById(targetId);
                const password = passwordElement.textContent;

                navigator.clipboard.writeText(password).then(() => {
                    // Show feedback
                    const originalHtml = this.innerHTML;
                    this.innerHTML = '<i class="feather icon-check"></i> Copied!';
                    this.classList.add('btn-success');

                    setTimeout(() => {
                        this.innerHTML = originalHtml;
                        this.classList.remove('btn-success');
                    }, 2000);
                });
            });
        });

        // Show/hide password toggle with icon switch
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordElement = document.getElementById(targetId);

                // Save original password in data attribute (if not already saved)
                if (!passwordElement.getAttribute('data-real-password')) {
                    passwordElement.setAttribute('data-real-password', passwordElement.textContent);
                }

                const isMasked = passwordElement.textContent === '••••••••••';

                if (isMasked) {
                    // Show real password
                    passwordElement.textContent = passwordElement.getAttribute('data-real-password');
                    this.innerHTML = '<i class="feather icon-eye-off"></i>';
                } else {
                    // Mask password
                    passwordElement.textContent = '••••••••••';
                    this.innerHTML = '<i class="feather icon-eye"></i>';
                }
            });
        });

        // Auto-hide passwords after 5 minutes for security
        setTimeout(() => {
            document.querySelectorAll('[id^="password-"]').forEach(el => {
                if (!el.getAttribute('data-real-password')) {
                    el.setAttribute('data-real-password', el.textContent);
                }
                el.textContent = '••••••••••';
            });

            document.querySelectorAll('.toggle-password').forEach(btn => {
                btn.innerHTML = '<i class="feather icon-eye"></i>';
            });
        }, 300000); // 5 minutes


        // SEARCH / FILTER FUNCTIONALITY
        document.getElementById('password-search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#password-table tbody tr');

            rows.forEach(row => {
                // Search in Service No, Officer, Rank, Unit cells
                const serviceNo = row.cells[0].textContent.toLowerCase();
                const officer = row.cells[1].textContent.toLowerCase();
                const rank = row.cells[2].textContent.toLowerCase();
                const unit = row.cells[3].textContent.toLowerCase();

                if (
                    serviceNo.includes(searchTerm) ||
                    officer.includes(searchTerm) ||
                    rank.includes(searchTerm) ||
                    unit.includes(searchTerm)
                ) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection

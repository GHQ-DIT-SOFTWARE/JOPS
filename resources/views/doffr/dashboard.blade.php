@extends('adminbackend.layouts.master')

@section('main')
    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">{{ $nav_title }}</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Home</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!--marquee-->
                <div class="card" style="width: 100%;">
                    <div class="card-body py-2">
                        <marquee behavior="scroll" direction="left" scrollamount="5" class="text-deep-brown">
                            <b> Breaking: New policy update released. •
                                Reminder: Submit duty reports by end of day. •
                                Incoming mails processed successfully. •
                                Outgoing mails dispatch scheduled for tomorrow.</b>
                        </marquee>
                    </div>
                </div>

            </div>
            <div class="row">
                <!-- Cards -->
                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 1.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Duty Report</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 5.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Daily SITREP</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 3.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Incoming Mails</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 4.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Outgoing Mails</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <!-- Cards -->
                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 2.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Scheduler</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 6.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Part One Orders</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 8.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Operations</h6>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 7.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Settings</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card glass-card">
                        <div class="card-body">
                            <div class="row align-items-center m-l-0">
                                <div class="col-auto">
                                    <img src="{{ asset('assets/images/vector 7.png') }}" alt="" width="75px"
                                        height="75px">
                                </div>
                                <div class="col-auto">
                                    <h6 class="text-muted m-b-10">Broadcast</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Notifications Section for Duty Officers -->
            @if (Auth::user()->is_role === App\Models\User::ROLE_DOFFR)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>Your Duty Notifications</span>
                                <button class="btn btn-sm btn-outline-secondary" onclick="loadNotifications()">
                                    <i class="feather icon-refresh-cw"></i> Refresh
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="notifications-container">
                                    <div class="text-center text-muted py-3">
                                        <i class="feather icon-loader fa-spin"></i> Loading notifications...
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>

    @if (
    $dutyAccount &&
    $dutyAccount->temp_password_expires_at &&
    \Carbon\Carbon::now()->lt($dutyAccount->temp_password_expires_at) &&
    !request()->is('password/change') &&
    !request()->is('logout')
)
    <!-- Temporary Password Modal -->
    <div class="modal fade" id="tempPasswordModal" tabindex="-1" aria-labelledby="tempPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tempPasswordModalLabel">Temporary Password Notice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Your temporary password is:</strong></p>
                    <h4 class="text-primary">{{ $dutyAccount->show_temp_password }}</h4>
                    <p>Please change your password immediately for security reasons.</p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('password.view') }}" class="btn btn-primary">Change Password Now</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Later</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tempPasswordModal = new bootstrap.Modal(document.getElementById('tempPasswordModal'));
            tempPasswordModal.show();
        });
    </script>
@endif
<script>
    function loadNotifications() {
        const container = document.getElementById('notifications-container');
        container.innerHTML = '<div class="text-center text-muted py-3"><i class="feather icon-loader fa-spin"></i> Loading notifications...</div>';

        fetch("{{ route('doffr.notifications') }}")
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.length === 0) {
                    container.innerHTML = '<div class="text-center text-muted py-3">No new notifications.</div>';
                    return;
                }

                const html = data.map(notification => `
                    <div class="alert alert-info mb-2">
                        <strong>${notification.type.replace(/_/g, ' ').toUpperCase()}</strong>: ${notification.message}
                        <br><small class="text-muted">Date: ${notification.related_date ?? 'N/A'}</small>
                    </div>
                `).join('');

                container.innerHTML = html;
            })
            .catch(error => {
                console.error('Fetch failed:', error);
                container.innerHTML = '<div class="text-danger text-center">Failed to load notifications.</div>';
            });
    }

    document.addEventListener('DOMContentLoaded', loadNotifications);
</script>

@endsection

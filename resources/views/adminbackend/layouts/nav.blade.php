@php
    $prefix = Request::route()->getPrefix();
    $route = Route::currentRouteName();
@endphp

<nav class="pcoded-navbar menu-light">
    <div class="navbar-wrapper">
        <div class="navbar-content scroll-div">
            <div class="">
                @php
                    $user = DB::table('users')
                        ->where('id', Auth::user()->id)
                        ->first();
                @endphp
                <div class="main-menu-header">
                    <img class="img-radius" src="{{ asset('upload/ghq.gif') }}" alt="User-Profile-Image">

                </div>

            </div>

            <ul class="nav pcoded-inner-navbar">

                @if (Auth::user()->is_role == 0)
                    <li class="nav-item {{ $route == 'superadmin.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-desktop"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>


                    {{-- MANAGE PROFILE --}}
                    <li
                        class="nav-item pcoded-hasmenu {{ Request::is('superadmin/reports*') ? 'active pcoded-trigger' : '' }}">
                        <a href="#!" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                            <span class="pcoded-mtext">Reports</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ Request::is('superadmin/reports/dutyreport') ? 'active' : '' }}">
                                <a href="{{ route('superadmin.reports.dutyreport') }}">Duty Report</a>
                            </li>

                            <li class="{{ Request::is('superadmin/reports/dailysitrep') ? 'active' : '' }}">
                                <a href="{{ route('superadmin.reports.dailysitrep') }}">Daily Sitrep</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ $route == 'superadmin.mails' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.mails') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-envelope"></i></span>
                            <span class="pcoded-mtext">Mails</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $route == 'superadmin.scheduler' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.scheduler') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-calendar"></i></span>
                            <span class="pcoded-mtext">Scheduler</span>
                        </a>
                    </li>
                    <li class="nav-item {{ $route == 'superadmin.partone' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.partone') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-list"></i></span>
                            <span class="pcoded-mtext">Part One Orders</span>
                        </a>
                    </li>

                   <li class="nav-item {{ $route == 'superadmin.operation' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.operation') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-diagram-project"></i></span>
                            <span class="pcoded-mtext">Operations</span>
                        </a>
                    </li>
                    <li class="nav-item {{ $route == 'superadmin.broadcast' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.broadcast') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-tower-broadcast"></i></span>
                            <span class="pcoded-mtext">Broadcast</span>
                        </a>
                    </li>


                    {{-- USER MANAGEMENT --}}
                    <li class="nav-item pcoded-hasmenu {{ $prefix == '/users' ? 'active pcoded-trigger' : '' }}">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-users"></i></span>
                            <span class="pcoded-mtext">Users</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ $route == 'superadmin.users.list' ? 'active' : '' }}">
                                <a href="{{ route('superadmin.users.list') }}">Users</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ $route == 'superadmin.setting' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.setting') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-gears"></i></span>
                            <span class="pcoded-mtext">Settings</span>
                        </a>
                    </li>



                    {{-- DG Sidebar --}}
                @elseif (Auth::user()->is_role == 1)
                    <li class="nav-item {{ $route == 'dg.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dg.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-display"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $route == 'dg.reports.pending' ? 'active' : '' }}">
                        <a href="{{ route('dg.reports.pending') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-file"></i></span>
                            <span class="pcoded-mtext">Pending Reports</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $route == 'dg.reports.approved' ? 'active' : '' }}">
                        <a href="{{ route('dg.reports.approved') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-check"></i></span>
                            <span class="pcoded-mtext">Approved Reports</span>
                        </a>
                    </li>

                    {{-- DLAND Sidebar --}}
                @elseif(Auth::user()->is_role == 2)
                    <li class="nav-item {{ $route == 'dland.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dland.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-display"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $route == 'dland.reports.pending' ? 'active' : '' }}">
                        <a href="{{ route('dland.reports.pending') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-file"></i></span>
                            <span class="pcoded-mtext">Pending Reports</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $route == 'dland.reports.awaiting' ? 'active' : '' }}">
                        <a href="{{ route('dland.reports.awaiting') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-hourglass-half"></i></span>
                            <span class="pcoded-mtext">Awaiting Approval</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $route == 'dland.reports.approved' ? 'active' : '' }}">
                        <a href="{{ route('dland.reports.approved') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-check"></i></span>
                            <span class="pcoded-mtext">Approved Reports</span>
                        </a>
                    </li>
                @endif



                {{-- MANAGE PROFILE --}}
                <li class="nav-item pcoded-hasmenu {{ $prefix == '/profile' ? 'active pcoded-trigger' : '' }}">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                        <span class="pcoded-mtext">Manage Profile</span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ $route == 'profile.view' ? 'active' : '' }}">
                            <a href="{{ route('profile.view') }}">Your Profile</a>
                        </li>
                        <li class="{{ $route == 'password.view' ? 'active' : '' }}">
                            <a href="{{ route('password.view') }}">Change Password</a>
                        </li>
                    </ul>
                </li>


                {{-- LOGOUT --}}
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link {{ $route == 'logout' ? 'active' : '' }}">
                        <span class="pcoded-micon"><i class="fa-solid fa-right-from-bracket"></i></span>
                        <span class="pcoded-mtext">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

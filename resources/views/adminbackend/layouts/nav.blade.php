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

                {{-- SUPERADMIN NAVIGATION --}}
                @if (Auth::user()->is_role == 0)
                    <li class="nav-item {{ $route == 'superadmin.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-display"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>

                    {{-- REPORTS --}}
                    {{-- <li class="nav-item pcoded-hasmenu {{ Request::is('superadmin/reports*') ? 'active pcoded-trigger' : '' }}">
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
                    </li> --}}

                    {{-- MAILS --}}
                    <li class="nav-item {{ $route == 'superadmin.mails' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.mails') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-envelope"></i></span>
                            <span class="pcoded-mtext">Mails</span>
                        </a>
                    </li>

                    {{-- SCHEDULER --}}
                    <li class="nav-item {{ $route == 'superadmin.scheduler' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.scheduler') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-calendar"></i></span>
                            <span class="pcoded-mtext">Scheduler</span>
                        </a>
                    </li>

                    {{-- PART ONE ORDERS --}}
                    <li class="nav-item {{ $route == 'superadmin.partone' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.partone') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-list"></i></span>
                            <span class="pcoded-mtext">Part One Orders</span>
                        </a>
                    </li>

                    {{-- OPERATIONS --}}
                    <li class="nav-item {{ $route == 'superadmin.operation' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.operation') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-diagram-project"></i></span>
                            <span class="pcoded-mtext">Operations</span>
                        </a>
                    </li>

                    {{-- BROADCAST --}}
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

                    {{-- SETTINGS --}}
                    <li class="nav-item {{ $route == 'superadmin.setting' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.setting') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-gears"></i></span>
                            <span class="pcoded-mtext">Settings</span>
                        </a>
                    </li>

                    {{-- DG SECTION FOR SUPERADMIN --}}
                    <li class="nav-header">
                        <span>DG Section</span>
                    </li>
                    
                    <li class="nav-item {{ $route == 'dg.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dg.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-user-tie"></i></span>
                            <span class="pcoded-mtext">DG Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $route == 'dg.reports.awaiting' ? 'active' : '' }}">
                        <a href="{{ route('dg.reports.awaiting') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-file-import"></i></span>
                            <span class="pcoded-mtext">DG - Awaiting Approval</span>
                        </a>
                    </li>

                    {{-- DLAND SECTION FOR SUPERADMIN --}}
                    <li class="nav-header">
                        <span>DLAND Section</span>
                    </li>
                    
                    <li class="nav-item {{ $route == 'dland.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dland.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-landmark"></i></span>
                            <span class="pcoded-mtext">DLAND Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $route == 'dland.reports.pending' ? 'active' : '' }}">
                        <a href="{{ route('dland.reports.pending') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-file"></i></span>
                            <span class="pcoded-mtext">DLAND - Pending Reports</span>
                        </a>
                    </li>

                    

                   


                    {{-- DOFFR SECTION FOR SUPERADMIN --}}
                    <li class="nav-header">
                        <span>Duty Officer Section</span>
                    </li>
                    
                    <li class="nav-item {{ $route == 'doffr.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('doffr.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-user-tie"></i></span>
                            <span class="pcoded-mtext">Duty Officer Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item pcoded-hasmenu {{ Request::is('doffr/reports*') ? 'active pcoded-trigger' : '' }}">
                        <a href="#!" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                            <span class="pcoded-mtext">Reports</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ Request::is('doffr/reports/dutyreport') ? 'active' : '' }}">
                                <a href="{{ route('doffr.reports.dutyreport') }}">Duty Report</a>
                            </li>
                            <li class="{{ Request::is('doffr/reports/dailysitrep') ? 'active' : '' }}">
                                <a href="{{ route('doffr.reports.dailysitrep') }}">Daily Sitrep</a>
                            </li>
                        </ul>
                    </li>

                {{-- DG NAVIGATION --}}
                @elseif (Auth::user()->is_role == 1)
                    <li class="nav-header">
                        <span>DG Section</span>
                    </li>
                    
                    <li class="nav-item {{ $route == 'dg.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dg.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-user-tie"></i></span>
                            <span class="pcoded-mtext">DG Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $route == 'dg.reports.awaiting' ? 'active' : '' }}">
                        <a href="{{ route('dg.reports.awaiting') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-file-import"></i></span>
                            <span class="pcoded-mtext">DG - Awaiting Approval</span>
                        </a>
                    </li>
                
                {{-- DLAND NAVIGATION --}}
                @elseif(Auth::user()->is_role == 2)
                    <li class="nav-header">
                        <span>DLAND Section</span>
                    </li>
                    
                    <li class="nav-item {{ $route == 'dland.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dland.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-landmark"></i></span>
                            <span class="pcoded-mtext">DLAND Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $route == 'dland.reports.pending' ? 'active' : '' }}">
                        <a href="{{ route('dland.reports.pending') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-file"></i></span>
                            <span class="pcoded-mtext">DLAND - Pending Reports</span>
                        </a>
                    </li>
{{-- 
                    <li class="nav-item {{ $route == 'dland.reports.awaiting' ? 'active' : '' }}">
                        <a href="{{ route('dland.reports.awaiting') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-hourglass-half"></i></span>
                            <span class="pcoded-mtext">DLAND - Awaiting Approval</span>
                        </a> --}}
                    </li>

                    <li class="nav-item {{ $route == 'dland.reports.approved' ? 'active' : '' }}">
                        <a href="{{ route('dland.reports.approved') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-check"></i></span>
                            <span class="pcoded-mtext">DLAND - Approved Reports</span>
                        </a>
                    </li>

                    @elseif (Auth::user()->is_role == 4)
                    <li class="nav-header">
                        <span>Duty Officer Section</span>
                    </li>
                    
                    <li class="nav-item {{ $route == 'doffr.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('doffr.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-user-tie"></i></span>
                            <span class="pcoded-mtext">Duty Officer Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item pcoded-hasmenu {{ Request::is('offr/reports*') ? 'active pcoded-trigger' : '' }}">
                        <a href="#!" class="nav-link">
                            <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
                            <span class="pcoded-mtext">Reports</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ Request::is('offr/reports/dutyreport') ? 'active' : '' }}">
                                <a href="{{ route('offr.reports.dutyreport') }}">Duty Report</a>
                            </li>
                            <li class="{{ Request::is('offr/reports/dailysitrep') ? 'active' : '' }}">
                                <a href="{{ route('offr.reports.dailysitrep') }}">Daily Sitrep</a>
                            </li>
                        </ul>
                    </li>
                @endif

                {{-- COMMON NAVIGATION ITEMS (Profile, Logout) --}}
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

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link {{ $route == 'logout' ? 'active' : '' }}">
                        <span class="pcoded-micon"><i class="feather icon-log-out"></i></span>
                        <span class="pcoded-mtext">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
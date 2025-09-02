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
                            <span class="pcoded-micon"><i class="fa-solid fa-display"></i></span>
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

                    <li class="nav-item {{ $route == 'superadmin.mails' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.mails') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-calendar"></i></span>
                            <span class="pcoded-mtext">Scheduler</span>
                        </a>
                    </li>
                    <li class="nav-item {{ $route == 'superadmin.mails' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.mails') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-list"></i></span>
                            <span class="pcoded-mtext">Part One Orders</span>
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



                    {{-- DASHBOARDS --}}
                @elseif(Auth::user()->is_role == 1)
                    <li class="nav-item {{ $route == 'director.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('director.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-display"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li>

                    {{-- LEAVE MANAGEMENT --}}
                    {{-- <li
                        class="nav-item pcoded-hasmenu {{ $prefix == 'director/leave' ? 'active pcoded-trigger' : '' }}">
                        <a href="#" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-database"></i></span>
                            <span class="pcoded-mtext">Leave Management</span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ $route == 'director.leave.requests' ? 'active' : '' }}">
                                <a href="{{ route('director.leave.requests') }}">Requested Leaves</a>
                            </li>
                            <li class="{{ $route == 'director.leave.view' ? 'active' : '' }}">
                                <a href="{{ route('director.leave.view') }}">Leave List</a>
                            </li>
                        </ul>
                    </li> --}}
                @elseif (Auth::user()->is_role == 2)
                    {{-- <li class="nav-item {{ $route == 'deputy_director.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('deputy_director.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-display"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li> --}}
                @elseif(Auth::user()->is_role == 3)
                    {{-- <li class="nav-item {{ $route == 'adminofficer.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('adminofficer.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-display"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li> --}}
                @elseif(Auth::user()->is_role == 4)
                    {{-- <li class="nav-item {{ $route == 'chief_clerk.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('chief_clerk.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-display"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li> --}}

                    {{-- USER MANAGEMENT --}}
                    {{-- <li class="{{ $route == 'chiefclerk.personnels.list' ? 'active' : '' }}">
                        <a href="{{ route('chiefclerk.personnels.list') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-users"></i></span>
                            <span class="pcoded-mtext">Personnels</span>
                        </a>

                    </li> --}}


                    {{-- LEAVE MANAGEMENT --}}


                    {{-- <li class="{{ $route == 'chiefclerk.leave.index' ? 'active' : '' }}">
                        <a href="{{ route('chiefclerk.leave.index') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-database"></i></span>
                            <span class="pcoded-mtext">Leave List</span>
                        </a>

                    </li> --}}
                @elseif(Auth::user()->is_role == 5)
                    {{-- <li class="nav-item {{ $route == 'cell_head.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('cell_head.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-display"></i></span>
                            <span class="pcoded-mtext">Dashboard</span>
                        </a>
                    </li> --}}
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
                <li class="nav-item {{ $route == 'superadmin.mails' ? 'active' : '' }}">
                    <a href="{{ route('superadmin.mails') }}" class="nav-link">
                        <span class="pcoded-micon"><i class="fa-solid fa-person-rifle"></i></span>
                        <span class="pcoded-mtext">Operations</span>
                    </a>
                </li>
                 <li class="nav-item {{ $route == 'superadmin.mails' ? 'active' : '' }}">
                    <a href="{{ route('superadmin.mails') }}" class="nav-link">
                        <span class="pcoded-micon"><i class="fa-solid fa-tower-broadcast"></i></span>
                        <span class="pcoded-mtext">Broadcast</span>
                    </a>
                </li>
                 <li class="nav-item {{ $route == 'superadmin.mails' ? 'active' : '' }}">
                    <a href="{{ route('superadmin.mails') }}" class="nav-link">
                        <span class="pcoded-micon"><i class="fa-solid fa-gears"></i></span>
                        <span class="pcoded-mtext">Settings</span>
                    </a>
                </li>

                {{-- LOGOUT --}}
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

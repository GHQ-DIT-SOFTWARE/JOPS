<li class="nav-item {{ $route == 'superadmin.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('superadmin.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-desktop"></i></span>
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
                    <li class="nav-item {{ $route == 'duty-roster.index' ? 'active' : '' }}">
                        <a href="{{ route('duty-roster.index') }}" class="nav-link">
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

                 
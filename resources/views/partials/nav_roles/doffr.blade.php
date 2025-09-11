 <li class="nav-item {{ $route == 'doffr.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('doffr.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-user-tie"></i></span>
                            <span class="pcoded-mtext">Duty Officer Dashboard</span>
                        </a>
                    </li>

                    <li
                        class="nav-item pcoded-hasmenu {{ Request::is('doffr/reports*') ? 'active pcoded-trigger' : '' }}">
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
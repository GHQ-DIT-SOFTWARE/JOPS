<li class="nav-item {{ $route == 'dland.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dland.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-landmark"></i></span>
                            <span class="pcoded-mtext">DLAND Dashboard</span>
                        </a>
                    </li>

                   


                    <li class="nav-item pcoded-hasmenu {{ Request::is('dland/reports*') ? 'active pcoded-trigger' : '' }}">
    <a href="#!" class="nav-link">
        <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
        <span class="pcoded-mtext">Reports</span>
    </a>
    <ul class="pcoded-submenu">
        <li class="{{ Request::is('dland/reports/all') ? 'active' : '' }}">
            <a href="{{ route('dland.reports.all') }}">All Reports</a>
        </li>
        <li class="{{ Request::is('dland/reports/awaiting-approval') ? 'active' : '' }}">
            <a href="{{ route('dland.reports.awaiting') }}">Awaiting DG Approval</a>
        </li>
        <li class="{{ Request::is('dland/reports/approved') ? 'active' : '' }}">
            <a href="{{ route('dland.reports.approved') }}">Approved Reports</a>
        </li>
    </ul>
</li>
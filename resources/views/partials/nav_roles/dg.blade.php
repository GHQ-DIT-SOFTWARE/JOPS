

                    <li class="nav-item {{ $route == 'dg.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dg.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-user-tie"></i></span>
                            <span class="pcoded-mtext">DG Dashboard</span>
                        </a>
                    </li>

                    {{-- REPORTS --}}
<li class="nav-item pcoded-hasmenu {{ Request::is('dg/reports*') ? 'active pcoded-trigger' : '' }}">
    <a href="#!" class="nav-link">
        <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
        <span class="pcoded-mtext">Reports</span>
    </a>
    <ul class="pcoded-submenu">
        <li class="{{ Request::is('dg/reports/all') ? 'active' : '' }}">
            <a href="{{ route('dg.reports.all') }}">All Reports</a>
        </li>
        <li class="{{ Request::is('dg/reports/awaiting-approval') ? 'active' : '' }}">
            <a href="{{ route('dg.reports.awaiting') }}">Awaiting DG Approval</a>
        </li>
        <li class="{{ Request::is('dg/reports/approved') ? 'active' : '' }}">
            <a href="{{ route('dg.reports.approved') }}">Approved Reports</a>
        </li>
    </ul>
</li>


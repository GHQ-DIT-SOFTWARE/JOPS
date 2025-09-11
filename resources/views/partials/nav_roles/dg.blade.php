

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

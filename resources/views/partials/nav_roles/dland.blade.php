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
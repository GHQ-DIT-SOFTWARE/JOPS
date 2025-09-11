<li class="nav-item {{ $route == 'dclerk.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('dclerk.dashboard') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-clipboard-check"></i></span>
                            <span class="pcoded-mtext">D Clerk Dashboard</span>
                        </a>
                    </li>

                    {{-- <li class="nav-item {{ $route == 'dclerk.roster.view' ? 'active' : '' }}">
                        <a href="{{ route('dclerk.roster.view') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-calendar-days"></i></span>
                            <span class="pcoded-mtext">Duty Roster</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $route == 'dclerk.accounts' ? 'active' : '' }}">
                        <a href="{{ route('dclerk.accounts') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-user-plus"></i></span>
                            <span class="pcoded-mtext">Manage Accounts</span>
                        </a>
                    </li> --}}

                    <li class="nav-item {{ $route == 'dclerk.password-list' ? 'active' : '' }}">
                        <a href="{{ route('dclerk.password-list') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-user-plus"></i></span>
                            <span class="pcoded-mtext">Manage password-list</span>
                        </a>
                    </li> 

                    {{-- <li class="nav-item {{ $route == 'dclerk.communication' ? 'active' : '' }}">
                        <a href="{{ route('dclerk.communication') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-envelope"></i></span>
                            <span class="pcoded-mtext">Officer Communication</span>
                        </a>
                    </li> --}}

                    {{-- <li class="nav-item {{ $route == 'dclerk.reports' ? 'active' : '' }}">
                        <a href="{{ route('dclerk.reports') }}" class="nav-link">
                            <span class="pcoded-micon"><i class="fa-solid fa-file-lines"></i></span>
                            <span class="pcoded-mtext">Account Reports</span>
                        </a>
                    </li> --}}
<li class="nav-item {{ request()->routeIs('personnel.dashboard') ? 'active' : '' }}">
    <a href="{{ route('personnel.dashboard') }}" class="nav-link">
        <span class="pcoded-micon"><i class="fa-solid fa-tachometer-alt"></i></span>
        <span class="pcoded-mtext">Dashboard</span>
    </a>
</li>

<li class="{{ request()->routeIs('personnel.leave.*') ? 'active' : '' }}">
    <a href="{{ route('personnel.leave.index') }}" class="nav-link">
        <span class="pcoded-micon"><i class="fa-solid fa-calendar-check"></i></span>
        <span class="pcoded-mtext">My Leave Requests</span>
    </a>
</li>

<li class="{{ request()->routeIs('personnel.myprofile.view') ? 'active' : '' }}">
    <a href="{{ route('personnel.myprofile.view') }}" class="nav-link">
        <span class="pcoded-micon"><i class="fa-solid fa-user"></i></span>
        <span class="pcoded-mtext">My Profile</span>
    </a>
</li>

<li class="nav-item pcoded-hasmenu {{ $prefix == '/profile' ? 'active pcoded-trigger' : '' }}">
    <a href="#!" class="nav-link">
        <span class="pcoded-micon"><i class="fa-solid fa-user-cog"></i></span>
        <span class="pcoded-mtext">Manage Profile</span>
    </a>
    <ul class="pcoded-submenu">
        <li class="{{ $route == 'password.view' ? 'active' : '' }}">
            <a href="{{ route('password.view') }}">
                <i class="fa-solid fa-key mr-2"></i> Change Password
            </a>
        </li>
    </ul>
</li>
<li class="nav-item pcoded-hasmenu {{ request()->is('profile*') ? 'active pcoded-trigger' : '' }}">
    <a href="#" class="nav-link">
        <span class="pcoded-micon"><i class="fa-solid fa-user-cog"></i></span>
        <span class="pcoded-mtext">Manage Profile</span>
    </a>
    <ul class="pcoded-submenu">
        <li><a href="{{ route('profile.view') }}"><i class="fa-solid fa-id-badge mr-2"></i> Your Profile</a></li>
        <li><a href="{{ route('password.view') }}"><i class="fa-solid fa-key mr-2"></i> Change Password</a></li>
    </ul>
</li>

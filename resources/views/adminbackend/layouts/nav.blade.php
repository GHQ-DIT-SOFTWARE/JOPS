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

                {{-- SUPERADMIN NAVIGATION --}}
                @if (Auth::user()->is_role == 0)
                    
                @include('partials.nav_roles.superadmin_consolidated')

               
                    <li class="nav-header">
                        <span>DG Section</span>
                    </li>
                @include('partials.nav_roles.dg')
               
                    <li class="nav-header">
                        <span>D Land Section</span>
                    </li>
                @include('partials.nav_roles.dland')
               
                    <li class="nav-header">
                        <span>D Officer Section</span>
                    </li>
                @include('partials.nav_roles.doffr')
               
                    <li class="nav-header">
                        <span>D Clerk Section</span>
                    </li>
                @include('partials.nav_roles.dclerk')
                @elseif(Auth::user()->is_role == 1)
                    @include('partials.nav_roles.dg')
                @elseif(Auth::user()->is_role == 2)
                    @include('partials.nav_roles.dland')
                @elseif(Auth::user()->is_role == 4)
                    @include('partials.nav_roles.doffr')
                @elseif(Auth::user()->is_role == 5)
                    @include('partials.nav_roles.dclerk')

                @endif

                {{-- COMMON NAVIGATION ITEMS (Profile, Logout) --}}
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

                <!-- Add to your navigation menu -->
                {{-- @if (Auth::check() && Auth::user()->canAccessDutyRoster())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('duty-roster.index') }}">
                            <i class="bi bi-calendar-event"></i> Duty Roster
                        </a>
                    </li>
                @endif --}}

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link {{ $route == 'logout' ? 'active' : '' }}">
                        <span class="pcoded-micon"><i class="fa-solid fa-right-from-bracket"></i></span>
                        <span class="pcoded-mtext">Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>

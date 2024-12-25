<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <div class="container-fluid">
        <!-- Logo -->
        <a href="/" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <img src="{{ asset('assets') }}/img/logo.png" height="70px" width="100px">
        </a>

        <!-- Toggler for Mobile -->
        <button
            type="button"
            class="navbar-toggler me-4"
            data-bs-toggle="collapse"
            data-bs-target="#navbarCollapse"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links and Auth -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mx-auto p-4 p-lg-0">
                <li class="nav-item">
                    <a href="/" class="nav-link @yield('index-active')">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rentals.showRentals') }}" class="nav-link @yield('rent-active')">Rents</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('UserNewsletters.index') }}" class="nav-link @yield('team-active')">Newsletters</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('events.UserIndex') }}" class="nav-link @yield('event-active')">Events</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('theme.about') }}" class="nav-link @yield('about-active')">About</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.showContact') }}" class="nav-link @yield('contact-active')">Contact</a>
                </li>
            </ul>

            <!-- Right-Aligned Auth Section -->
            @guest
                <form action="{{ route('login') }}" method="GET" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
                        Login<i class="fa fa-arrow-right ms-3"></i>
                    </button>
                </form>
            @endguest
            @auth
                <div class="d-flex align-items-center">
                    <!-- Profile Image with Hover Dropdown -->
                    <div class="dropdown profile-dropdown">
                        <a href="#" class="d-inline-block me-3" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img
                                src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('assets')}}/img/defaultUser.png"
                                alt="Profile Image"
                                class="rounded-circle"
                                style="width: 40px; height: 40px; object-fit: cover; cursor: pointer;"
                            >
                        </a>
                        <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>

<style>
    /* Prevent horizontal scrolling when hovering over the profile photo dropdown */
    .navbar-nav {
        overflow-x: hidden;
    }

    .dropdown-menu-start {
        left: auto;
        right: 0;
    }

    .profile-dropdown {
        position: relative;
    }
</style>

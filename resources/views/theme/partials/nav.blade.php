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
            <!-- Center Navbar Links -->
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
                    <!-- Profile Image -->
                    <a href="{{ route('profile') }}" class="d-inline-block me-3">
                        <img
                            src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('assets')}}/img/defaultUser.png"
                            alt="Profile Image"
                            class="rounded-circle"
                            style="width: 40px; height: 40px; object-fit: cover; cursor: pointer;"
                        >
                    </a>

                    <!-- Logout Button Inside -->
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button
                            type="submit"
                            class="btn  btn-sm rounded-pill px-3 py-1 W-50"
                        >
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>

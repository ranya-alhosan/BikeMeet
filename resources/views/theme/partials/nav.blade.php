<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="/" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <img src="{{ asset('assets') }}/img/logo.png" height="70px" width="100px">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="/" class="nav-item nav-link @yield('index-active')">Home</a>
            <a href="{{ route('rentals.showRentals') }}" class="nav-item nav-link @yield('rent-active')">Rents</a>
            <a href="{{ route('theme.team') }}" class="nav-item nav-link @yield('team-active')">Newsletters</a>
            <a href="{{ route('events.UserIndex') }}" class="nav-item nav-link @yield('event-active')">Events</a>
            <a href="{{ route('theme.about') }}" class="nav-item nav-link @yield('about-active')">About</a>
            <a href="{{ route('user.showContact') }}" class="nav-item nav-link @yield('contact-active')">Contact</a>
        </div>

        @guest
            <form action="{{ route('login') }}" method="GET" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
                    Login<i class="fa fa-arrow-right ms-3"></i>
                </button>
            </form>
        @endguest

        @auth
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
                    Logout<i class="fa fa-arrow-right ms-3"></i>
                </button>
            </form>
        @endauth


    </div>
</nav>

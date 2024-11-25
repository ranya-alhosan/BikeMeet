<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BikeMeet</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #e05100;
            --secondary: #008FE0;
            --light: #F2F2F2;
            --dark: #111111;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: var(--dark);
            color: var(--light);
            padding-top: 20px;
        }

        .sidebar .nav-link {
            color: var(--light);
            display: flex;
            align-items: center;
            padding: 10px 15px;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .sidebar .nav-link:hover {
            background-color: var(--primary);
            color: white;
        }

        .content-wrapper {
            margin-left: 250px;
            padding: 20px;
        }

        .navbar-brand {
            color: var(--light) !important;
            font-weight: bold;
            padding: 15px;
            text-align: center;
            width: 100%;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow-x: hidden;
                transition: 0.3s;
            }

            .content-wrapper {
                margin-left: 0;
            }

            .sidebar.active {
                width: 250px;
            }

            .mobile-toggle {
                display: block !important;
            }
        }

        .mobile-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1000;
            background: none;
            border: none;
            color: var(--dark);
        }
    </style>
</head>

<body>
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list" style="font-size: 2rem;"></i>
    </button>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <img src="{{ asset('assets') }}/img/logo-dashboard.png" height="150px" width="250px">
        <ul class="nav flex-column">
            <li class="nav-item  ">
                <a class="nav-link @yield('home-active')" href="/dashboard">
                    <i class="bi bi-house"></i> Home
                </a>
            </li>
            <a class="nav-link @yield('users-active')" href="{{ route('users.index') }}">
                <i class="fa-solid fa-user"></i> Users
            </a>

            <li class="nav-item">
                <a class="nav-link @yield('events-active')" href="{{ route('events.index') }}">
                    <i class="bi bi-calendar-event"></i> Events
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link @yield('rents-active')" href="{{ route('rentals.index') }}">
                    <i class="fas fa-motorcycle"></i>Rent Motorcycles
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @yield('news-active')" href="{{ route('newsletters.index') }}">
                    <i class="bi bi-newspaper"></i> News
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @yield('news-active')" href="{{ route('contacts.index') }}">
                    <i class="fa-solid fa-address-book"></i> Contacts
                </a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <a class="nav-link" href="#"
                        onclick="document.getElementById('logout-form').submit(); return false;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </form>
            </li>



        </ul>
    </div>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        @yield('content')
        @yield('scripts')

    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
        }
    </script>
</body>

</html>

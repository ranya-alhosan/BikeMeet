@extends('theme.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <!-- Left Side: Profile Image and Info -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4 d-flex justify-content-center mb-4">
                        <!-- Profile Image -->
                        <img
                            src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('assets')}}/img/users.png"
                            alt="Profile Image"
                            class="rounded-circle shadow"
                            style="width: 150px; height: 150px; object-fit: cover;"
                        >
                    </div>
                    <div class="col-md-8 info-user">
                        <!-- Hero Section -->
                        <div class="user-info">
                            <h1 class="mb-3">{{ $user->name }}</h1>
                            <p class="text-muted mb-2">
                                <strong>Email:</strong> {{ $user->email }}
                            </p>
                            <p class="text-muted mb-4">
                                <strong>Joined:</strong> {{ $user->created_at->format('F d, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Menu -->
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Profile Menu</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ route('UserProfile.edit') }}" class="d-block text-dark py-2 menu-item">
                                    <i class="fas fa-user-edit"></i> Edit Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('UserMotorcycles.index') }}" class="d-block text-dark py-2 menu-item">
                                    <i class="fas fa-motorcycle"></i> Motorcycles
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('events.UserIndex') }}" class="d-block text-dark py-2 menu-item">
                                    <i class="fas fa-calendar-alt"></i> Events
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ProfNewsletters.index') }}" class="d-block text-dark py-2 menu-item">
                                    <i class="fas fa-newspaper"></i> Newsletters
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-link d-block text-dark py-2 w-100 menu-item">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    /* Profile Page Styling */
    .container-fluid {
        font-family: 'Poppins', sans-serif;
    }

    .info-user {
        margin-top: -50px;
    }

    /* Profile Image */
    img.rounded-circle {
        border: 4px solid #007bff;
        margin-top: -120px;
        transition: transform 0.3s ease-in-out, border-color 0.3s ease-in-out;
    }

    img.rounded-circle:hover {
        transform: scale(1.1);
        border-color: #0056b3;
    }

    /* Hero Section Text */
    h1 {
        font-weight: bold;
        color: #333;
    }

    .text-muted {
        font-size: 0.95rem;
        color: #6c757d;
    }



    /* Card Styling for Menu */
    .card {
        border-radius: 12px;
        border: none;
    }

    .card-header {
        border-radius: 12px 12px 0 0;
    }

    /* Menu Item Styling */
    .menu-item {
        font-size: 1rem;
        text-decoration: none;
        padding: 12px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .menu-item:hover {
        background-color: #f0f0f0;
    }

    .card-body a {
        display: block;
    }

    .list-unstyled {
        padding-left: 0;
    }
</style>

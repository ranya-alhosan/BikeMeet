@extends('theme.master')

@section('hero-title', 'Events')
@section('event-active', 'active')

@section('content')
    <div class="container">
        <!-- Title and Add Event Button Inline -->
        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <h1>Events</h1>
            @if(auth()->check())
                <!-- Authenticated users -->
                <a href="{{ route('UserEvents.create') }}" class="text-primary fs-4" title="Add New Event">
                    <i class="fas fa-plus"></i>
                </a>
            @else
                <!-- Guests -->
                <a href="javascript:void(0);" class="text-primary fs-4" title="Add New Event" onclick="showLoginAlert()">
                    <i class="fas fa-plus"></i>
                </a>
            @endif

            <script>
                function showLoginAlert() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Login First',
                        text: 'You need to login before adding a new event.',
                        confirmButtonText: 'OK'
                    });
                }
            </script>

        </div>

        <!-- Filter Form -->
        <form action="{{ route('events.UserIndex') }}" method="GET" class="mb-4">
            <div class="row">
                <!-- Search Input -->
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search events" value="{{ request()->query('search') }}">
                </div>

                <!-- Filter by Status -->
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Filter by Status</option>
                        <option value="upcoming" {{ request()->query('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="completed" {{ request()->query('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>

                <!-- Filter by Location -->
                <div class="col-md-3">
                    <select name="location" class="form-select">
                        <option value="">Filter by Location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location }}" {{ request()->query('location') == $location ? 'selected' : '' }}>{{ $location }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Apply Filters Button -->
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100 d-flex justify-content-center">Filters</button>
                </div>

                <!-- Clear Filters Button -->
                <div class="col-md-1">
                    <a href="{{ route('events.UserIndex') }}" class="btn btn-secondary w-100 d-flex justify-content-center">Clear</a>
                </div>
            </div>
        </form>

        <!-- Event Cards -->
        @if($events->isEmpty())
            <p>No events available at the moment.</p>
        @else
            <div class="row">
                @foreach($events as $event)
                    <div class="col-md-4 mb-4">
                        <div class="card event-card h-100"> <!-- Add 'event-card' and 'h-100' -->
                            <div class="card-body d-flex flex-column"> <!-- Use flexbox for layout -->
                                <h5 class="card-title">{{ $event->name }}</h5>
                                <p class="card-text">
                                    <strong>Location:</strong> {{ $event->location }}<br>
                                    <strong>Organizer:</strong> {{ $event->user->name ?? 'Unknown' }}<br>
                                    <strong>Enrollments:</strong> {{ $event->enrollments_count }}<br>
                                    @if($event->status === 'upcoming')
                                        <strong>Status:</strong>
                                        <span class="text-success">Active</span>
                                    @else
                                        <span class="text-danger">See you soon</span>
                                    @endif
                                </p>
                                <div class="mt-auto"> <!-- Push the button to the bottom -->
                                    <a href="{{ route('events.showEventDetails', $event->id) }}" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
    <style>
        .event-card {
            height: 100%; /* Ensures cards stretch to match the tallest card */
        }
        .event-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Ensures spacing is even */
        }
    </style>
@endsection

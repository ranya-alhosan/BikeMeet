@extends('dashboard.layout')

@section('events-active', 'active')

@section('content')
    <div class="container my-4">
        <!-- Display Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



        <!-- Title and Add Event Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Event Management</h1>
            <a href="{{ route('events.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Event
            </a>
        </div>
        <hr>
        <!-- Filter Form -->
        <form action="{{ route('events.index') }}" method="GET" class="mb-4 mt-4" id="filter-form">
            <div class="row">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All</option>
                        <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="name" class="form-label">Event Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Search event name" value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <label for="organizer" class="form-label">Organizer</label>
                    <input type="text" name="organizer" id="organizer" class="form-control" placeholder="Search organizer" value="{{ request('organizer') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <!-- Clear Button -->
                    <button type="button" class="btn btn-secondary ms-2" onclick="clearFilters()">Clear</button>
                </div>
            </div>
        </form>
        <!-- Event Table -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Organizer</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Enrollments</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($events as $event)
                    <tr>
                        <td>{{ $event->user->name ?? 'Unknown' }}</td>
                        <td class="text-nowrap">{{ $event->name }}</td>
                        <td>
                            <span class="badge {{ $event->status === 'upcoming' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        <td class="text-center">{{ $event->enrollments_count }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#eventDetailsModal" onclick="showEventDetails({{ $event->id }})">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No events available.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Event Details Modal -->
    <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventDetailsModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="event-details-content">
                        <!-- Event details will be injected here via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showEventDetails(eventId) {
            fetch(`/events/${eventId}`)
                .then(response => response.json())
                .then(data => {
                    const event = data.event;
                    // Create an unordered list of enrolled users
                    const enrollmentsList = event.enrollments.map(enrollment => {
                        return `<li>${enrollment.user ? enrollment.user.name : 'Unknown'}</li>`;
                    }).join('');

                    const eventDetails = `
                        <h4>${event.name}</h4>
                        <p><strong>Organizer:</strong> ${event.organizer}</p>
                        <p><strong>Description:</strong> ${event.description}</p>
                        <p><strong>Location:</strong> ${event.location}</p>
                        <p><strong>Start Date:</strong> ${new Date(event.start_date).toLocaleString()}</p>
                        <p><strong>End Date:</strong> ${new Date(event.end_date).toLocaleString()}</p>
                        <p><strong>Fee:</strong> ${event.fee ? '$' + event.fee : 'Free'}</p>
                        <p><strong>Status:</strong> ${event.status}</p>
                        <p><strong>Enrollments:</strong> ${event.enrollments_count}</p>
                        <p><strong>Enrolled Users:</strong></p>
                        <ul>${enrollmentsList}</ul>
                    `;
                    document.getElementById('event-details-content').innerHTML = eventDetails;
                })
                .catch(error => console.error('Error fetching event details:', error));
        }

        // Clear Filters
        function clearFilters() {
            document.getElementById('filter-form').reset();
            window.location.href = "{{ route('events.index') }}"; // Redirect to the unfiltered page
        }
    </script>
@endsection

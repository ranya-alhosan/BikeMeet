@extends('theme.master')
@section('hero-title', 'User Event')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <style>
        .custom-alert {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>


    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>My Events</h1>
            <!-- Add New Event Button -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                Add New Event
            </button>
        </div>
        <!-- Add Event Modal -->
        <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Event Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <input type="text" class="form-control" id="location" name="location" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date</label>
                                        <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fee">Fee</label>
                                        <input type="number" class="form-control" id="fee" name="fee">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="upcoming">Upcoming</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="description">Event Description</label>
                                        <textarea class="form-control" id="description" name="description" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Add Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @if($events->isEmpty())
            <div class="alert alert-info">
                You haven't enrolled in or created any events yet.
            </div>
        @else
            <div class="row">
                @foreach($events as $event)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">{{ $event->name }}</h5>
                                    <div class="dropdown">
                                        <button class="btn btn-link text-dark p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h fs-5"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="dropdownMenuButton">
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editEventModal-{{ $event->id }}">Edit Event</a></li>
                                            <!-- View Enrollments Option -->
                                            <li>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#viewEnrollmentsModal-{{ $event->id }}">View Enrollments</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" onclick="deleteEvent({{ $event->id }})">
                                                    Delete Event
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <p class="card-text">{{ $event->description }}</p>
                                <p class="card-text"><strong>Location:</strong> {{ $event->location }}</p>
                                <p class="card-text"><strong>Start Date:</strong> {{ $event->start_date->format('d M, Y') }}</p>
                                <p class="card-text"><strong>End Date:</strong> {{ $event->end_date->format('d M, Y') }}</p>
                                <p class="card-text"><strong>Status</strong> {{ $event->status }}</p>
                                <p class="card-text"><strong>Fee</strong> {{ $event->fee }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- View Enrollments Modal -->
                    <div class="modal fade" id="viewEnrollmentsModal-{{ $event->id }}" tabindex="-1" aria-labelledby="viewEnrollmentsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewEnrollmentsModalLabel">Enrollments for Event: {{ $event->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if($event->enrollments->isEmpty())
                                        <div class="alert alert-info">No enrollments found for this event.</div>
                                    @else
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($event->enrollments as $index => $enrollment)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $enrollment->user->name }}</td>
                                                    <td>{{ $enrollment->user->email }}</td>
                                                    <td>
                                        <span class="badge bg-{{ $enrollment->status == 'pending' ? 'warning' : ($enrollment->status == 'enrolled' ? 'primary' : 'success') }}">
                                            {{ ucfirst($enrollment->status) }}
                                        </span>
                                                    </td>
                                                    <td>
                                                        <!-- Change Status Dropdown -->
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="statusDropdown-{{ $enrollment->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Change Status
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="statusDropdown-{{ $enrollment->id }}">
                                                                <li>
                                                                    <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="status" value="pending">
                                                                        <button class="dropdown-item" type="submit">Pending</button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="status" value="enrolled">
                                                                        <button class="dropdown-item" type="submit">Enrolled</button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('enrollments.update', $enrollment->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="status" value="completed">
                                                                        <button class="dropdown-item" type="submit">Completed</button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Pagination Links -->

                    <!-- Edit Event Modal -->
                    <div class="modal fade" id="editEventModal-{{ $event->id }}" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editEventModalLabel">Edit Event: {{ $event->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Event Name and Event Description inside Each Other -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Event Name</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $event->name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="description">Event Description</label>
                                                    <textarea class="form-control" id="description" name="description">{{ $event->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Location and Fee inside Each Other -->
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="location">Location</label>
                                                    <input type="text" class="form-control" id="location" name="location" value="{{ $event->location }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fee">Fee</label>
                                                    <input type="number" class="form-control" id="fee" name="fee" value="{{ $event->fee }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Start Date and End Date inside Each Other -->
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="start_date">Start Date</label>
                                                    <input type="datetime-local" class="form-control" id="start_date" name="start_date" value="{{ $event->start_date->format('Y-m-d\TH:i') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="end_date">End Date</label>
                                                    <input type="datetime-local" class="form-control" id="end_date" name="end_date" value="{{ $event->end_date->format('Y-m-d\TH:i') }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="form-group mt-3">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="upcoming" {{ $event->status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                                <option value="completed" {{ $event->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-3">Update Event</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        @endif
        <div class="d-flex justify-content-center mt-4">
            {{ $events->links() }}
        </div>
    </div>

    <!-- Add Bootstrap 5 JS (if not already included in your layout) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteEvent(eventId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the event and all related enrollments!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send a DELETE request to the server
                fetch(`/events/${eventId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', data.message, 'success')
                                .then(() => {
                                    // Reload the page or update the event list dynamically
                                    location.reload();
                                });
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Something went wrong!', 'error');
                    });
            }
        });
    }
</script>

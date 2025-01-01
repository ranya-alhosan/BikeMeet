@extends('theme.master')

@section('hero-title', $event->name)
@section('event-active', 'active')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Event Details Card -->
            <div class="col-lg-8 offset-lg-2">
                <div class="card shadow-lg rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5><strong>Organizer:</strong> {{ $event->user->name ?? 'Unknown' }}</h5>
                                <p><strong>Status:</strong>
                                    @if($event->status === 'upcoming')
                                        <span class="text-success">Active</span>
                                    @elseif($event->status === 'completed')
                                        <span class="text-danger">Completed</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h5><strong>Fee:</strong> ${{ number_format($event->fee, 2) }}</h5>
                                <p><strong>Location:</strong> {{ $event->location }}</p>
                            </div>
                        </div>

                        <hr>

                        <h5><strong>Description:</strong></h5>
                        <p>{{ $event->description }}</p>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Start Date:</strong> {{ $event->start_date->format('F j, Y, g:i a') }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <p><strong>End Date:</strong> {{ $event->end_date->format('F j, Y, g:i a') }}</p>
                            </div>
                        </div>

                        <!-- Buttons Section -->
                        <div class="text-center mt-4">
                            @if(auth()->check() && $event->status !== 'completed') <!-- Ensure user is logged in and event is not completed -->
                            @if($event->user_id !== auth()->id()) <!-- Check if the logged-in user is not the event creator -->
                            <form action="{{ route('events.enroll', $event->id) }}" method="POST" id="enrollForm" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg" id="enrollBtn">
                                    Enroll
                                </button>
                            </form>
                            @else
                                <p class="text-warning">You are the organizer of this event and cannot enroll.</p>
                            @endif
                            @else
                                @if($event->status === 'completed')
                                    <p class="text-danger">This event is completed and no longer accepting enrollments.</p>
                                @else
                                    <p class="text-danger">Please log in to enroll.</p>
                                @endif
                            @endif
                            <!-- Back to Events Button -->
                            <a href="{{ route('events.UserIndex') }}" class="btn btn-secondary btn-lg ms-2">
                                Back to Events
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <script>
        document.getElementById('enrollBtn')?.addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to enroll in this event?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, enroll me!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('enrollForm').submit();
                }
            });
        });

        // Display SweetAlert success message if there's a success session message
        @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
        @endif

        // Display SweetAlert error message if there's an error session message
        @if(session('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        @endif
    </script>
@endsection


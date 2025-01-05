@extends('theme.master')
@section('hero-title', 'User Enrolled Events')

@section('content')
    <div class="container mt-5">
        <h1>Enrolled Events</h1>

        @if($enrolledEvents->isEmpty())
            <div class="alert alert-info">
                You haven't enrolled in any events yet.
            </div>
        @else
            <div class="row">
                @foreach($enrolledEvents as $event)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->name }}</h5>
                                <p class="card-text">{{ $event->description }}</p>
                                <p class="card-text"><strong>Location:</strong> {{ $event->location }}</p>
                                <p class="card-text"><strong>Start Date:</strong> {{ $event->start_date->format('d M, Y') }}</p>
                                <p class="card-text"><strong>End Date:</strong> {{ $event->end_date->format('d M, Y') }}</p>

                                <p class="card-text">
                                    <strong>Enrollment Status:</strong>
                                    @php
                                        $enrollment = $event->enrollments->where('user_id', auth()->id())->first();
                                    @endphp
                                    <span class="badge bg-{{ $enrollment->status == 'pending' ? 'warning' : ($enrollment->status == 'enrolled' ? 'primary' : 'success') }}">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                </p>

                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary">View Event</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

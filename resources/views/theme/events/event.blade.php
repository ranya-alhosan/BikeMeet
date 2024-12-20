@extends('theme.master')

@section('hero-title', 'Events')
@section('event-active', 'active')

@section('content')
    <div class="container">
        <h1 class="mt-4">Events</h1>

        @if($events->isEmpty())
            <p>No events available at the moment.</p>
        @else
            <div class="row">
                @foreach($events as $event)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $event->name }}</h5>
                                <p class="card-text">
                                    <strong>Description:</strong> {{ Str::limit($event->description, 100) }}<br>
                                    <strong>Location:</strong> {{ $event->location }}<br>
                                    <strong>Start Date:</strong> {{ $event->start_date->format('F j, Y, g:i a') }}<br>
                                    <strong>End Date:</strong> {{ $event->end_date->format('F j, Y, g:i a') }}<br>
                                    <strong>Fee:</strong> ${{ number_format($event->fee, 2) }}<br>
                                    <strong>Organizer:</strong> {{ $event->user->name ?? 'Unknown' }}
                                </p>
                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

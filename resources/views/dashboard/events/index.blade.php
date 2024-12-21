@extends('dashboard.layout')

@section('events-active', 'active')

@section('content')
    <div class="container my-4">
        <!-- Title and Add Event Button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Event Management</h1>
            <a href="{{ route('events.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Event
            </a>
        </div>

        <!-- Event Table -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-light">
                <tr>
                    <th>Organizer</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Fee</th>
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
                        <td>{{ Str::limit($event->description, 50) }}</td>
                        <td class="text-nowrap">{{ $event->location }}</td>
                        <td class="text-nowrap">{{ $event->start_date->format('F j, Y, g:i a') }}</td>
                        <td class="text-nowrap">{{ $event->end_date->format('F j, Y, g:i a') }}</td>
                        <td class="text-nowrap">{{ $event->fee ? '$' . number_format($event->fee, 2) : 'Free' }}</td>
                        <td>
                            <span class="badge {{ $event->status === 'upcoming' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        <td class="text-center">{{ $event->enrollments_count }}</td>
                        <td>
                            <div class="d-flex gap-2">
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
@endsection

@extends('dashboard.layout')

@section('events-active', 'active')

@section('content')
<div class="container">
    <h1>Event Management</h1>
    <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Create New Event</a>
    <table class="table table-bordered">
        <thead>
            <tr>
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
            @foreach ($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ Str::limit($event->description, 50) }}</td>
                    <td>{{ $event->location }}</td>
                    <td>{{ $event->start_date }}</td>
                    <td>{{ $event->end_date }}</td>
                    <td>{{ $event->fee ?? 'Free' }}</td>
                    <td>{{ ucfirst($event->status) }}</td>
                    <td>{{ $event->enrollments_count }}</td>
                    <td>
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

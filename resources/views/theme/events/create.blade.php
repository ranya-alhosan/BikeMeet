@extends('theme.master')

@section('hero-title', 'Create Event')
@section('event-active', 'active')

@section('content')
    <div class="container">
        <h1 class="mt-4">Create New Event</h1>

        <form action="{{ route('events.UserStore') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Event Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="datetime-local" name="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="datetime-local" name="end_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="fee">Fee</label>
                <input type="number" name="fee" class="form-control" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-control" required>
                    <option value="upcoming">Upcoming</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Event</button>
        </form>
    </div>
@endsection

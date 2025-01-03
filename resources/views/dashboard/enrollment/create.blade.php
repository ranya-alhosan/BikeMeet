@extends('dashboard.layout')

@section('content')
    <div class="container my-4">
        <h1 class="h3">Add Enrollment</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('enrollment.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="user_id" class="form-label">User</label>
                <select id="user_id" name="user_id" class="form-select" required>
                    <option value="" disabled selected>Select a user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="event_id" class="form-label">Event</label>
                <select id="event_id" name="event_id" class="form-select" required>
                    <option value="" disabled selected>Select an event</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select" required>
                    <option value="pending">Pending</option>
                    <option value="enrolled">enrolled</option>
                    <option value="completed">completed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Enrollment</button>
        </form>
    </div>
@endsection

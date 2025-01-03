@extends('dashboard.layout')

@section('content')
    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Enrollment Management</h1>
            <a href="{{ route('enrollment.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Enrollment
            </a>
        </div>


    @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Filter Form -->
        <form action="{{ route('enrollment.index') }}" method="GET" class="mb-4 mt-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="user" class="form-label">User Name</label>
                    <input type="text" name="user" id="user" class="form-control" placeholder="Search by user" value="{{ request('user') }}">
                </div>
                <div class="col-md-3">
                    <label for="event" class="form-label">Event Name</label>
                    <input type="text" name="event" id="event" class="form-control" placeholder="Search by event" value="{{ request('event') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('enrollment.index') }}" class="btn btn-secondary ms-2">Clear</a>
                </div>
            </div>
        </form>
       <hr>



        <!-- Enrollment Table -->
        <table class="table table-hover table-bordered align-middle mt-3">
            <thead class="table-light">
            <tr>
                <th>User</th>
                <th>Event</th>
                <th>Enrollment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->user->name ?? 'Unknown' }}</td>
                    <td>{{ $enrollment->event->name ?? 'Unknown' }}</td>
                    <td>{{ $enrollment->enrollment_date }}</td>
                    <td>
                        <span class="badge {{ $enrollment->status == 'approved' ? 'bg-success' : ($enrollment->status == 'rejected' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('enrollment.edit', $enrollment->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('enrollment.destroy', $enrollment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No enrollments found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $enrollments->links() }}
    </div>
@endsection

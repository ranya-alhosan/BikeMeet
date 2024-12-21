@extends('dashboard.layout')

@section('content')
    <div class="container my-4">
        <h1 class="h3">Enrollment Management</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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

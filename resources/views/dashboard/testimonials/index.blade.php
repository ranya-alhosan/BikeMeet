@extends('dashboard.layout')


@section('content')
    <div class="container py-5">
        <h2 class="mb-4">Manage Testimonials</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>User Name</th>
                <th>Role</th>
                <th>Testimonial</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($testimonials as $testimonial)
                <tr>
                    <td>{{ $testimonial->user->name }}</td>
                    <td>{{ $testimonial->role }}</td>
                    <td>{{ $testimonial->text }}</td>
                    <td>
                        <span class="badge {{ $testimonial->status == 'Accept' ? 'bg-success' : 'bg-danger' }}">
                            {{ $testimonial->status }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.testimonials.updateStatus', $testimonial) }}" method="POST">
                            @csrf
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="Accept" {{ $testimonial->status == 'Accept' ? 'selected' : '' }}>Accept</option>
                                <option value="Reject" {{ $testimonial->status == 'Reject' ? 'selected' : '' }}>Reject</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

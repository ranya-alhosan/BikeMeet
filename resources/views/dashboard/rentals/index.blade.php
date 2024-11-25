@extends('dashboard.layout')

@section('rents-active', 'active')

@section('content')
<div class="container">
    <h1>Motorcycle Rentals</h1>
    <a href="{{ route('rentals.create') }}" class="btn btn-primary mb-3">Create New Rental</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Motorcycle</th>
                <th>Rental Start</th>
                <th>Rental End</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rentals as $rental)
                <tr>
                    <td>{{ $rental->user->name }}</td>
                    <td>{{ $rental->motorcycle->make }} - {{ $rental->motorcycle->model }} ({{ $rental->motorcycle->year }})</td>
                    <td>{{ $rental->rental_start_date }}</td>
                    <td>{{ $rental->rental_end_date }}</td>
                    <td>{{ ucfirst($rental->status) }}</td>
                    <td>
                        <a href="{{ route('rentals.edit', $rental->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" class="d-inline">
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

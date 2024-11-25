@extends('dashboard.layout')

@section('rents-active', 'active')

@section('content')
<div class="container">
    <h1>Create New Rental</h1>
    <form action="{{ route('rentals.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">Select User</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="motorcycle_id" class="form-label">Motorcycle</label>
            <select name="motorcycle_id" id="motorcycle_id" class="form-select" required>
                <option value="">Select Motorcycle</option>
                @foreach ($motorcycles as $motorcycle)
                    <option value="{{ $motorcycle->id }}">
                        {{ $motorcycle->make }} - {{ $motorcycle->model }} ({{ $motorcycle->year }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="rental_start_date" class="form-label">Rental Start Date</label>
            <input type="datetime-local" class="form-control" id="rental_start_date" name="rental_start_date" required>
        </div>
        <div class="mb-3">
            <label for="rental_end_date" class="form-label">Rental End Date</label>
            <input type="datetime-local" class="form-control" id="rental_end_date" name="rental_end_date" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="active">Active</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Rental</button>
    </form>
</div>
@endsection

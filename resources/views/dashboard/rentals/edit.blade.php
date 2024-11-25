@extends('dashboard.layout')

@section('rents-active', 'active')

@section('content')
<div class="container">
    <h1>Edit Rental</h1>
    <form action="{{ route('rentals.update', $rental->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-select" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $rental->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="motorcycle_id" class="form-label">Motorcycle</label>
            <select name="motorcycle_id" id="motorcycle_id" class="form-select" required>
                @foreach ($motorcycles as $motorcycle)
                    <option value="{{ $motorcycle->id }}" {{ $rental->motorcycle_id == $motorcycle->id ? 'selected' : '' }}>{{ $motorcycle->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="rental_start_date" class="form-label">Rental Start Date</label>
            <input type="datetime-local" class="form-control" id="rental_start_date" name="rental_start_date" value="{{ $rental->rental_start_date->format('Y-m-d\TH:i') }}" required>
        </div>
        <div class="mb-3">
            <label for="rental_end_date" class="form-label">Rental End Date</label>
            <input type="datetime-local" class="form-control" id="rental_end_date" name="rental_end_date" value="{{ $rental->rental_end_date->format('Y-m-d\TH:i') }}" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="active" {{ $rental->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ $rental->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $rental->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Rental</button>
    </form>
</div>
@endsection

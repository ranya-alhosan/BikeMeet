@extends('theme.master')

@section('hero-title', 'Create Rental Advertisement')
@section('rent-active', 'active')

@section('content')
    <div class="container">
        <h2>Create Rental Advertisement</h2>

        <!-- Display the error message -->
        @if ($errors->has('rental_error'))
            <div class="alert alert-danger">
                {{ $errors->first('rental_error') }}
            </div>
        @endif

        <!-- Rental form -->
        <form action="{{ route('rentals.storeRentals') }}" method="POST">
            @csrf

            <!-- Display logged-in user name (hidden input for user_id) -->
            <div class="form-group">
                <label>User</label>
                <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                <input type="hidden" name="user_id" value="{{ $user->id }}">
            </div>

            <!-- Select Motorcycle -->
            <div class="form-group">
                <label for="motorcycle_id">Motorcycle</label>
                <select name="motorcycle_id" id="motorcycle_id" class="form-control">
                    @foreach($motorcycles as $motorcycle)
                        <option value="{{ $motorcycle->id }}">
                            {{ $motorcycle->make }} {{ $motorcycle->model }} ({{ $motorcycle->year }})
                        </option>
                    @endforeach
                </select>
                @error('motorcycle_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Rental Start Date -->
            <div class="form-group">
                <label for="rental_start_date">Rental Start Date</label>
                <input type="date" name="rental_start_date" id="rental_start_date" class="form-control" required>
                @error('rental_start_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Rental End Date -->
            <div class="form-group">
                <label for="rental_end_date">Rental End Date</label>
                <input type="date" name="rental_end_date" id="rental_end_date" class="form-control" required>
                @error('rental_end_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-4">Create Rental Advertisement</button>
        </form>
    </div>
@endsection

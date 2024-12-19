@extends('dashboard.layout')

@section('rents-active', 'active')

@section('content')
    <div class="container">
        <h1>Edit Rental</h1>

        <form action="{{ route('rentals.update', $rental->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="user_id">User</label>
                <select class="form-control" name="user_id" id="user_id">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $rental->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="motorcycle_id">Motorcycle</label>
                <select class="form-control" name="motorcycle_id" id="motorcycle_id">
                    @foreach ($motorcycles as $motorcycle)
                        <option value="{{ $motorcycle->id }}" {{ $motorcycle->id == $rental->motorcycle_id ? 'selected' : '' }}>{{ $motorcycle->make }} {{ $motorcycle->model }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="rental_start_date">Rental Start Date</label>
                <input type="date" class="form-control" name="rental_start_date" id="rental_start_date" value="{{ \Carbon\Carbon::parse($rental->rental_start_date)->format('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label for="rental_end_date">Rental End Date</label>
                <input type="date" class="form-control" name="rental_end_date" id="rental_end_date" value="{{ \Carbon\Carbon::parse($rental->rental_end_date)->format('Y-m-d') }}" required>
            </div>


            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" id="status">
                    <option value="rented" {{ $rental->status == 'rented' ? 'selected' : '' }}>Rented</option>
                    <option value="available" {{ $rental->status == 'available' ? 'selected' : '' }}>Available</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Rental</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection

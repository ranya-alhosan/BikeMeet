@extends('dashboard.layout')


@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <h1>Add New Motorcycle</h1>
        <form method="POST" action="{{ route('motorcycles.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="user_id">Select User</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <option value="" disabled selected>Select a user</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="make">Make</label>
                <input type="text" class="form-control" id="make" name="make" required>
            </div>
            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" class="form-control" id="model" name="model" required>
            </div>
            <div class="form-group">
                <label for="year">Year</label>
                <input type="number" class="form-control" id="year" name="year" required>
            </div>
            <div class="form-group">
                <label for="price_per_day">Price per Day</label>
                <input type="number" class="form-control" id="price_per_day" name="price_per_day" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="availability_status">Availability Status</label>
                <select class="form-control" id="availability_status" name="availability_status" required>
                    <option value="available">Available</option>
                    <option value="unavailable">Under Maintenance</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Motorcycle Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Add Motorcycle</button>
        </form>
    </div>
@endsection

@extends('dashboard.layout')

@section('motorcycles-active', 'active')

@section('content')
    <div class="container">
        <h1>Add a New Motorcycle</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('motorcycles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="user_id" class="form-label">Assign to User</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">Select a User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="make" class="form-label">Make</label>
                <input
                    type="text"
                    class="form-control"
                    id="make"
                    name="make"
                    value="{{ old('make') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input
                    type="text"
                    class="form-control"
                    id="model"
                    name="model"
                    value="{{ old('model') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input
                    type="number"
                    class="form-control"
                    id="year"
                    name="year"
                    value="{{ old('year') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="price_per_day" class="form-label">Price Per Day</label>
                <input
                    type="number"
                    class="form-control"
                    id="price_per_day"
                    name="price_per_day"
                    value="{{ old('price_per_day') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="availability_status" class="form-label">Availability Status</label>
                <select name="availability_status" id="availability_status" class="form-select" required>
                    <option value="available" {{ old('availability_status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="under_maintenance" {{ old('availability_status') == 'under_maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea
                    class="form-control"
                    id="description"
                    name="description"
                    rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input
                    type="file"
                    class="form-control"
                    id="image"
                    name="image"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Add Motorcycle</button>
        </form>
    </div>
@endsection

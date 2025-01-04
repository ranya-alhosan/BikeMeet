@extends('dashboard.layout')

@section('rents-active', 'active')

@section('content')
    <div class="container">
        <h1>Create Rental</h1>

        <form action="{{ route('rentals.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="user_id">User</label>
                <select class="form-control" name="user_id" id="user_id" onchange="updateMotorcycles()">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == auth()->id() ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="motorcycle_id">Motorcycle</label>
                <select class="form-control" name="motorcycle_id" id="motorcycle_id">
                    @foreach ($motorcycles as $motorcycle)
                        <option value="{{ $motorcycle->id }}">{{ $motorcycle->make }} {{ $motorcycle->model }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="rental_start_date">Rental Start Date</label>
                <input type="date" class="form-control" name="rental_start_date" id="rental_start_date" required>
            </div>

            <div class="form-group">
                <label for="rental_end_date">Rental End Date</label>
                <input type="date" class="form-control" name="rental_end_date" id="rental_end_date" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Rental</button>
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

    <script>
        function updateMotorcycles() {
            const userId = document.getElementById('user_id').value;
            const motorcycleSelect = document.getElementById('motorcycle_id');
            motorcycleSelect.innerHTML = '<option>Loading...</option>'; // Show loading message

            fetch(`/motorcycles/${userId}`) // Use the dynamic route with userId
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    motorcycleSelect.innerHTML = ''; // Clear existing options
                    if (data.motorcycles && data.motorcycles.length > 0) {
                        data.motorcycles.forEach(motorcycle => {
                            const option = document.createElement('option');
                            option.value = motorcycle.id;
                            option.textContent = `${motorcycle.make} ${motorcycle.model}`;
                            motorcycleSelect.appendChild(option);
                        });
                    } else {
                        motorcycleSelect.innerHTML = '<option>No motorcycles available</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching motorcycles:', error);
                    motorcycleSelect.innerHTML = '<option>Error loading motorcycles</option>';
                });
        }


    </script>
@endsection

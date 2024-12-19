@extends('theme.master')

@section('hero-title', 'Rentals')
@section('rent-active', 'active')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- Filter Section -->
            <div class="col-md-3">
                <!-- Filters Heading with Add Icon -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-end">Filters</h5>
                    <!-- Add New Rental Advertisement Icon -->
                    <a href="{{ route('rentals.createRentals') }}" class="text-primary fs-4" title="Add New Rental Advertisement">
                        <i class="fas fa-plus"></i> <!-- Font Awesome "+" icon -->

                    </a>
                </div>

                <form action="{{ route('rentals.showRentals') }}" method="GET">
                    <!-- Filter by Make -->
                    <div class="form-group">
                        <label for="make">Motorcycle Make</label>
                        <input type="text" name="make" id="make" class="form-control"
                            value="{{ request('make') }}" placeholder="Enter make">
                    </div>

                    <!-- Filter by Status -->
                    <div class="form-group">
                        <label for="status"  class="mt-2">Rental Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Select Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                    </div>

                    <!-- Filter by Price Range -->
                    <div class="form-group">
                        <label for="price" class="mt-2">Price Per Day</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" name="min_price" id="min_price" class="form-control"
                                    value="{{ request('min_price') }}" placeholder="Min Price">
                            </div>
                            <div class="col">
                                <input type="number" name="max_price" id="max_price" class="form-control"
                                    value="{{ request('max_price') }}" placeholder="Max Price">
                            </div>
                        </div>
                    </div>

                    <!-- Filter by Rental Date Range -->
                    <div class="form-group">
                        <label for="dates"  class="mt-2">Rental Dates</label>
                        <div class="row">
                            <div class="col">
                                <input type="date" name="start_date" id="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col">
                                <input type="date" name="end_date" id="end_date" class="form-control mt-2"
                                    value="{{ request('end_date') }}">
                            </div>
                        </div>
                    </div>
                    <!-- Filter by Rental Availability -->
                    <div class="form-group">
                        <label for="rent_status"  class="mt-2">Rental Availability</label>
                        <select name="rent_status" id="rent_status" class="form-control">
                            <option value="">Select Availability</option>
                            <option value="available" {{ request('rent_status') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="rented" {{ request('rent_status') == 'rented' ? 'selected' : '' }}>Rented</option>
                        </select>
                    </div>


                    <!-- Apply and Clear Filters -->
                    <div class="d-flex flex-column gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('rentals.showRentals') }}" class="btn btn-secondary">Clear All</a>
                    </div>
                </form>
            </div>

            <!-- Rentals List Section -->
            <div class="col-md-9">
                <div class="row">
                    @foreach ($rentals as $rental)
                        <div class="col-md-4 mb-4">
                            <div class="card shadow">
                                <img src="{{ $rental->motorcycle && $rental->motorcycle->image ? asset('storage/' . $rental->motorcycle->image) : asset('path/to/default-image.jpg') }}" class="card-img-top" alt="Motorcycle Image">

                                <div class="card-body">
                                    <h5 class="card-title">{{ $rental->motorcycle->make }} {{ $rental->motorcycle->model }}</h5>
                                    <p class="card-text">
                                        <strong>User:</strong> {{ $rental->user->name }} <br>
                                        <strong>Price:</strong> ${{ number_format($rental->motorcycle->price_per_day, 2) }} <br>
                                        <strong>Status:</strong> {{ ucfirst($rental->status) }} <br>
                                        <strong>Rental Period:</strong>
                                        {{ \Carbon\Carbon::parse($rental->rental_start_date)->format('M d, Y') }} -
                                        {{ \Carbon\Carbon::parse($rental->rental_end_date)->format('M d, Y') }}
                                    </p>
                                    <a href="{{ route('rentals.showRentDetails', $rental->id) }}" class="btn btn-primary">Rent Now</a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

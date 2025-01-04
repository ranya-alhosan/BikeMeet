@extends('dashboard.layout')

@section('rents-active', 'active')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
            <h1 class="h3">Rentals Management</h1>
            <a href="{{ route('rentals.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Rental
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <hr>

        <form action="{{ route('rentals.index') }}" method="GET" class="mb-4 mt-4">
            <div class="row">
                <!-- Motorcycle Name Filter -->
                <div class="col-md-3">
                    <label for="motorcycle_name" class="form-label">Motorcycle Name</label>
                    <input type="text" name="motorcycle_name" id="motorcycle_name" class="form-control"
                           value="{{ request('motorcycle_name') }}" placeholder="Enter make or model">
                </div>

                <!-- Owner Name Filter -->
                <div class="col-md-3">
                    <label for="owner_name" class="form-label">Owner Name</label>
                    <input type="text" name="owner_name" id="owner_name" class="form-control"
                           value="{{ request('owner_name') }}" placeholder="Enter owner name">
                </div>

                <!-- Rental Start Date Filter -->
                <div class="col-md-3">
                    <label for="rental_start_date" class="form-label">Start Date</label>
                    <input type="date" name="rental_start_date" id="rental_start_date" class="form-control"
                           value="{{ request('rental_start_date') }}">
                </div>

                <!-- Rental End Date Filter -->
                <div class="col-md-3">
                    <label for="rental_end_date" class="form-label">End Date</label>
                    <input type="date" name="rental_end_date" id="rental_end_date" class="form-control"
                           value="{{ request('rental_end_date') }}">
                </div>

                <!-- Status Filter -->
                <div class="col-md-3 mt-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">-- Select Status --</option>
                        <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    </select>
                </div>
            </div>

            <!-- Buttons aligned to the bottom right -->
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary me-2">Filter</button>
                <a href="{{ route('rentals.index') }}" class="btn btn-secondary">Clear Filters</a>
            </div>
        </form>

        <!-- Check if there are any rentals -->
        @if($rentals->isEmpty())
            <div class="alert alert-info">
                No rentals available at the moment.
            </div>
        @else
            <div class="row">
                @foreach($rentals as $rental)
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="card shadow w-100">
                            @if ($rental->motorcycle && $rental->motorcycle->image)
                                <img src="{{ asset('storage/' . $rental->motorcycle->image) }}" class="card-img-top" alt="Motorcycle Image">
                            @else
                                <img src="{{ asset('images/default-motorcycle.jpg') }}" class="card-img-top" alt="Motorcycle Image">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $rental->motorcycle->make }} {{ $rental->motorcycle->model }}</h5>
                                <p class="card-text">
                                    <strong>User:</strong> {{ $rental->user->name }} <br>
                                    <strong>Status:</strong> {{ ucfirst($rental->status) }} <br>
                                    <strong>Rental Period:</strong>
                                    {{ \Carbon\Carbon::parse($rental->rental_start_date)->format('M d, Y') }} -
                                    {{ \Carbon\Carbon::parse($rental->rental_end_date)->format('M d, Y') }}
                                </p>
                                <div class="mt-auto">
                                    <a href="{{ route('rentals.edit', $rental->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="mt-4">
                {{ $rentals->links() }}
            </div>
        @endif
    </div>
@endsection

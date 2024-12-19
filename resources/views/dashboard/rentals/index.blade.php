@extends('dashboard.layout')

@section('rents-active', 'active')

@section('content')
    <div class="container">
        <h1>Rentals Management</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Rental Button -->
        <a href="{{ route('rentals.create') }}" class="btn btn-primary mb-3">Add Rental</a>

        <div class="row">
            @foreach($rentals as $rental)
                <div class="col-md-4">
                    <div class="card shadow">
                        @if ($rental->motorcycle && $rental->motorcycle->image)
                            <img src="{{ asset('storage/' . $rental->motorcycle->image) }}" class="card-img-top" alt="Motorcycle Image">
                        @else
                            <img src="{{ asset('images/default-motorcycle.jpg') }}" class="card-img-top" alt="Motorcycle Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $rental->motorcycle->make }} {{ $rental->motorcycle->model }}</h5>
                            <p class="card-text">
                                <strong>User:</strong> {{ $rental->user->name }} <br>
                                <strong>Status:</strong> {{ ucfirst($rental->status) }} <br>
                                <strong>Rental Period:</strong>
                                {{ \Carbon\Carbon::parse($rental->rental_start_date)->format('M d, Y') }} -
                                {{ \Carbon\Carbon::parse($rental->rental_end_date)->format('M d, Y') }} <br>
                                <a href="{{ route('rentals.edit', $rental->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('rentals.destroy', $rental->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

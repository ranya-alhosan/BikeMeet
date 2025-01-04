@extends('dashboard.layout')

@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Motorcycles Management</h1>
            <a href="{{ route('motorcycles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Motorcycle
            </a>
        </div>

        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <hr>
        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('motorcycles.index') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by make, model, or description"
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="availability_status" class="form-select">
                    <option value="">Filter by Availability</option>
                    <option value="available" {{ request('availability_status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="under_maintenance" {{ request('availability_status') == 'under_maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                </select>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">Search</button>
                <a href="{{ route('motorcycles.index') }}" class="btn btn-secondary">Clear</a>
            </div>
        </form>

        <div class="row mt-3">
            @foreach ($motorcycles as $motorcycle)
                <div class="col-md-4 mt-2">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">{{ $motorcycle->make }} {{ $motorcycle->model }}</h5>
                                <!-- Options Icon (three dots) -->
                                <div class="dropdown">
                                    <button class="btn btn-link text-dark p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-ellipsis mb-2" style="font-size: 20px"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('motorcycles.edit', $motorcycle->id) }}">Edit</a></li>
                                        <li>
                                            <form action="{{ route('motorcycles.destroy', $motorcycle->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Motorcycle Image -->
                            <img src="{{ asset('storage/' . $motorcycle->image) }}" class="card-img-top mb-3" alt="Motorcycle Image" style="height: 200px; object-fit: cover;">

                            <p class="card-text"><b>Owner:</b> {{ $motorcycle->user->name ?? 'N/A' }}</p>
                            <p class="card-text"><b>Description:</b> {{ $motorcycle->description }}</p>

                            <!-- Add Year, Price Per Day, and Availability Status -->
                            <p class="card-text"><b>Year:</b> {{ $motorcycle->year }}</p>
                            <p class="card-text"><b>Price Per Day:</b> ${{ number_format($motorcycle->price_per_day, 2) }}</p>
                            <p class="card-text"><b>Availability:</b>
                                <span class="badge {{ $motorcycle->availability_status == 'available' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst($motorcycle->availability_status) }}
                        </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $motorcycles->links() }}
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const motorcycleId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the delete request
                            fetch(`{{ url('motorcycles') }}/${motorcycleId}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({ _method: 'DELETE' })
                            })
                                .then(response => {
                                    if (response.ok) {
                                        Swal.fire(
                                            'Deleted!',
                                            'The motorcycle has been deleted.',
                                            'success'
                                        ).then(() => {
                                            location.reload(); // Refresh the page
                                        });
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            'Something went wrong while deleting.',
                                            'error'
                                        );
                                    }
                                })
                                .catch(() => {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete the motorcycle.',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });
        });
    </script>

    <!-- Include Bootstrap's JavaScript (This should be placed before the closing body tag) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection

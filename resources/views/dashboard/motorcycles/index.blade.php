@extends('dashboard.layout')

@section('content')
    <div class="container mt-2">
        <h1>Your Motorcycles</h1>
        <a href="{{ route('motorcycles.create') }}" class="btn btn-primary">Add New Motorcycle</a>

        <div class="row mt-3">
            @foreach ($motorcycles as $motorcycle)
                <div class="col-md-4 mt-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $motorcycle->make }} {{ $motorcycle->model }}</h5>
                            <p class="card-text">Owner: {{  $motorcycle->user->name ?? 'N/A' }}</p>
                            <p class="card-text">{{ $motorcycle->description }}</p>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('motorcycles.edit', $motorcycle->id) }}" class="btn btn-warning">Edit</a>

                                <button class="btn btn-danger btn-delete" data-id="{{ $motorcycle->id }}">
                                    X
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
@endsection

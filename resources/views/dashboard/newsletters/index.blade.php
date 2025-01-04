@extends('dashboard.layout')

@section('content')
    <div class="container">


        <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
            <h1 class="h3">Newsletters Management</h1>
            <a href="{{ route('newsletters.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Newsletter
            </a>
        </div>
        <!-- Display success message if it exists -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <hr>

        <!-- Search form with clear button on the same line -->
        <form method="GET" action="{{ route('newsletters.index') }}" class="mb-3 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by title, owner, or description" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary me-2">Search</button>
            <a href="{{ route('newsletters.index') }}" class="btn btn-secondary">Clear</a>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Title</th>
                <th>Owner</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($newsletters as $newsletter)
                <tr>
                    <td>{{ $newsletter->title }}</td>
                    <td>{{ $newsletter->user->name }}</td>
                    <td>
                        @if ($newsletter->image)
                            <img src="{{ asset('storage/' . $newsletter->image) }}" alt="{{ $newsletter->title }}" width="100" class="thumbnail" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="{{ asset('storage/' . $newsletter->image) }}">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('newsletters.show', $newsletter->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('DashNewsletters.edit', $newsletter->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('DashNewsletters.destroy', $newsletter->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this newsletter?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center">
            {{ $newsletters->links() }}
        </div>
    </div>

    <!-- Modal for Zoomed Image -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Zoomed Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Zoomed Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle the click event on the image to show the modal with the zoomed-in image
        document.querySelectorAll('.thumbnail').forEach(item => {
            item.addEventListener('click', function () {
                const imageUrl = item.getAttribute('data-image');
                document.getElementById('modalImage').src = imageUrl; // Set the src of the modal image
            });
        });
    </script>
@endsection

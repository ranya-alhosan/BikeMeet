@extends('dashboard.layout')

@section('content')
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="card-title text-primary">Create New Newsletter</h1>

                <!-- Form for creating a new newsletter -->
                <form action="{{ route('DashNewsletters.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Newsletter</button>
                </form>
            </div>
        </div>
    </div>
@endsection

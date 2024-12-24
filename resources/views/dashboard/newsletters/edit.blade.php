@extends('dashboard.layout')

@section('content')
    <div class="container">
        <h1>Edit Newsletter</h1>

        <!-- Form to edit the newsletter -->
        <form action="{{ route('DashNewsletters.update', $newsletter->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $newsletter->title) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" class="form-control" required>{{ old('content', $newsletter->content) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Newsletter</button>
        </form>
    </div>
@endsection

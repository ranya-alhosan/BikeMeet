<!-- In resources/views/newsletters/edit.blade.php -->

@extends('theme.master')

@section('content')
    <div class="container">
        <h1>Edit Newsletter</h1>

        <form action="{{ route('UserNewsletter.update', $newsletter->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $newsletter->title) }}" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" class="form-control" required>{{ old('content', $newsletter->content) }}</textarea>
            </div>

            <div class="form-group">
                <label for="image">Image (optional)</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>

            @if($newsletter->image)
                <div class="form-group mt-3">
                    <img src="{{ asset('storage/' . $newsletter->image) }}" alt="Newsletter Image" class="img-fluid" width="200">
                </div>
            @endif

            <button type="submit" class="btn btn-primary mt-3">Update Newsletter</button>
        </form>
    </div>
@endsection

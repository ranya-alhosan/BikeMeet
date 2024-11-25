@extends('dashboard.layout')

@section('content')
<div class="container">
    <h1>Edit Newsletter</h1>
    <form action="{{ route('newsletters.update', $newsletter->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $newsletter->title }}" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required>{{ $newsletter->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Newsletter</button>
    </form>
</div>
@endsection

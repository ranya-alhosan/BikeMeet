@extends('dashboard.layout')

@section('content')
<div class="container">
    <h1>{{ $newsletter->title }}</h1>
    <p>{{ $newsletter->content }}</p>
    <h4>Likes: {{ $likes->count() }}</h4>
    <form action="{{ route('newsletters.like', $newsletter->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Like</button>
    </form>
    <h4>Comments</h4>
    @foreach ($comments as $comment)
        <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}</p>
    @endforeach
    <form action="{{ route('newsletters.comment', $newsletter->id) }}" method="POST">
        @csrf
        <textarea class="form-control" name="comment" required></textarea>
        <button type="submit" class="btn btn-primary mt-2">Comment</button>
    </form>

    <!-- Go Back Button -->
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Go Back</a>
</div>
@endsection

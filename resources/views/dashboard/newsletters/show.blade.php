@extends('dashboard.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="h3  mb-3">Newsletters Details</h1>
        <div class="card shadow">


            <div class="card-body">
                <!-- Newsletter Title -->
                <h1 class="card-title text-primary">{{ $newsletter->title }}</h1>



                <!-- Newsletter Content -->
                <p class="card-text mt-3">{{ $newsletter->content }}</p>
                <!-- Newsletter Image -->
                @if ($newsletter->image)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $newsletter->image) }}" alt="Newsletter Image" class="img-fluid">
                    </div>
                @endif
                <!-- Likes Count -->
                <div class="d-flex align-items-center mt-4">
                    <i class="fas fa-thumbs-up text-success me-2" style="font-size: 20px"></i>
                    <h5 class="m-0"><span class="text-dark">{{ $likes->count() }}</span></h5>

                    <!-- Add space between Likes and Comments -->
                    <div class="ms-4 d-flex align-items-center">
                        <i class="fas fa-comment-alt text-success me-2"></i>
                        <h5 class="m-0"><span class="text-dark">{{ $comments->count() }}</span></h5>
                    </div>
                </div>

            </div>
        </div>

        <!-- Comments Section -->
        <div class="mt-5">
            <h3 class="text-secondary">Comments</h3>
            @if ($comments->isEmpty())
                <p class="text-muted">No comments yet. Be the first to comment!</p>
            @else
                <div class="list-group">
                    @foreach ($comments->groupBy(function($comment) {
                        return $comment->created_at->format('F d, Y'); // Group by date
                    }) as $date => $commentsByDate)
                        <!-- Display Date -->
                        <div class="mt-3">
                            <h5 class="text-muted">{{ $date }}</h5>
                        </div>

                        <!-- Comments for that date -->
                        @foreach ($commentsByDate as $comment)
                            <div class="list-group-item list-group-item-action mb-2 rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-center">
                                    <strong class="text-dark">{{ $comment->user->name }}</strong>

                                    <!-- Delete button (visible to the comment owner or admin) -->
                                    @if (auth()->id() === $comment->user_id || auth()->user()->role === 'admin')
                                        <form action="{{ route('DashComments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this comment?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                                <p class="mb-0 text-muted mt-2">{{ $comment->comment }}</p>

                                <!-- Time displayed below the delete button -->
                                <small class="text-muted mt-2 d-block">{{ $comment->created_at->format('h:i A') }}</small>
                            </div>
                        @endforeach
                    @endforeach
                </div>

                <!-- Pagination Links -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $comments->links() }}
                </div>
            @endif
        </div>

        <!-- Go Back Button -->
        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Go Back
            </a>
        </div>
    </div>
@endsection

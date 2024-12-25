@extends('theme.master')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">My Newsletters</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($newsletters->count() > 0)
            <div class="row">
                @foreach($newsletters as $newsletter)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- Newsletter Form -->
                                <form action="{{ route('ProfNewsletters.update', $newsletter->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group mb-2">
                                        <label for="title-{{ $newsletter->id }}">Title</label>
                                        <input
                                            type="text"
                                            name="title"
                                            id="title-{{ $newsletter->id }}"
                                            class="form-control"
                                            value="{{ $newsletter->title }}"
                                            required
                                        >
                                    </div>

                                    <div class="form-group mb-2">
                                        <label for="content-{{ $newsletter->id }}">Content</label>
                                        <textarea
                                            name="content"
                                            id="content-{{ $newsletter->id }}"
                                            class="form-control"
                                            rows="3"
                                            required
                                        >{{ $newsletter->content }}</textarea>
                                    </div>

                                    <p class="text-muted">
                                        <i class="fa fa-thumbs-up" style="color: {{ $newsletter->user_liked ? 'red' : 'gray' }};"></i>
                                        {{ $newsletter->likes_count }} Likes |
                                        <i class="fa fa-comments"></i> {{ $newsletter->comments_count }} Comments
                                    </p>

                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-save"></i> Save
                                        </button>
                                    </div>
                                </form>

                                <!-- Like Button -->
                                <form action="{{ route('ProfNewsletters.like', $newsletter->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-thumbs-up"></i> Like
                                    </button>
                                </form>

                                <!-- Comment Form -->
                                <form action="{{ route('ProfNewsletters.comment', $newsletter->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="comment" class="form-control" rows="2" placeholder="Add a comment..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-secondary btn-sm mt-1">
                                        <i class="fas fa-comment"></i> Comment
                                    </button>
                                </form>

                                <!-- Display Comments -->
                                <div class="mt-3">
                                    @if($newsletter->comments->count() > 0)
                                        <h5>Comments</h5>
                                        <ul class="list-unstyled">
                                            @foreach($newsletter->comments as $comment)
                                                <li class="mb-2">
                                                    <strong>{{ $comment->user->name }}:</strong>
                                                    <p>{{ $comment->content }}</p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No comments yet.</p>
                                    @endif
                                </div>

                                <!-- Delete Form -->
                                <form action="{{ route('ProfNewsletters.destroy', $newsletter->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this newsletter?');" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $newsletters->links() }}
            </div>
        @else
            <p class="text-muted">You haven't published any newsletters yet.</p>
        @endif
    </div>
@endsection

@extends('theme.master')
@section('hero-title', 'Our Latest Newsletters')

@section('content')
    <div class="container mt-5">
        <button class="btn btn-primary m-3" data-bs-toggle="modal" data-bs-target="#createNewsletterModal">
            Add New Newsletter
        </button>
        <!-- Modal for Creating New Newsletter -->
        <div class="modal fade" id="createNewsletterModal" tabindex="-1" aria-labelledby="createNewsletterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createNewsletterModalLabel">Create New Newsletter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('UserNewsletter.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="content">Content</label>
                                <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Newsletter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($newsletters->isEmpty())
            <div class="alert alert-warning text-center">
                <strong>No newsletters available!</strong> Stay tuned for the latest updates.
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 g-4" id="newsletter-results">
                @foreach($newsletters as $newsletter)
                    <div class="col">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary fw-bold">{{ $newsletter->title }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($newsletter->content, 100) }}</p>
                                <p class="text-muted small mb-3">
                                    <i class="fas fa-user"></i>
                                    <strong>Owner:</strong> {{ $newsletter->user->name ?? 'Unknown' }}
                                    <i class="fas fa-clock"></i>
                                    <strong>Posted:</strong> {{ $newsletter->created_at->diffForHumans() }}
                                </p>

                                <!-- Like Button -->
                                <form action="{{ route('UserNewsletter.like', $newsletter->id) }}" method="POST"
                                      class="like-form d-flex align-items-center">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light shadow-sm me-2">
                                        <i class="fas fa-heart {{ $newsletter->likes->where('user_id', auth()->id())->count() > 0 ? 'text-danger' : '' }}"></i>
                                    </button>
                                    <span class="like-count text-muted">{{ $newsletter->likes->count() }} </span>
                                </form>

                                <!-- Comment Section -->
                                <div class="comments-section mt-3">
                                    <button class="btn btn-sm btn-outline-primary show-comment-form">
                                        <i class="fas fa-comment-alt"></i>
                                        <span class="comment-count">{{ $newsletter->comments->count() }} comments</span>
                                    </button>
                                    <!-- Comment Form (Initially Hidden) -->
                                    <form action="{{ route('UserNewsletter.comment', $newsletter->id) }}" method="POST"
                                          class="comment-form d-none mt-3">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="comment" class="form-control form-control-sm"
                                                      placeholder="Write a comment..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm mt-2">Post</button>
                                    </form>
                                </div>

                                <!-- Comments List -->
                                <div class="comments-list mt-3">
                                    @if($newsletter->comments->isEmpty())
                                        <p class="text-muted small">No comments yet. Be the first to comment!</p>
                                    @else
                                        @foreach($newsletter->comments->take(3) as $comment)
                                            <div
                                                class="comment border-bottom pb-2 mb-2 d-flex justify-content-between align-items-center"
                                                data-comment-id="{{ $comment->id }}">
                                                <div>
                                                    <strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}
                                                    <br>
                                                    <span class="text-muted small">
                        <small>{{ $comment->created_at->diffForHumans() }}</small>
                    </span>
                                                </div>
                                                @if(auth()->id() == $comment->user_id)
                                                    <div>
                                                        <button
                                                            class="btn btn-sm btn-outline-secondary edit-comment-btn"
                                                            data-comment-id="{{ $comment->id }}"
                                                            data-comment-content="{{ $comment->comment }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form
                                                            action="{{ route('UserNewsletter.comment.delete', $comment->id) }}"
                                                            method="POST" class="d-inline delete-comment-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger delete-comment-btn">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                        <div class="hidden-comments" style="display: none;">
                                            @foreach($newsletter->comments->skip(3) as $comment)
                                                <div
                                                    class="comment border-bottom pb-2 mb-2 d-flex justify-content-between align-items-center"
                                                    data-comment-id="{{ $comment->id }}">
                                                    <div>
                                                        <strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}
                                                        <br>
                                                        <span class="text-muted small">
                            <small>{{ $comment->created_at->diffForHumans() }}</small>
                        </span>
                                                    </div>
                                                    @if(auth()->id() == $comment->user_id)
                                                        <div>
                                                            <button
                                                                class="btn btn-sm btn-outline-secondary edit-comment-btn"
                                                                data-comment-id="{{ $comment->id }}"
                                                                data-comment-content="{{ $comment->comment }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <form
                                                                action="{{ route('UserNewsletter.comment.delete', $comment->id) }}"
                                                                method="POST" class="d-inline delete-comment-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                        class="btn btn-sm btn-outline-danger delete-comment-btn">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($newsletter->comments->count() > 3)
                                            <button class="btn btn-link read-more-btn"
                                                    data-newsletter-id="{{ $newsletter->id }}">Read More
                                            </button>
                                        @endif
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCommentModalLabel">Edit Comment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-comment-form" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea name="comment" id="edit-comment-content" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.like-form').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var likeCount = form.find('.like-count');
            var likeButton = form.find('button i');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    if (likeButton.hasClass('text-danger')) {
                        likeButton.removeClass('text-danger');
                    } else {
                        likeButton.addClass('text-danger');
                    }
                    likeCount.text(response.likes_count + ' likes');
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('.show-comment-form').on('click', function () {
            var button = $(this);
            var commentForm = button.next('.comment-form');
            button.addClass('d-none');
            commentForm.removeClass('d-none');
        });

        $('.comment-form').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var commentText = form.find('textarea').val();
            var commentsList = form.closest('.comments-section').next('.comments-list');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    commentsList.append(
                        '<div class="comment border-bottom pb-2 mb-2" data-comment-id="' + response.comment_id + '"><strong>' +
                        response.user_name + '</strong>: ' + response.comment + '</div>'
                    );
                    form.find('textarea').val('');
                    form.addClass('d-none');
                    form.prev('.show-comment-form').removeClass('d-none');
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('.edit-comment-btn').on('click', function () {
            var commentId = $(this).data('comment-id');
            var commentContent = $(this).data('comment-content');

            $('#edit-comment-content').val(commentContent);
            $('#edit-comment-form').attr('action', `/UserComments/${commentId}`);

            $('#editCommentModal').modal('show');
        });

        $('#edit-comment-form').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var commentId = form.attr('action').split('/').pop();
            var updatedComment = $('#edit-comment-content').val();

            $.ajax({
                url: form.attr('action'),
                type: 'PATCH',
                data: form.serialize(),
                success: function (response) {
                    var commentElement = $('div[data-comment-id="' + commentId + '"]');
                    commentElement.html('<strong>' + response.user_name + '</strong>: ' + updatedComment);

                    $('#editCommentModal').modal('hide');
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('.delete-comment-form').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var commentElement = form.closest('.comment');

            $.ajax({
                url: form.attr('action'),
                type: 'DELETE',
                data: form.serialize(),
                success: function (response) {
                    commentElement.remove();
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        $('.read-more-btn').on('click', function () {
            var button = $(this);
            var hiddenComments = button.closest('.comments-list').find('.hidden-comments');

            hiddenComments.slideDown();
            button.hide();
        });

    });
</script>

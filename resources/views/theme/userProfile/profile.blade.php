@extends('theme.master')

@section('content')
    <style>
        .newsletter-image {
            width: 100%; /* Makes the image responsive */
            height: 200px; /* Fixed height */
            object-fit: cover; /* Ensures the image doesn't stretch */
            transition: transform 0.3s ease; /* Smooth transition for zoom effect */
        }

        .newsletter-image:hover {
            transform: scale(0.9); /* Zoom out on hover */
            cursor: pointer; /* Change cursor to pointer to indicate it's clickable */
        }

    </style>
    <div class="container d-flex flex-column justify-content-center align-items-center min-vh-100">
        <div class="row w-100">
            <!-- User Info Section -->
            <div class="col-md-7 mx-auto">
                <div class="card shadow-lg p-4 border-0"
                     style="margin-top: -100px; backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.8); border-radius: 15px;">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <img src="{{ isset($user->profile_picture) && $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets/img/users.png') }}"
                                 class="rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;" data-bs-toggle="modal"
                                 data-bs-target="#imageModal" alt="User Profile Picture">

                        </div>
                        <div class="col-md-8 position-relative">
                            <h3 class="fw-bold d-flex align-items-center justify-content-between">
                                {{ $user->name }}
                                <div class="dropdown">
                                    <button class="btn btn-link text-dark p-0" type="button" id="userDetailsMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h fs-5"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDetailsMenu">
                                        <li><a class="dropdown-item" href="{{ route('UserMotorcycles.index') }}">Motorcycles</a></li>
                                        <li><a class="dropdown-item" href="{{ route('user.events') }}">Events</a></li>
                                        <li><a class="dropdown-item" href="{{ route('events.enrolled') }}">Enrolled Events</a></li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item" type="submit">Logout</button>
                                        </form>
                                    </ul>
                                </div>
                            </h3>
                            <p class="text-muted mb-2">
                                <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                            </p>
                            <p class="text-muted mb-2">
                                <i class="fas fa-calendar-alt me-2"></i>Joined: {{ $user->created_at->format('F d, Y') }}
                            </p>
                            @if($motorcycleCount > 0)
                                <p class="text-muted">
                                    <i class="fas fa-motorcycle me-2"></i>Motorcycles Owned: {{ $motorcycleCount }}
                                </p>
                            @endif
                            <a href="{{ route('UserProfile.edit') }}" class="btn btn-outline-primary btn-sm mt-3">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- My Newsletters Section -->
        <div class="col-md-9 mx-auto mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-center m-0">My Newsletters</h2>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createNewsletterModal">
                    Add New Newsletter
                </button>
            </div>

            <!-- Modal to Add New Newsletter -->
            <div class="modal fade" id="createNewsletterModal" tabindex="-1" aria-labelledby="createNewsletterModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createNewsletterModalLabel">Create New Newsletter</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('UserNewsletter.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <div class="form-group mt-3">
                                        <label for="image">Upload Image</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
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
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($newsletters->count() > 0)
                <div class="row g-4">
                    @foreach($newsletters as $newsletter)
                        <div class="col-12">
                            <div class="card shadow border-0">
                                <div class="card-body">
                                    <!-- Dropdown for Edit/Delete -->
                                    <div class="dropdown position-absolute top-0 end-0 m-3">
                                        <button class="btn btn-link text-dark p-0" type="button" id="newsletterMenu{{ $newsletter->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="newsletterMenu{{ $newsletter->id }}">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('UserNewsletter.edit', $newsletter->id) }}">Edit</a>
                                            </li>
                                            <li>
                                                <form action="{{ route('UserNewsletter.destroy', $newsletter->id) }}" method="POST" class="delete-newsletter-form" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            <li>
                                                <a href="#" class="dropdown-item delete-newsletter" data-newsletter-id="{{ $newsletter->id }}">Delete</a>
                                            </li>

                                            </li>
                                        </ul>
                                    </div>

                                    <h5 class="card-title text-primary fw-bold">{{ $newsletter->title }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($newsletter->content, 100) }}</p>

                                    <p class="text-muted small mb-3">
                                        <i class="fas fa-user"></i>
                                        <strong>Owner:</strong> {{ $newsletter->user->name ?? 'Unknown' }}
                                        <i class="fas fa-clock"></i>
                                        <strong>Posted:</strong> {{ $newsletter->created_at->diffForHumans() }}
                                    </p>

                                    @if($newsletter->image)
                                        <img src="{{ asset('storage/' . $newsletter->image) }}" alt="Newsletter Image" class="img-fluid mb-3 newsletter-image" >
                                    @endif


                                    <div class="d-flex justify-content-start">
                                        <form action="{{ route('ProfNewsletters.like', $newsletter->id) }}" method="POST" class="me-3">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-thumbs-up"></i> Like {{ $newsletter->likes->count() }}
                                            </button>
                                        </form>

                                        <!-- Comment Section -->
                                        <div class="comments-section">
                                            <button class="btn btn-sm btn-outline-primary show-comment-form">
                                                <i class="fas fa-comment-alt"></i>
                                                <span class="comment-count">{{ $newsletter->comments->count() }} comments</span>
                                            </button>

                                            <form action="{{ route('UserNewsletter.comment', $newsletter->id) }}" method="POST" class="comment-form d-none mt-3">
                                                @csrf
                                                <div class="form-group">
                                                    <textarea name="comment" class="form-control form-control-sm" placeholder="Write a comment..." required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-sm mt-2">Post</button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="comments-list mt-3">
                                        @if($newsletter->comments->isEmpty())
                                            <p class="text-muted small">No comments yet. Be the first to comment!</p>
                                        @else
                                            @foreach($newsletter->comments->take(3) as $comment)
                                                <div class="comment border-bottom pb-2 mb-2">
                                                    <strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}
                                                    <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                            @endforeach
                                            <div class="hidden-comments" style="display: none;">
                                                @foreach($newsletter->comments->skip(3) as $comment)
                                                    <div class="comment border-bottom pb-2 mb-2">
                                                        <strong>{{ $comment->user->name }}</strong>: {{ $comment->comment }}
                                                        <span class="text-muted small">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @if($newsletter->comments->count() > 3)
                                                <button class="btn btn-link read-more-btn" data-newsletter-id="{{ $newsletter->id }}">Read More</button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $newsletters->links() }}
                </div>

            @else
                <div class="text-center">
                    <p class="text-muted">You haven't published any newsletters yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">{{ $user->name }} Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ isset($user->profile_picture) && $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets/img/users.png') }}" class="img-fluid rounded"
                         alt="User Profile Picture">
                </div>
            </div>
        </div>
    </div>


    <!-- Newsletter Image Modal -->
    <div class="modal fade" id="newsletterImageModal" tabindex="-1" aria-labelledby="newsletterImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Full-size image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>


@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('.show-comment-form').click(function () {
            $(this).next('.comment-form').toggleClass('d-none');
        });

        $('.read-more-btn').on('click', function () {
            var button = $(this);
            var hiddenComments = button.closest('.comments-list').find('.hidden-comments');
            hiddenComments.slideDown();
            button.hide();
        });
    });
    $(document).ready(function () {
        $('.delete-newsletter').on('click', function (e) {
            e.preventDefault();
            var newsletterId = $(this).data('newsletter-id');
            var deleteForm = $('.delete-newsletter-form');

            // Use Laravel route helper to generate the delete URL
            var deleteUrl = '{{ route('UserNewsletter.destroy', ':id') }}'.replace(':id', newsletterId);

            // Trigger SweetAlert
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, set the form action dynamically and submit the form
                    deleteForm.attr('action', deleteUrl);
                    deleteForm.submit();
                }
            });
        });
    });
    $(document).ready(function () {
        // Handle profile image click to open the profile image modal
        $('.profile-image').on('click', function () {
            const imageUrl = $(this).attr('src');
            $('#profileImageModal img').attr('src', imageUrl);
            $('#profileImageModal').modal('show');
        });

        // Handle newsletter image click to open the newsletter image modal
        $('.newsletter-image').on('click', function () {
            const imageUrl = $(this).attr('src');
            $('#modalImage').attr('src', imageUrl); // Set the full-size image source
            $('#newsletterImageModal').modal('show'); // Show the newsletter image modal
        });

        // Other JavaScript code for comment form and delete functionality...
    });


</script>


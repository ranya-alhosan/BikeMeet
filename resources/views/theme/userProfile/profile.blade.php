@extends('theme.master')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4 d-flex justify-content-center mb-4">
                        <!-- Profile Image -->
                        <img
                            src="{{ isset($user->profile_picture) && $user->profile_picture ?
 asset('storage/' . $user->profile_picture) : asset('assets/img/users.png') }}"
                            class="rounded-circle shadow"
                            style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                            data-bs-toggle="modal"
                            data-bs-target="#imageModal"
                            alt="User Profile Picture"
                        >
                        <!-- Modal to Display the Image -->
                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="imageModalLabel">{{ $user->name }} Profile Picture</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <img
                                            src="{{ isset($user->profile_picture) && $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('assets/img/users.png') }}"
                                            class="img-fluid"
                                            style="max-height: 90vh;"
                                            alt="User Profile Picture"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Hero Section -->
                        <div class="col-md-8 info-user" style="margin-left: 20px;">
                            <h1 class="mb-3">{{ $user->name }}</h1>
                            <p class="text-muted mb-2">
                                <strong>Email:</strong> {{ $user->email }}
                            </p>
                            <p class="text-muted mb-2">
                                <strong>Joined:</strong> {{ $user->created_at->format('F d, Y') }}
                            </p>
                            @if($motorcycleCount > 0)
                                <p class="text-muted mb-4">
                                    <strong>Motorcycles Owned:</strong> {{ $motorcycleCount }}
                                </p>
                            @endif
                        </div>

                    </div>

                </div>
                <div class="row">

                </div>
                <div class="news">
                    <h2>My Newsletters</h2>

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
                                <div class="col-md-12 mb-4"> <!-- Changed col-md-6 to col-md-12 for full width -->
                                    <div class="card shadow ">
                                        <div class="card-body">
                                            <!-- Top-right Icon for Edit/Delete -->
                                            <div class="dropdown" style="position: absolute; top: 10px; right: 10px;">
                                                <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal-{{ $newsletter->id }}">Edit</a></li>
                                                    <li>
                                                        <form action="{{ route('ProfNewsletters.destroy', $newsletter->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this newsletter?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash-alt"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>

                                            <!-- Newsletter Content -->
                                            <h5 class="mb-4">{{ $newsletter->title }}</h5>
                                            <p>{{ Str::limit($newsletter->content, 150) }}</p>

                                            <!-- Newsletter Image -->
                                            <img src="{{ asset('storage/' . $newsletter->image) }}" alt="Newsletter Image" class="img-fluid rounded mb-4" width="100%" style="max-height: 400px; object-fit: cover;">

                                            <!-- Display Like and Comment Count -->
                                            <p class="text-muted mb-2">
                                                <i class="fa fa-thumbs-up" style="color: {{ $newsletter->user_liked ? 'red' : 'gray' }};"></i>
                                                {{ $newsletter->likes_count }} Likes |
                                                <i class="fa fa-comments"></i> {{ $newsletter->comments_count }} Comments
                                            </p>

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
                <header id="header" style=" top: calc(50px + 2rem); left: 0;">
                    <nav class="nav-menu" style="position: absolute;">
                        <ul>
                            <li>
                                <a href="{{ route('home') }}" >
                                    <i class="fas fa-home"></i>
                                    <span>Home</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('UserProfile.edit') }}">
                                    <i class="fas fa-user"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('UserMotorcycles.index') }}">
                                    <i class="fas fa-motorcycle"></i>
                                    <span>Motorcycles</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('events.UserIndex') }}">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Events</span>
                                </a>
                            </li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="nav-link">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </nav>
                </header>

            </div>

            <style>
                :root {
                    --nav-color: #e05100;
                    --nav-font: "Poppins", sans-serif;
                    --default-color: #45505b;
                    --contrast-color: #fff;
                    --nav-hover-color: #008FE0;
                }

                #header {
                    position: fixed;
                    z-index: 9997;
                    padding: 15px;
                    top: 350px;
                }

                @media (max-width: 991px) {
                    #header {
                        position: relative;
                        top: 0;
                        padding: 15px 0;
                    }

                    .container-fluid {
                        padding-left: 15px;
                    }
                }


                .nav-menu {
                    padding: 0;
                    z-index: 1;
                }

                .nav-menu ul {
                    list-style: none;
                    padding: 0 0 20px 0;
                    margin: 0;
                    width: 140px;
                }

                .nav-menu a,
                .nav-menu a:focus,
                .nav-menu button.nav-link {
                    color: var(--nav-color);
                    font-family: var(--nav-font);
                    display: flex;
                    align-items: center;
                    padding: 10px 18px;
                    margin-bottom: 8px;
                    font-size: 15px;
                    border-radius: 50px;
                    background: color-mix(in srgb, var(--default-color), transparent 92%);
                    height: 56px;
                    width: 100%;
                    overflow: hidden;
                    transition: 0.3s;
                    border: none;
                    cursor: pointer;
                    text-decoration: none;
                }

                .nav-menu a i,
                .nav-menu a:focus i,
                .nav-menu button.nav-link i {
                    font-size: 20px;
                }

                .nav-menu a span,
                .nav-menu a:focus span,
                .nav-menu button.nav-link span {
                    padding: 0 5px 0 7px;
                }

                @media (min-width: 992px) {
                    .nav-menu a,
                    .nav-menu a:focus,
                    .nav-menu button.nav-link {
                        max-width: 56px;
                    }

                    .nav-menu a span,
                    .nav-menu a:focus span,
                    .nav-menu button.nav-link span {
                        display: none;
                    }
                }

                .nav-menu a:hover,
                .nav-menu .active,
                .nav-menu .active:focus,
                .nav-menu li:hover > a,
                .nav-menu button.nav-link:hover {
                    color: var(--contrast-color);
                    background: var(--nav-hover-color);
                    max-width: 100%;
                }

                .nav-menu a:hover span,
                .nav-menu li:hover > a span,
                .nav-menu button.nav-link:hover span {
                    display: block;
                }
                /* Profile Page Styling */
                .container-fluid {
                    font-family: 'Poppins', sans-serif;
                }

                .info-user {
                    margin-top: -50px;
                }

                /* Profile Image */
                img.rounded-circle {
                    border: 4px solid #007bff;
                    margin-top: -120px;
                    transition: transform 0.3s ease-in-out, border-color 0.3s ease-in-out;
                }

                img.rounded-circle:hover {
                    transform: scale(1.1);
                    border-color: #0056b3;
                }
                .info-user {
                    margin-top: -50px;
                    margin-left: 20px; /* Adds space to the left */
                }

            </style>

        </div>
    </div>
@endsection


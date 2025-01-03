@section('content')
    <div class="container-fluid py-5">
        <div class="row g-4 d-flex align-items-stretch">
            {{-- Total Events Card --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-lg transform-hover h-100" style="background: linear-gradient(135deg, var(--primary) 0%, color-mix(in srgb, var(--primary), white 20%) 100%);">
                    <div class="card-body text-white p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-calendar-event me-2 fs-4"></i>
                                <h5 class="card-title mb-0 fw-bold">Total Events</h5>
                            </div>
                            <h2 class="card-text display-6 fw-bold mb-1 total-events">{{ $totalEvents ?? 0 }}</h2>
                            <small class="text-light-subtle opacity-75 event-change">
                                <i class="bi bi-arrow-up text-success me-1"></i>
                                {{ $eventChange ?? '0.00' }}% from yesterday
                            </small>
                        </div>
                        <div class="mt-3 border-top pt-2 opacity-75">
                            <small>Updated just now</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Rentals Card --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-lg transform-hover h-100" style="background: linear-gradient(135deg, var(--secondary) 0%, color-mix(in srgb, var(--secondary), white 20%) 100%);">
                    <div class="card-body text-white p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa-solid fa-motorcycle me-2 fs-4"></i>
                                <h5 class="card-title mb-0 fw-bold">Total Rentals</h5>
                            </div>
                            <h2 class="card-text display-6 fw-bold mb-1 total-rentals">{{ $totalRentals ?? 0 }}</h2>
                            <small class="text-light-subtle opacity-75 rental-change">
                                <i class="bi bi-arrow-up text-success me-1"></i>
                                {{ $rentalChange ?? '0.00' }}% from yesterday
                            </small>
                        </div>
                        <div class="mt-3 border-top pt-2 opacity-75">
                            <small>Updated just now</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Users Card --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-lg transform-hover h-100" style="background: linear-gradient(135deg, var(--dark) 0%, color-mix(in srgb, var(--dark), white 20%) 100%);">
                    <div class="card-body text-white p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-people me-2 fs-4"></i>
                                <h5 class="card-title mb-0 fw-bold">Total Users</h5>
                            </div>
                            <h2 class="card-text display-6 fw-bold mb-1 total-users">{{ $totalUsers ?? 0 }}</h2>
                            <small class="text-light-subtle opacity-75 user-change">
                                <i class="bi bi-arrow-up text-success me-1"></i>
                                {{ $userChange ?? '0.00' }}% from yesterday
                            </small>
                        </div>
                        <div class="mt-3 border-top pt-2 opacity-75">
                            <small>Updated just now</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total News Card --}}
            <div class="col-md-3">
                <div class="card border-0 shadow-lg transform-hover h-100" style="background: linear-gradient(135deg, var(--light) 0%, color-mix(in srgb, var(--light), black 20%) 100%);">
                    <div class="card-body text-dark p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-newspaper me-2 fs-4"></i>
                                <h5 class="card-title mb-0 fw-bold">Total News</h5>
                            </div>
                            <h2 class="card-text display-6 fw-bold mb-1 total-news">{{ $totalNews ?? 0 }}</h2>
                            <small class="text-muted opacity-75 news-change">
                                <i class="bi bi-arrow-up text-success me-1"></i>
                                {{ $newsChange ?? '0.00' }}% from yesterday
                            </small>
                        </div>
                        <div class="mt-3 border-top pt-2 opacity-75">
                            <small>Updated just now</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .transform-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .transform-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
        }

        .text-light-subtle {
            color: rgba(255, 255, 255, 0.7);
        }

        .h-100 {
            height: 100%; /* Ensures all cards are the same height */
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fetch dashboard stats dynamically
            fetch('/api/dashboard-stats')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('.total-events').textContent = data.totalEvents;
                    document.querySelector('.event-change').textContent = `${data.eventChange}%`;

                    document.querySelector('.total-rentals').textContent = data.totalRentals;
                    document.querySelector('.rental-change').textContent = `${data.rentalChange}%`;

                    document.querySelector('.total-users').textContent = data.totalUsers;
                    document.querySelector('.user-change').textContent = `${data.userChange}%`;

                    document.querySelector('.total-news').textContent = data.totalNews;
                    document.querySelector('.news-change').textContent = `${data.newsChange}%`;
                })
                .catch(error => console.error('Error fetching dashboard stats:', error));
        });
    </script>
@endsection

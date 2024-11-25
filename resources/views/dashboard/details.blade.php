@section('content')
    <div class="container-fluid py-5">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-lg transform-hover" style="background: linear-gradient(135deg, var(--primary) 0%, color-mix(in srgb, var(--primary), white 20%) 100%);">
                    <div class="card-body text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar-event me-2 fs-4"></i>
                                    <h5 class="card-title mb-0 fw-bold">Total Events</h5>
                                </div>
                                <h2 class="card-text display-6 fw-bold mb-1">{{ $totalEvents ?? 0 }}</h2>
                                <small class="text-light-subtle opacity-75">
                                    <i class="bi bi-arrow-up text-success me-1"></i>
                                    {{ $eventChange ?? '0.00' }}% from yesterday
                                </small>
                            </div>
                            <div class="icon opacity-50">
                                <i class="bi bi-calendar-event fs-1"></i>
                            </div>
                        </div>
                        <div class="mt-3 border-top pt-2 opacity-75">
                            <small>Updated just now</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-lg transform-hover" style="background: linear-gradient(135deg, var(--secondary) 0%, color-mix(in srgb, var(--secondary), white 20%) 100%);">
                    <div class="card-body text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-motorcycle me-2 fs-4"></i>
                                    <h5 class="card-title mb-0 fw-bold">Total Rentals</h5>
                                </div>
                                <h2 class="card-text display-6 fw-bold mb-1">{{ $totalRentals ?? 0 }}</h2>
                                <small class="text-light-subtle opacity-75">

                                    <i class="bi bi-arrow-up text-success me-1"></i>
                                    {{ $rentalChange ?? '0.00' }}% from yesterday
                                </small>
                            </div>
                            <div class="icon opacity-50">
                                <i class="fa-solid fa-motorcycle  fs-1"></i>

                            </div>
                        </div>
                        <div class="mt-3 border-top pt-2 opacity-75">
                            <small>Updated just now</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-lg transform-hover" style="background: linear-gradient(135deg, var(--dark) 0%, color-mix(in srgb, var(--dark), white 20%) 100%);">
                    <div class="card-body text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-people me-2 fs-4"></i>
                                    <h5 class="card-title mb-0 fw-bold">Total Users</h5>
                                </div>
                                <h2 class="card-text display-6 fw-bold mb-1">{{ $totalUsers ?? 0 }}</h2>
                                <small class="text-light-subtle opacity-75">
                                    <i class="bi bi-arrow-up text-success me-1"></i>
                                    {{ $userChange ?? '0.00' }}% from yesterday
                                </small>
                            </div>
                            <div class="icon opacity-50">
                                <i class="bi bi-people fs-1"></i>
                            </div>
                        </div>
                        <div class="mt-3 border-top pt-2 opacity-75">
                            <small>Updated just now</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-lg transform-hover" style="background: linear-gradient(135deg, var(--light) 0%, color-mix(in srgb, var(--light), black 20%) 100%);">
                    <div class="card-body text-dark p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-newspaper me-2 fs-4"></i>
                                    <h5 class="card-title mb-0 fw-bold">Total News</h5>
                                </div>
                                <h2 class="card-text display-6 fw-bold mb-1">{{ $totalNews ?? 0 }}</h2>
                                <small class="text-muted opacity-75">
                                    <i class="bi bi-arrow-up text-success me-1"></i>
                                    {{ $newsChange ?? '0.00' }}% from yesterday
                                </small>
                            </div>
                            <div class="icon opacity-50">
                                <i class="bi bi-newspaper fs-1"></i>
                            </div>
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
            box-shadow: 0 1rem 3rem rgba(0,0,0,0.175) !important;
        }
        .text-light-subtle {
            color: rgba(255,255,255,0.7);
        }
    </style>
@endsection

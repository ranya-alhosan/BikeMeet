@extends('theme.master')
@section('hero-title','About')

@section('about-active','active')

@section('content')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 pt-4" style="min-height: 400px;">
                    <div class="position-relative h-100 wow fadeIn" data-wow-delay="0.1s">
                        <img class="position-absolute img-fluid w-100 h-100" src="{{asset('assets')}}/img/aboutImage.jpg" style="object-fit: cover;" alt="">
                        <div class="position-absolute top-0 end-0 mt-n4 me-n4 py-4 px-5" style="background: rgba(0, 0, 0, .08);">
                            <h1 class="display-4 text-white mb-0">BikeMeet</h1>
                            <h4 class="text-white">The Ultimate Motorcycle Community</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h6 class="text-primary text-uppercase">// About Us //</h6>
                    <h1 class="mb-4"><span class="text-primary">BikeMeet</span> Is The Best Place For Motorcycle Lovers</h1>
                    <p class="mb-4">BikeMeet is an innovative platform designed to connect motorcycle enthusiasts, organize events, and facilitate motorcycle rentals. The primary goal of BikeMeet is to simplify and enhance communication between riders while eliminating the inefficiencies and chaos often seen in unorganized groups. We provide a one-stop solution for enthusiasts to communicate, collaborate, and share their passion in a more efficient and enjoyable manner.</p>
                    <div class="row g-4 mb-3 pb-3">
                        <div class="col-12 wow fadeIn" data-wow-delay="0.1s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1" style="width: 45px; height: 45px;">
                                    <span class="fw-bold text-secondary">01</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Faster & Easier Communication</h6>
                                    <span>Our platform connects riders instantly and seamlessly, creating a more efficient communication network.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeIn" data-wow-delay="0.3s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1" style="width: 45px; height: 45px;">
                                    <span class="fw-bold text-secondary">02</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Event Organization</h6>
                                    <span>Stay up to date with the latest motorcycle events and rallies organized by our community.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeIn" data-wow-delay="0.5s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1" style="width: 45px; height: 45px;">
                                    <span class="fw-bold text-secondary">03</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Motorcycle Rentals</h6>
                                    <span>Rent and list motorcycles effortlessly, creating new opportunities for riders and rental providers alike.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="" class="btn btn-primary py-3 px-5">Learn More<i class="fa fa-arrow-right ms-3"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Fact Start -->
    <div class="container-fluid fact bg-dark my-5 py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Total Users -->
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                    <i class="fa fa-users fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">{{ $totalUsers }}</h2>
                    <p class="text-white mb-0">Total Users</p>
                </div>
                <!-- Total Rentals -->
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                    <i class="fa fa-motorcycle fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">{{ $totalRentals }}</h2>
                    <p class="text-white mb-0">Total Rentals</p>
                </div>
                <!-- Total Events -->
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                    <i class="fa fa-calendar fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">{{ $totalEvents }}</h2>
                    <p class="text-white mb-0">Total Events</p>
                </div>
                <!-- Total Newsletters -->
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
                    <i class="fa fa-newspaper fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">{{ $totalNewsletters }}</h2>
                    <p class="text-white mb-0">Total Newsletters</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->

    <!-- Testimonial Start -->

    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase ">// Testimonials //</h6>
            </div>
            <div class="row g-5 align-items-center mt-3">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="row g-0 about-bg rounded overflow-hidden">
                        <div class="col-6 text-start">
                            <img class="img-fluid w-100" src="{{asset('assets')}}/img/about4.jpg">
                        </div>
                        <div class="col-6 text-start">
                            <img class="img-fluid" src="{{asset('assets')}}/img/hero-img.jpg" style="width: 85%;height: 200px; margin-top: 15%;">
                        </div>
                        <div class="col-6 text-end">
                            <img class="img-fluid" src="{{asset('assets')}}/img/hero-img2.jpg" style="width: 85%;">
                        </div>
                        <div class="col-6 text-end">
                            <img class="img-fluid w-100" src="{{asset('assets')}}/img/a.jpg" style="height: 350px;margin-top:-35px" >
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="mb-4">What Our Community Says</h1>
                    <p class="mb-4">We love hearing from our community! Share your thoughts and experiences with us. Your testimonial can inspire others to join the community.</p>
                    <form action="{{ route('testimonials.store') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" readonly>
                                    <label for="name">Your Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="Motorcycle Lover">Motorcycle Lover</option>
                                        <option value="Motorcycle Renter">Motorcycle Renter</option>
                                        <option value="Event Organizer">Event Organizer</option>
                                    </select>
                                    <label for="role">Your Role</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="text" name="text" required></textarea>
                                    <label for="text">Testimonial</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="submit">Submit Testimonial</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->

    <!-- Team Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase">// Our Technicians //</h6>
                <h1 class="mb-5">Our Expert Technicians</h1>
            </div>
            <div class="row g-4">
                <div class="col-lg-8 col-md-10 col-sm-12 mx-auto wow fadeInUp" data-wow-delay="0.1s">
                    <div class="team-item d-flex flex-column flex-md-row align-items-center p-3 shadow-lg rounded bg-light" style="overflow: hidden;">
                        <!-- Image Section -->
                        <div class="position-relative overflow-hidden flex-shrink-0 rounded mb-3 mb-md-0" style="width: 100%; max-width: 250px; height: auto;">
                            <img class="img-fluid w-100 h-100" src="{{asset('assets')}}/img/rania.jpg" alt="Ranya Al-Hosan" style="object-fit: cover;">
                            <div class="team-overlay position-absolute start-0 top-0 w-100 h-100 d-flex justify-content-center align-items-center">
                                <a class="btn btn-square mx-1" href="https://github.com/ranya-alhosan" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a class="btn btn-square mx-1" href="https://www.linkedin.com/in/ranya-al-hosan-370634264/" target="_blank">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Text Section -->
                        <div class="p-4 flex-grow-1 text-center text-md-start">
                            <h3 class="fw-bold mb-2 text-primary">Ranya Al-Hosan</h3>
                            <small class="d-block text-muted mb-4">Full-Stack Developer</small>
                            <p class="text-muted">
                                Growing up,<span class="imp">my father’s passion</span>  for motorcycles inspired me deeply. I noticed how bikers struggled to organize events and communicate effectively through scattered platforms like WhatsApp. This sparked an idea: to create a seamless, organized solution that brings motorcycle enthusiasts together.
                            </p>
                            <p class="text-muted">
                                With this project,<span class="imp">I envision a global community</span>  where bikers can effortlessly connect, share their passion, and organize events with ease. It’s not just a platform—it’s a celebration of the biking lifestyle and a way to strengthen the bonds within this incredible community.
                            </p>
                            <div class="text-center text-md-end">
                                <a class="btn btn-primary btn-sm px-4 rounded-pill" href="https://www.linkedin.com/in/ranya-al-hosan-370634264/" target="_blank">Know More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->





    <div class="text-center mt-5">
        <h3 class="mb-3">Join Our Club</h3>
        <p>Become a part of our vibrant motorcycling community! Sign up for our newsletter or check out our upcoming events.</p>
        <a href="#" class="btn btn-primary px-5 py-2">Explore Events</a>
    </div>
    <!-- About the Creator End -->


    <!-- SweetAlert Success Message -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Testimonial Submitted',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    <style>
        #text {
            resize: none; /* Prevent resizing of the textarea */
            overflow: hidden; /* Hide the scrollbar */
            height: 100px; /* Set a fixed height to make it scrollable */
        }

        #text::-webkit-scrollbar {
            display: none; /* Hide scrollbar in Webkit browsers */
        }

        #text {
            -ms-overflow-style: none; /* Hide scrollbar in IE and Edge */
            scrollbar-width: none; /* Hide scrollbar in Firefox */
        }

        .about-bg {
            background-image: -webkit-repeating-radial-gradient(center center, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) 1px, transparent 1px, transparent 100%);
            background-image: -moz-repeating-radial-gradient(center center, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) 1px, transparent 1px, transparent 100%);
            background-image: -ms-repeating-radial-gradient(center center, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) 1px, transparent 1px, transparent 100%);
            background-image: -o-repeating-radial-gradient(center center, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) 1px, transparent 1px, transparent 100%);
            background-image: repeating-radial-gradient(center center, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) 1px, transparent 1px, transparent 100%);
            background-size: 5px 5px;
        }

        .btn-primary {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* Smooth Hover Effect for Team Members */
        .team-overlay {
            transition: opacity 0.3s ease-in-out;
        }
        .team-overlay:hover {
            opacity: 1;
        }

        /* Form Design */
        .form-floating {
            margin-bottom: 15px;
        }

        /* Add a shadow to the testimonial form button */
        .btn-primary {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .btn-primary:focus {
            outline: none;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
    </style>

@endsection

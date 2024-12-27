@extends('theme.master')
@section('index-active','active')
@section('content')
    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Newsletter Service -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="d-flex py-5 px-4">
                        <i class="fa fa-newspaper fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Latest Biker News</h5>
                            <p>Stay updated with the latest news, tips, and exciting updates from the biking world. Share your thoughts and get involved in the community.</p>
                            <a class="text-secondary border-bottom" href="{{ route('UserNewsletters.index') }}">Read More</a>
                        </div>
                    </div>
                </div>
                <!-- Rent Motorcycles Service -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="d-flex bg-light py-5 px-4">
                        <i class="fa fa-motorcycle fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Rent Your Dream Bike</h5>
                            <p>Discover the perfect motorcycle for your next adventure. Whether renting for a weekend ride or testing a new model, we’ve got you covered!</p>
                            <a class="text-secondary border-bottom" href="{{ route('rentals.showRentals') }}">Read More</a>
                        </div>
                    </div>
                </div>
                <!-- Events Service -->
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="d-flex py-5 px-4">
                        <i class="fa fa-calendar-check fa-3x text-primary flex-shrink-0"></i>
                        <div class="ps-4">
                            <h5 class="mb-3">Join Our Biker Events</h5>
                            <p>Be a part of exciting biker events, gatherings, and activities. Share your passion, meet fellow bikers, and participate in thrilling rides.</p>
                            <a class="text-secondary border-bottom" href="{{ route('events.UserIndex') }}">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

    <!-- Latest Events Section -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-primary text-uppercase">// Latest Events //</h6>
                <h1>Unforgettable Moments You Can't Miss</h1>
            </div>
            <div class="row g-4">
                @foreach($events as $event)
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="event-card">
                            <!-- Event Tag -->
                            <div class="event-tag">{{ $event->category ?? 'General' }}</div>

                            <!-- Event Image -->
                            <img src="{{ $event->image_url ?? 'https://via.placeholder.com/400x180' }}" alt="Event Image">

                            <!-- Event Info -->
                            <div class="event-info">
                                <h5>{{ $event->title }}</h5>
                                <p>{{ Str::limit($event->description, 100) }}</p>
                                <a
                                    href="{{ auth()->check() ? route('events.showEventDetails', $event->id) : route('login') }}"
                                    class="btn"
                                >
                                    Learn More
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 pt-4" style="min-height: 400px;">
                    <div class="position-relative h-100 wow fadeIn" data-wow-delay="0.1s">
                        <img class="position-absolute img-fluid w-100 h-100" src="{{asset('assets')}}/img/home-img.jpg" style="object-fit: cover;" alt="BikeMeet">
                        <div class="position-absolute top-0 end-0 mt-n4 me-n4 py-4 px-5" style="background: rgba(0, 0, 0, .08);">
                            <h1 class="display-4 text-white mb-0">5 <span class="fs-4">Years</span></h1>
                            <h4 class="text-white">Connecting Riders</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h6 class="text-primary text-uppercase">// About Us //</h6>
                    <h1 class="mb-4"><span class="text-primary">BikeMeet</span> - Your Ultimate Motorcycle Community</h1>
                    <p class="mb-4">BikeMeet is more than just a platform—it's a lifestyle for motorcycle lovers. Whether you’re looking to connect with fellow bikers, join thrilling events, or rent your dream motorcycle, BikeMeet is here to make it all easy and enjoyable.</p>
                    <div class="row g-4 mb-3 pb-3">
                        <div class="col-12 wow fadeIn" data-wow-delay="0.1s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1" style="width: 45px; height: 45px;">
                                    <span class="fw-bold text-secondary">01</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Seamless Connections</h6>
                                    <span>Connect with riders from around the world and build lifelong friendships.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeIn" data-wow-delay="0.3s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1" style="width: 45px; height: 45px;">
                                    <span class="fw-bold text-secondary">02</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Exciting Events</h6>
                                    <span>Discover and join organized motorcycle events tailored for you.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeIn" data-wow-delay="0.5s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1" style="width: 45px; height: 45px;">
                                    <span class="fw-bold text-secondary">03</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Hassle-Free Rentals</h6>
                                    <span>Easily rent and offer motorcycles through our trusted platform.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{route('rentals.showRentals')}}" class="btn btn-primary py-3 px-5">Join the Ride <i class="fa fa-arrow-right ms-3"></i></a>
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
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="text-primary text-uppercase">// What Our Members Say //</h6>
                <h1 class="mb-5">Hear From Our Happy Riders!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                @foreach ($testimonials as $testimonial)
                    <div class="testimonial-item text-center">
                        <img class="bg-light rounded-circle p-2 mx-auto mb-3"
                             src="{{ asset($testimonial['image']) }}"
                             style="width: 80px; height: 80px;">
                        <h5 class="mb-0">{{ $testimonial['name'] }}</h5>
                        <p>{{ $testimonial['role'] }}</p>
                        <div class="testimonial-text bg-light text-center p-4">
                            <p class="mb-0">{{ $testimonial['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>



    <style>
        /* General Styles */
        .testimonial-text {
            min-height: 120px; /* Set a minimum height for consistency */
            max-height: 120px; /* Optional: Limit the maximum height */
            display: flex; /* Enable flexbox for alignment */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            overflow: hidden; /* Prevent overflow if the content is longer */
            text-overflow: ellipsis; /* Add ellipsis if the text is too long */
        }
        .event-card {
            position: relative;
            overflow: hidden;
            height: 100%;
            background: linear-gradient(135deg, #fff, #f7f7f7);
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Card Hover Effect */
        .event-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        /* Event Image */
        .event-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        /* Event Info Section */
        .event-info {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
        }

        .event-info h5 {
            font-size: 1.3rem;
            color: #333;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .event-info p {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        /* Button Style */
        .event-info .btn {
            align-self: flex-start;
            padding: 10px 20px;
            background:  #e05100;
            color: white;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }



        /* Ribbon/Tag Effect */
        .event-card .event-tag {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #e05100;
            color: white;
            padding: 5px 15px;
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 20px;
            z-index: 1;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Add Hover Glow Effect */
        .event-card:hover .event-tag {
            box-shadow: 0 6px 12px rgb(224, 81, 0);
        }
    </style>


@endsection



@extends('theme.master')
@section('hero-title','About')

@section('about-active','active')

@section('content')

    <!-- Hero Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center">
                <p class="lead">A community dedicated to motorcycle enthusiasts!</p>
            </div>
        </div>
    </div>
    <!-- Hero End -->

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
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                    <i class="fa fa-users fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">BikeMeet</h2>
                    <p class="text-white mb-0">The Ultimate Community</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                    <i class="fa fa-users-cog fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">5000+</h2>
                    <p class="text-white mb-0">Members Connected</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                    <i class="fa fa-calendar fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">100+</h2>
                    <p class="text-white mb-0">Events Organized</p>
                </div>
                <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
                    <i class="fa fa-motorcycle fa-2x text-white mb-3"></i>
                    <h2 class="text-white mb-2" data-toggle="counter-up">1500+</h2>
                    <p class="text-white mb-0">Motorcycles Rented</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Fact End -->

    <!-- About the Creator Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase">// About the Creator //</h6>
                <h1 class="mb-5">My Journey as a Developer</h1>
                <p class="lead">I am a passionate developer with a strong interest in building innovative and efficient platforms. As a graduate of Orange Academy for Programming, I have honed my skills in full-stack development, focusing on creating seamless, user-friendly experiences. Throughout my journey, I have worked with Laravel for the backend, leveraging its robust features to create secure, scalable, and efficient web applications. For the frontend, I have used React to create dynamic, responsive interfaces that provide an engaging experience for users.</p>
                <p class="lead">With BikeMeet, I have combined my love for motorcycles with my technical expertise, creating a platform that serves the needs of motorcycle enthusiasts. By using tools like Laravel, React, and modern development practices, I aimed to provide a solution that improves the way riders communicate, organize events, and rent motorcycles.</p>
                <img src="{{ asset('assets') }}/img/creator.jpg" alt="Developer Photo" class="img-fluid rounded-circle mb-4" style="width: 200px;">
                <p class="lead">This platform is not just a technical achievement, but a product of my passion for programming and motorcycles. I’ve learned a great deal about both the technical and the creative aspects of development, and I look forward to building more impactful projects in the future.</p>
            </div>
        </div>
    </div>
    <!-- About the Creator End -->

@endsection

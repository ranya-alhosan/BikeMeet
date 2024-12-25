<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="{{ asset('assets') }}/img/heroE2.jpg" alt="Image" height="600px">
                <div class="carousel-caption d-flex align-items-center">
                    <div class="container">
                        <div class="row align-items-center justify-content-center justify-content-lg-start">
                            <div class="col-10 col-lg-7 text-center text-lg-start">
                                <h6 class="text-white text-uppercase mb-3 animated slideInDown">// Join BikeMeet //</h6>
                                <h3 class="display-4 text-white mb-4 pb-3 animated slideInDown">Ride with Passion, Rent with Ease</h3>
                                <p class="text-white mb-4 animated fadeIn">Explore top-quality motorcycles and join a vibrant biking community.</p>
                                <a href="{{ route('rentals.showRentals') }}" class="btn btn-primary py-3 px-5 animated slideInDown">Browse Motorcycles<i class="fa fa-arrow-right ms-3"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="w-100" src="{{ asset('assets') }}/img/heroE.jpg" alt="Image" height="600px">
                <div class="carousel-caption d-flex align-items-center">
                    <div class="container">
                        <div class="row align-items-center justify-content-center justify-content-lg-start">
                            <div class="col-10 col-lg-7 text-center text-lg-start">
                                <h6 class="text-white text-uppercase mb-3 animated slideInDown">// Ride with Us //</h6>
                                <h3 class="display-4 text-white mb-4 pb-3 animated slideInDown">Join the Ultimate Biker Community</h3>
                                <a href="{{ route('rentals.showRentals') }}" class="btn btn-primary py-3 px-5 animated slideInDown">Start Your Journey<i class="fa fa-arrow-right ms-3"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hide the carousel control arrows -->
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<!-- Carousel End -->

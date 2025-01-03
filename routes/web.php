<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MotorcycleController;
use App\Http\Controllers\EventEnrollmentController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\DashboardController;

//
//Route::get('/', function () {
//    return view('theme.index');
//})->name('home');




Route::middleware(['auth', 'role:admin'])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard.main');
//    })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/api/dashboard-stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');

    Route::resource('users', UsersController::class);

    Route::resource('events', EventController::class);
    Route::resource('enrollment', EventEnrollmentController::class);
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    Route::resource('rentals',RentalController::class);
    Route::get('/rentals/create', [RentalController::class, 'create'])->name('rentals.create');
    Route::get('/motorcycles/{userId}', [RentalController::class, 'getMotorcyclesByUser'])->name('motorcycles.by-user');

    Route::resource('motorcycles', MotorcycleController::class);

    Route::resource('contacts', ContactController::class);

    Route::resource('newsletters', NewsletterController::class);
    Route::post('newsletters/{id}/like', [NewsletterController::class, 'like'])->name('newsletters.like');
    Route::post('newsletters/{id}/comment', [NewsletterController::class, 'comment'])->name('newsletters.comment');
    Route::delete('/DashNewsletters/{newsletter}', [NewsletterController::class, 'destroyNews'])->name('DashNewsletters.destroy');
    Route::get('/DashNewsletters/{newsletter}/edit', [NewsletterController::class, 'DashEdit'])->name('DashNewsletters.edit');
    Route::put('/DashNewsletters/{newsletter}', [NewsletterController::class, 'DashUpdate'])->name('DashNewsletters.update');
    Route::delete('/DashComments/{comment}', [NewsletterController::class, 'destroyComment'])->name('DashComments.destroy');
    Route::get('/DashNewsletters/create', [NewsletterController::class, 'DashCreate'])->name('DashNewsletters.create');
    Route::post('/DashNewsletters', [NewsletterController::class, 'DashStore'])->name('DashNewsletters.store');

});


Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/createRentals', [RentalController::class, 'create'])->name('rentals.createRentals');
    Route::post('/storeRentals', [RentalController::class, 'store'])->name('rentals.storeRentals');
    Route::post('/rentals/{rental}/proceed', [RentalController::class, 'proceedToRent'])->name('rentals.proceed');

    Route::post('/UserNewsletter/{newsletter}/like', [NewsletterController::class, 'like'])->name('UserNewsletter.like');
    Route::post('/UserNewsletter/{newsletter}/comment', [NewsletterController::class, 'comment'])->name('UserNewsletter.comment');
    Route::delete('/UserComments/{id}', [NewsletterController::class, 'destroy'])->name('UserNewsletter.comment.delete');
    Route::patch('/UserComments/{id}', [NewsletterController::class, 'update'])->name('UserNewsletter.comment.update');
    Route::post('/UserNewsletters', [NewsletterController::class, 'store'])->name('UserNewsletter.store');
    Route::get('/UserNewsletters/search', [NewsletterController::class, 'search'])->name('UserNewsletters.search');

    Route::post('/events/{event}/enroll', [EventController::class, 'enroll'])->name('events.enroll');
    Route::get('/createEvent', [EventController::class, 'create'])->name('UserEvents.create');
    Route::post('/UserEvents/store', [EventController::class, 'store'])->name('events.UserStore');


    Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
    Route::get('/UserProfile/edit', [UsersController::class, 'UserEdit'])->name('UserProfile.edit');
    Route::put('/UserProfile/update', [UsersController::class, 'UserUpdate'])->name('UserProfile.update');
    Route::get('/user-newsletters', [UsersController::class, 'showUserNewsletters'])->name('ProfNewsletters.index');
    Route::put('/ProfNewsletters/{id}', [UsersController::class, 'updateNewsletter'])->name('ProfNewsletters.update');
    Route::delete('/ProfNewsletters/{id}', [UsersController::class, 'destroyNewsletter'])->name('ProfNewsletters.destroy');
    Route::post('/ProfNewsletters/{id}/like', [UsersController::class, 'toggleLike'])->name('ProfNewsletters.like');
    Route::post('/ProfNewsletters/{id}/comment', [UsersController::class, 'addComment'])->name('ProfNewsletters.comment');

    Route::get('/user/motorcycles', [MotorcycleController::class, 'userMotorcycles'])->name('UserMotorcycles.index');
    Route::get('/UserMotorcycles/{motorcycle}/edit', [MotorcycleController::class, 'edit'])->name('UserMotorcycles.edit');
    Route::put('/UserMotorcycles/{motorcycle}', [MotorcycleController::class, 'updateMotor'])->name('UserMotorcycles.update');
    Route::delete('/UserMotorcycles/{motorcycle}', [MotorcycleController::class, 'destroy'])->name('UserMotorcycles.destroy');
    Route::post('/UserMotorcycles/store', [MotorcycleController::class, 'store'])->name('UserMotorcycles.store');

    Route::resource('testimonials', TestimonialController::class);

});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate(); // Invalidate the session
        request()->session()->regenerateToken(); // Regenerate the CSRF token
        return redirect()->route('login'); // Redirect to the login page
    })->name('logout');

});

Route::get('/', [EventController::class, 'latestEvents'])->name('home');
Route::get('/showContacts', [ContactController::class,'index' ])->name('user.showContact');
Route::post('/UserContacts', [ContactController::class,'store' ])->name('user.storeContact');
Route::controller(ThemeController::class)->name('theme.')->group(function () {
    Route::get('/testimonial', 'testimonial')->name('testimonial');
});
Route::get('/login', function () {
    return view('dashboard.login');
})->name('login');
Route::get('/about',[ThemeController::class,'about'])->name('about');
Route::get('/testimonials', [TestimonialController::class, 'showTestimonials'])->name('testimonials.index');
Route::get('/showRentals', [RentalController::class, 'showRentals'])->name('rentals.showRentals');
Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.showRentDetails');
Route::get('/UserNewsletters', [NewsletterController::class, 'indexUser'])->name('UserNewsletters.index');
Route::get('/UserEvents', [EventController::class, 'indexUser'])->name('events.UserIndex');
Route::get('/UserEvents/{id}', [EventController::class, 'showDetails'])->name('events.showEventDetails');


require __DIR__ . '/auth.php';

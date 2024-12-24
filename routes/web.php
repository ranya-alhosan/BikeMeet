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





// Public Routes
Route::get('/', function () {
    return view('theme.index');
})->name('home');

Route::get('/showContacts', [ContactController::class,'index' ])->name('user.showContact');
Route::post('/UserContacts', [ContactController::class,'store' ])->name('user.storeContact');

// Public pages handled by ThemeController
Route::controller(ThemeController::class)->name('theme.')->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/testimonial', 'testimonial')->name('testimonial');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('dashboard.login'); // Your login view
    })->name('login');
});




// Authenticated and role-based routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.main'); // Admin dashboard view
    })->name('dashboard');
    Route::resource('users', UsersController::class);
    Route::resource('events', EventController::class);
    Route::resource('rentals',RentalController::class);
    Route::resource('motorcycles', MotorcycleController::class);
    Route::resource('newsletters', NewsletterController::class);
    Route::get('/rentals/create', [RentalController::class, 'create'])->name('rentals.create');
    Route::get('/motorcycles/{userId}', [RentalController::class, 'getMotorcyclesByUser'])->name('motorcycles.by-user');
    Route::post('newsletters/{id}/like', [NewsletterController::class, 'like'])->name('newsletters.like');
    Route::post('newsletters/{id}/comment', [NewsletterController::class, 'comment'])->name('newsletters.comment');
    Route::resource('contacts', ContactController::class);
    Route::resource('enrollment', EventEnrollmentController::class);

    Route::delete('/DashNewsletters/{newsletter}', [NewsletterController::class, 'destroyNews'])->name('DashNewsletters.destroy');
    Route::get('/DashNewsletters/{newsletter}/edit', [NewsletterController::class, 'DashEdit'])->name('DashNewsletters.edit');
    Route::put('/DashNewsletters/{newsletter}', [NewsletterController::class, 'DashUpdate'])->name('DashNewsletters.update');
    // Route to delete the comment
    Route::delete('/DashComments/{comment}', [NewsletterController::class, 'destroyComment'])->name('DashComments.destroy');
    Route::get('/DashNewsletters/create', [NewsletterController::class, 'DashCreate'])->name('DashNewsletters.create');
    Route::post('/DashNewsletters', [NewsletterController::class, 'DashStore'])->name('DashNewsletters.store');

});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/showRentals', [RentalController::class, 'showRentals'])->name('rentals.showRentals');
    Route::get('/createRentals', [RentalController::class, 'create'])->name('rentals.createRentals');
    Route::post('/storeRentals', [RentalController::class, 'store'])->name('rentals.storeRentals');
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.showRentDetails');
    Route::post('/rentals/{rental}/proceed', [RentalController::class, 'proceedToRent'])->name('rentals.proceed');

    Route::get('/UserEvents', [EventController::class, 'index'])->name('events.UserIndex');
    Route::get('/UserEvents/{id}', [EventController::class, 'showDetails'])->name('events.showEventDetails');
    Route::post('/events/{event}/enroll', [EventController::class, 'enroll'])->name('events.enroll');
    Route::get('/createEvent', [EventController::class, 'create'])->name('UserEvents.create');
    Route::post('/UserEvents/store', [EventController::class, 'store'])->name('events.UserStore');

    Route::get('/UserNewsletters', [NewsletterController::class, 'index'])->name('UserNewsletters.index');
    Route::post('/UserNewsletter/{newsletter}/like', [NewsletterController::class, 'like'])->name('UserNewsletter.like');
    Route::post('/UserNewsletter/{newsletter}/comment', [NewsletterController::class, 'comment'])->name('UserNewsletter.comment');

    Route::delete('/UserComments/{id}', [NewsletterController::class, 'destroy'])->name('UserNewsletter.comment.delete');
    Route::patch('/UserComments/{id}', [NewsletterController::class, 'update'])->name('UserNewsletter.comment.update');

    Route::post('/UserNewsletters', [NewsletterController::class, 'store'])->name('UserNewsletter.store');

    Route::get('/profile', [UsersController::class, 'profile'])->name('profile');
// Display the Edit Profile form
    Route::get('/UserProfile/edit', [UsersController::class, 'edit'])->name('UserProfile.edit');

// Handle the Update Profile form submission
    Route::put('/UserProfile/update', [UsersController::class, 'update'])->name('UserProfile.update');
    Route::get('/user/motorcycles', [MotorcycleController::class, 'userMotorcycles'])->name('UserMotorcycles.index');
    Route::get('/UserMotorcycles/{motorcycle}/edit', [MotorcycleController::class, 'edit'])->name('UserMotorcycles.edit');
    Route::put('/UserMotorcycles/{motorcycle}', [MotorcycleController::class, 'updateMotor'])->name('UserMotorcycles.update');
    Route::delete('/UserMotorcycles/{motorcycle}', [MotorcycleController::class, 'destroy'])->name('UserMotorcycles.destroy');

    Route::post('/UserMotorcycles/store', [MotorcycleController::class, 'store'])->name('UserMotorcycles.store');

});

// Authenticated users' logout route
Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        auth()->logout();
        request()->session()->invalidate(); // Invalidate the session
        request()->session()->regenerateToken(); // Regenerate the CSRF token
        return redirect()->route('login'); // Redirect to the login page
    })->name('logout');
});


// Include Breeze auth routes
require __DIR__ . '/auth.php';

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




// Public Routes
Route::get('/', function () {
    return view('theme.index');
})->name('home');

Route::get('/showContacts', [ContactController::class,'index' ])->name('user.showContact');
Route::post('/UserContacts', [ContactController::class,'store' ])->name('user.storeContact');

// Public pages handled by ThemeController
Route::controller(ThemeController::class)->name('theme.')->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/team', 'team')->name('team');
    Route::get('/testimonial', 'testimonial')->name('testimonial');
});





// Guest-specific routes (for login view)
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

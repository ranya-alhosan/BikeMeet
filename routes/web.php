<?php




use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactController;





// Public Routes
Route::get('/', function () {
    return view('theme.index'); // Define your homepage view
})->name('home');

// Public pages handled by ThemeController
Route::controller(ThemeController::class)->name('theme.')->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/booking', 'booking')->name('booking');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/service', 'service')->name('service');
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
    Route::resource('rentals', RentalController::class);
    Route::get('/motorcycles/{userId}', [RentalController::class, 'getMotorcyclesByUser'])->name('motorcycles.by-user');
    Route::resource('newsletters', NewsletterController::class);
    Route::post('newsletters/{id}/like', [NewsletterController::class, 'like'])->name('newsletters.like');
    Route::post('newsletters/{id}/comment', [NewsletterController::class, 'comment'])->name('newsletters.comment');
    Route::resource('contacts', ContactController::class);

});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
require __DIR__.'/auth.php';

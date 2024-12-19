<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\User;
use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rentals = Rental::with('user', 'motorcycle')->get();

        return view('dashboard.rentals.index', compact('rentals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user(); // Get the currently logged-in user

        if ($user->role === 'admin') {
            // Admin: Fetch all users and their motorcycles
            $users = User::with('motorcycles')->get();
            $motorcycles = Motorcycle::all(); // All motorcycles
            return view('dashboard.rentals.create', compact('users', 'motorcycles')); // Admin's create view
        } else {
            // Regular user: Fetch only their motorcycles
            $motorcycles = $user->motorcycles;  // Assuming there's a 'motorcycles' relationship
            return view('theme.rent.rent-create', compact('user', 'motorcycles')); // User's create view
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check the user's role
        $isAdmin = auth()->user()->role === 'admin';

        // Validate input
        $validatedData = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) use ($isAdmin) {
                    // If the user is not an admin, ensure they are the selected user
                    if (!$isAdmin && $value != auth()->id()) {
                        $fail('You can only create rentals for yourself.');
                    }
                },
            ],
            'motorcycle_id' => [
                'required',
                'exists:motorcycles,id',
                function ($attribute, $value, $fail) use ($isAdmin, $request) {
                    // Check if the motorcycle belongs to the selected user for admin or the authenticated user otherwise
                    $userId = $isAdmin ? $request->user_id : auth()->id();
                    if (!Motorcycle::where('id', $value)->where('user_id', $userId)->exists()) {
                        $fail('The selected motorcycle does not belong to the specified user.');
                    }
                },
            ],
            'rental_start_date' => 'required|date|after_or_equal:today',  // Ensure start date is today or later
            'rental_end_date' => 'required|date|after:rental_start_date',  // Ensure end date is after the start date
        ]);

        // Check if the motorcycle is already rented during the selected date range
        $existingRental = Rental::where('motorcycle_id', $request->motorcycle_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('rental_start_date', [$request->rental_start_date, $request->rental_end_date])
                    ->orWhereBetween('rental_end_date', [$request->rental_start_date, $request->rental_end_date]);
            })
            ->exists();

        if ($existingRental) {
            return redirect()->back()->withErrors(['rental_error' => 'This motorcycle is already rented during the selected date range.']);
        }

        // Create the rental
        Rental::create($validatedData);

        // Redirect based on role
        if ($isAdmin) {
            return redirect()->route('rentals.index')->with('success', 'Rental created successfully!');
        }

        return redirect()->route('rentals.showRentals')->with('success', 'Rental advertisement created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        $users = User::all();
        $motorcycles = Motorcycle::all();
        return view('dashboard.rentals.edit', compact('rental', 'users', 'motorcycles'));
    }

    public function update(Request $request, Rental $rental)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'motorcycle_id' => 'required|exists:motorcycles,id',
            'rental_start_date' => 'required|date',
            'rental_end_date' => 'required|date|after:rental_start_date',
            'status' => 'required|in:rented,available',
        ]);
        $rental->update($validatedData);
        return redirect()->route('rentals.index')->with('success', 'Rental updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        $rental->delete();

        return redirect()->route('rentals.index')->with('success', 'Rental deleted successfully!');
    }
    public function getMotorcyclesByUser($userId)
    {
        // Fetch motorcycles for the selected user
        $motorcycles = Motorcycle::where('user_id', $userId)->get();

        // Debugging: Check if motorcycles are found
        if ($motorcycles->isEmpty()) {
            return response()->json(['motorcycles' => [], 'message' => 'No motorcycles found for this user.']);
        }

        // Return the motorcycles as JSON
        return response()->json([
            'motorcycles' => $motorcycles
        ]);
    }

    public function showRentals(Request $request)
    {
        // Update the status of rentals where the rental period has expired
        Rental::where('status', 'active')
            ->where('rental_end_date', '<', now()) // Check if the rental period has ended
            ->update(['status' => 'rented']); // Automatically update to rented status

        $query = Rental::with(['motorcycle', 'user']);

        // Apply Make filter
        if ($request->has('make') && $request->make != '') {
            $query->whereHas('motorcycle', function ($q) use ($request) {
                $q->where('make', 'like', '%' . $request->make . '%');
            });
        }

        // Apply Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Apply Rent Status (Available / Rented)
        if ($request->has('rent_status') && $request->rent_status != '') {
            if ($request->rent_status == 'available') {
                $query->where('status', 'available');
            } elseif ($request->rent_status == 'rented') {
                $query->where('status', 'rented');
            }
        }

        // Apply Price filter
        if ($request->has('min_price') || $request->has('max_price')) {
            $query->whereHas('motorcycle', function ($q) use ($request) {
                if ($request->min_price) {
                    $q->where('price_per_day', '>=', $request->min_price);
                }
                if ($request->max_price) {
                    $q->where('price_per_day', '<=', $request->max_price);
                }
            });
        }

        // Apply Date filter
        if ($request->has('start_date') || $request->has('end_date')) {
            $query->where(function ($q) use ($request) {
                if ($request->start_date) {
                    $q->where('rental_end_date', '>=', $request->start_date);
                }
                if ($request->end_date) {
                    $q->where('rental_start_date', '<=', $request->end_date);
                }
            });
        }

        // Execute the query and get results
        $rentals = $query->get();

        // Return the view with the rentals data
        return view('theme.rent.rent', compact('rentals'));
    }

    public function show($id)
    {
        // Fetch rental details
        $rental = Rental::with('motorcycle', 'user')->findOrFail($id);

        // Return the view located in the "theme" folder
        return view('theme.rent.rent-details', compact('rental'));
    }
    public function proceedToRent($rentalId)
    {
        $rental = Rental::findOrFail($rentalId);

        // Prevent renting your own motorcycle
        if ($rental->motorcycle->user_id === auth()->id()) {
            return redirect()->back()->withErrors(['rental_error' => "You can't rent your motorcycle."]);
        }

        // Update rental status to 'rented'
        $rental->update(['status' => 'rented']);

        // Add record to user_rentals table
        DB::table('user_rentals')->insert([
            'user_id' => auth()->id(),
            'motorcycle_id' => $rental->motorcycle_id, // Assign the motorcycle ID
            'rent_id' => $rental->id,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        // Redirect back with success message
        return redirect()->route('rentals.show', $rental->id)->with('success', 'Rented, payment upon receipt of the motorcycle. Thank you.');
    }

}

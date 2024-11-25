<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\User;
use App\Models\Motorcycle;
use Illuminate\Http\Request;

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
        $users = User::all();
        $motorcycles = Motorcycle::all();
        return view('dashboard.rentals.create', compact('users', 'motorcycles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'motorcycle_id' => 'required|exists:motorcycles,id',
            'rental_start_date' => 'required|date',
            'rental_end_date' => 'required|date|after:rental_start_date',
            'status' => 'required|in:active,completed,cancelled',
        ]);

        Rental::create($validatedData);

        return redirect()->route('rentals.index')->with('success', 'Rental created successfully!');
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rental $rental)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'motorcycle_id' => 'required|exists:motorcycles,id',
            'rental_start_date' => 'required|date',
            'rental_end_date' => 'required|date|after:rental_start_date',
            'status' => 'required|in:active,completed,cancelled',
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
}

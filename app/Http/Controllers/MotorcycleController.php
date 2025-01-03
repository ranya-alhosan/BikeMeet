<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotorcycleController extends Controller
{
    public function index()
    {
        // Fetch all motorcycles from the database
        $motorcycles = Motorcycle::all();

        // Return the view with motorcycles data
        return view('dashboard.motorcycles.index', compact('motorcycles'));
    }

    public function userMotorcycles()
    {
        $user = auth()->user();
        $motorcycles = $user->motorcycles; // Fetch motorcycles associated with the logged-in user

        return view('theme.userProfile.userMotorcycles', compact('motorcycles'));
    }

    public function create()
    {
        // Get all users except the current logged-in user, so the motorcycle isn't assigned to them by mistake
        $users = User::all();
        return view('dashboard.motorcycles.create', compact('users'));
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'user_id' => 'required|exists:users,id', // Ensure user exists
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:2100',
            'price_per_day' => 'required|numeric|min:0',
            'availability_status' => 'required|in:available,under_maintenance',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload if present
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('motorcycle_images', 'public');
        }

        // Create the motorcycle and associate it with the selected user
        Motorcycle::create([
            'user_id' => $request->user_id, // Link to the selected user
            'make' => $request->make,
            'model' => $request->model,
            'year' => $request->year,
            'price_per_day' => $request->price_per_day,
            'availability_status' => $request->availability_status,
            'description' => $request->description,
            'image' => $imagePath,
        ]);
        $user = auth()->user();
        if ($user->role === 'admin') {

        return redirect()->route('motorcycles.index')->with('success', 'Motorcycle added successfully');
        }
        return redirect()->back()->with('success', 'Motorcycle added successfully!');

    }


    public function edit(Motorcycle $motorcycle)
    {
        $user = auth()->user();
        if ($user->role === 'admin') {

            $users = User::all(); // Include users for selection
            return view('dashboard.motorcycles.edit', compact('motorcycle', 'users'));
        } else {
            $this->authorize('update', $motorcycle); // Ensure user authorization
            return view('motorcycles.edit', compact('motorcycle'));
        }
    }

    public function update(Request $request, Motorcycle $motorcycle)
    {

        // Validate input
        $validatedData = $request->validate([
            'make' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:2100',
            'price_per_day' => 'nullable|numeric|min:0',
            'availability_status' => 'nullable|in:available,under_maintenance',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            // Handle image upload if a new image is uploaded
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($motorcycle->image) {
                    Storage::delete('public/' . $motorcycle->image);
                }
                $validatedData['image'] = $request->file('image')->store('motorcycle_images', 'public');
            }

            // Update only fields that are provided
            $motorcycle->update($validatedData);

                return redirect()->route('motorcycles.index')->with('success', 'Motorcycle updated successfully.');



        } catch (Exception $e) {
            // Handle any errors and show error message
            return redirect()->route('motorcycles.index')->with('error', 'Failed to update motorcycle. Please try again.');
        }

    }
    public function updateMotor(Request $request, $id)
    {

        $validatedData = $request->validate([
            'make' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:2100',
            'price_per_day' => 'nullable|numeric|min:0',
            'availability_status' => 'nullable|in:available,under_maintenance',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $motorcycle = Motorcycle::findOrFail($id);

        // Update fields
        $motorcycle->update($validatedData);

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('motorcycles', 'public');
            $motorcycle->update(['image' => $path]);
        }

        return redirect()->back()->with('success', 'Motorcycle updated successfully!');
    }




    public function show(Motorcycle $motorcycle)
    {
        return view('dashboard.motorcycles.show', compact('motorcycle'));
    }

    public function destroy(Motorcycle $motorcycle)
    {
        $user = auth()->user();

        // Delete all related rentals
        $motorcycle->rentals()->delete();

        // Delete image from storage if exists
        if ($motorcycle->image) {
            Storage::delete('public/' . $motorcycle->image);
        }

        // Delete the motorcycle
        $motorcycle->delete();

        if ($user->role === 'admin') {
            return redirect()->route('motorcycles.index')->with('success', 'Motorcycle and its associated rentals deleted successfully');

        }
        return redirect()->route('UserMotorcycles.index')->with('success', 'Motorcycle deleted successfully!');



    }

}

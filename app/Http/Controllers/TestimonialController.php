<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // Store a new testimonial
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:Motorcycle Lover,Motorcycle Renter,Event Organizer',
            'text' => 'required|string',
        ]);

        // Create a new testimonial
        $testimonial = new Testimonial([
            'user_id' => auth()->id(), // Automatically set the user_id from the logged-in user
            'role' => $request->role,
            'text' => $request->text,
            'status' => 'Reject', // Default status is Reject
        ]);

        // Save the testimonial to the database
        $testimonial->save();

        // Redirect or return a success message
        return redirect()->back()->with('success', 'Testimonial submitted successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    // Store a new testimonial
    public function store(Request $request)
    {
        // Check if the user already has a testimonial
        $existingTestimonial = Testimonial::where('user_id', auth()->id())->first();

        if ($existingTestimonial) {
            // If the user already has a testimonial, return a SweetAlert message
            return redirect()->back()->with('error', 'You can only submit one testimonial!');
        }

        // Validate the request
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

        // Redirect with a success message
        return redirect()->back()->with('success', 'Testimonial submitted successfully!');
    }

    public function showTestimonials()
    {
        // Fetch testimonials with status 'Accept', limit to 4
        $testimonials = Testimonial::where('status', 'Accept')->limit(4)->get();

        // Check if there are no testimonials with status 'Accept'
        if ($testimonials->isEmpty()) {
            // If no testimonials, add default testimonials
            $defaultTestimonials = [
                [
                    'name' => 'Ahmed Ali',
                    'role' => 'Motorcycle Lover',
                    'text' => 'BikeMeet has been a great way for me to meet other motorcycle enthusiasts. It’s easy to use and I’ve had a lot of fun connecting with fellow riders!',
                    'image' => asset('assets/img/testimonial1.jpg')
                ],
                [
                    'name' => 'Mahmoud Mustafa',
                    'role' => 'Motorcycle Renter',
                    'text' => 'Renting a bike through BikeMeet was so easy. I found the perfect ride in no time and had a smooth experience throughout. I’ll definitely rent again!',
                    'image' => asset('assets/img/testimonial2.jpg')
                ],
                [
                    'name' => 'Sami Adel',
                    'role' => 'Event Organizer',
                    'text' => 'I’ve organized several events with BikeMeet, and it’s been such a pleasure. The platform makes everything easy, and the riders always have a great time!',
                    'image' => asset('assets/img/testimonial3.jpg')
                ],
                [
                    'name' => 'Tarek Said',
                    'role' => 'Motorcycle Enthusiast',
                    'text' => 'BikeMeet has made it so much easier to connect with other motorcycle fans. I love the community and the ability to share rides and experiences!',
                    'image' => asset('assets/img/testimonial4.jpg')
                ],
            ];

            return view('testimonials.index', compact('testimonials', 'defaultTestimonials'));
        }

        return view('testimonials.index', compact('testimonials'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\UserRental;
use App\Models\Newsletter;
use App\Models\Testimonial;

use Illuminate\Http\Request;
use App\Models\EventEnrollment;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Apply filters if available
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('name') && $request->name !== '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('organizer') && $request->organizer !== '') {
            $query->whereHas('user', function($query) use ($request) {
                $query->where('name', 'like', '%' . $request->organizer . '%');
            });
        }

        // Get filtered events
        $events = $query->withCount('enrollments')->get();

        return view('dashboard.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        // Eager load enrollments and user details
        $event->load('enrollments.user');

        return response()->json([
            'event' => $event
        ]);
    }

    public function indexUser(Request $request)
    {
        // Get distinct locations for the filter
        $locations = Event::distinct()->pluck('location');

        // Start the query and add `withCount` for enrollments
        $query = Event::withCount('enrollments');

        // Apply search filter if it exists
        if ($request->has('search') && $request->search) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Apply status filter if it exists
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Apply location filter if it exists
        if ($request->has('location') && $request->location) {
            $query->where('location', $request->location);
        }

        // Get filtered events with pagination
        $events = $query->paginate(6);

        // Check if the request is AJAX
        if ($request->ajax()) {
            // Return the events list partial view (for dynamic updates)
            return view('theme.events.events_list', compact('events'));
        }

        // Return the main view
        return view('theme.events.event', compact('events', 'locations'));
    }
    public function showDetails($id)
    {
        $event = Event::with('user', 'enrollments')->findOrFail($id);
        return view('theme.events.event-detail', compact('event'));
    }

    public function enroll($eventId)
    {
        // Ensure the user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to enroll.');
        }

        // Check if the event exists
        $event = Event::findOrFail($eventId);

        // Check if the user is the owner of the event
        if ($event->user_id === auth()->id()) {
            return redirect()->route('events.UserIndex')->with('error', 'You cannot enroll in your own event.');
        }

        // Check if the user is already enrolled
        if ($event->enrollments()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('events.UserIndex')->with('error', 'You are already enrolled in this event.');
        }

        // Create a new enrollment
        $enrollment = new EventEnrollment([
            'user_id' => auth()->id(),
            'event_id' => $eventId,
            'enrollment_date' => now(),
            'status' => 'pending', // Set status as 'pending'
        ]);

        $enrollment->save();

        // Redirect with success message
        return redirect()->route('events.UserIndex')->with('success', 'You have successfully enrolled in the event.');
    }

    public function create()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return view('dashboard.events.create');

        }
        return view('theme.events.create');
    }

    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date', // Check that the end date is after or equal to the start date
                function ($attribute, $value, $fail) use ($request) {
                    // Ensure that the time of the start date is not equal to the time of the end date
                    $startDateTime = \Carbon\Carbon::parse($request->start_date);
                    $endDateTime = \Carbon\Carbon::parse($value);

                    if ($startDateTime->isSameMinute($endDateTime)) {
                        $fail('The start date and time must not be equal to the end date and time.');
                    }
                }
            ],
            'fee' => 'required|numeric|min:0',
            'status' => 'required|in:upcoming,completed',
        ]);

        // Create the event
        Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'fee' => $request->fee,
            'status' => $request->status,
            'user_id' => auth()->id(), // Assuming the user creating the event is logged in
        ]);

        $user = auth()->user(); // Get the currently logged-in user

        if ($user->role === 'admin') {
            return redirect()->route('events.index')->with('success', 'Event created successfully.');
        }

        // Redirect to the events index page with success message
        return redirect()->route('events.UserIndex')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('dashboard.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'fee' => 'nullable|numeric|min:0',
            'status' => 'required|in:upcoming,completed',
        ]);

        // Update the event
        $event->update($validatedData);

        // Check if the event status is 'completed' or if the event's time has passed
        if ($event->status === 'completed' || now()->greaterThanOrEqualTo($event->end_date)) {
            // Update the status of all associated event enrollments to 'completed'
            $event->enrollments()->update(['status' => 'completed']);
        }

        // If the status changes from 'completed' to 'upcoming', reset enrollment statuses
        if ($event->status === 'upcoming' && $event->wasChanged('status')) {
            // Reset the enrollment statuses to 'pending' or 'confirmed'
            $event->enrollments()->update(['status' => 'pending']);
        }

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    public function latestEvents()
    {
        $events = Event::latest()->take(3)->get();
        $totalUsers = User::count();
        $totalRentals = UserRental::count();
        $totalEvents = Event::count();
        $totalNewsletters = Newsletter::count();

        // Fetch testimonials with status 'Accept' and load related user
        $testimonials = Testimonial::latest()->where('status', 'Accept')->with('user')->get();

        // Default testimonials to show if there aren't enough from the database
        $defaultTestimonials = [
            [
                'name' => 'Ahmed Ali',
                'role' => 'Motorcycle Lover',
                'text' => 'BikeMeet has been a great way for me to meet other motorcycle enthusiasts. It’s easy to use and I’ve had a lot of fun connecting with fellow riders!',
                'image' => 'assets/img/testimonial1.jpg'
            ],
            [
                'name' => 'Mahmoud Mustafa',
                'role' => 'Motorcycle Renter',
                'text' => 'Renting a bike through BikeMeet was so easy. I found the perfect ride in no time and had a smooth experience throughout. I’ll definitely rent again!',
                'image' => 'assets/img/testimonial2.jpg'
            ],
            [
                'name' => 'Sami Adel',
                'role' => 'Event Organizer',
                'text' => 'I’ve organized several events with BikeMeet, and it’s been such a pleasure. The platform makes everything easy, and the riders always have a great time!',
                'image' => 'assets/img/testimonial3.jpg'
            ],
            [
                'name' => 'Tarek Said',
                'role' => 'Motorcycle Enthusiast',
                'text' => 'BikeMeet has made it so much easier to connect with other motorcycle fans. I love the community and the ability to share rides and experiences!',
                'image' => 'assets/img/testimonial4.jpg'
            ]
        ];

        // Map database testimonials to include user data
        $testimonials = $testimonials->map(function ($testimonial) {
            return [
                'name' => $testimonial->user->name ?? 'Unknown User', // Fetch name from related user or fallback
                'role' => $testimonial->role,
                'text' => $testimonial->text,
                'image' => $testimonial->user->image ?? 'assets/img/users.png', // Fetch user image or fallback
            ];
        });

        // Calculate how many default testimonials to add
        $defaultCount = max(0, 4 - $testimonials->count());

        // Add default testimonials if needed
        if ($defaultCount > 0) {
            $testimonials = $testimonials->concat(array_slice($defaultTestimonials, 0, $defaultCount));
        }

        return view('theme.index', compact('testimonials', 'events', 'totalUsers', 'totalRentals', 'totalEvents', 'totalNewsletters'));
    }

}

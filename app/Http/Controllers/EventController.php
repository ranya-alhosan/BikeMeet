<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\EventEnrollment;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user(); // Get the currently logged-in user

        if ($user->role === 'admin') {
            // Admin view: Show all events with enrollments count
            $events = Event::withCount('enrollments')->paginate(10); // Add `withCount` for enrollments
            return view('dashboard.events.index', compact('events'));
        }

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user(); // Get the currently logged-in user
        if ($user->role === 'admin') {
            return view('dashboard.events.create');

        }
        return view('theme.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('dashboard.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'fee' => 'nullable|numeric|min:0',
            'status' => 'required|in:upcoming,completed',
        ]);

        $event->update($validatedData);

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }
}

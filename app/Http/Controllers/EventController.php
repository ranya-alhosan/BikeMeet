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
        // Get distinct locations for the filter
        $locations = Event::distinct()->pluck('location');

        // Start the query
        $query = Event::query();

        // Apply search filter if it exists
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Apply status filter if it exists
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Apply location filter if it exists
        if ($request->has('location') && $request->location) {
            $query->where('location', $request->location);
        }

        // Get filtered events
        $events = $query->paginate(6);

        // Check if the request is AJAX
        if ($request->ajax()) {
            // Return the events list partial view
            return view('theme.events.events_list', compact('events'));
        }

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
        return view('dashboard.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        Event::create($validatedData);

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
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

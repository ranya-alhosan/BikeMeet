<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventEnrollment;
use App\Models\User;
use App\Models\Event;


class EventEnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = EventEnrollment::with(['user', 'event']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by user name
        if ($request->filled('user')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('user') . '%');
            });
        }

        // Filter by event name
        if ($request->filled('event')) {
            $query->whereHas('event', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('event') . '%');
            });
        }

        $enrollments = $query->paginate(10);

        return view('dashboard.enrollment.index', compact('enrollments'));
    }




    public function edit($id)
    {
        $enrollment = EventEnrollment::findOrFail($id);
        return view('dashboard.enrollment.edit', compact('enrollment'));
    }


    public function update(Request $request, $id)
    {
        $enrollment = EventEnrollment::findOrFail($id);

        // Prevent updates if the status is already completed
        if ($enrollment->status === 'completed') {
            return redirect()->route('enrollment.index')->withErrors(['status' => 'Completed enrollments cannot be modified.']);
        }

        $validatedData = $request->validate([
            'status' => 'required|in:pending,enrolled,completed',
        ]);

        $enrollment->update($validatedData);

        return redirect()->route('enrollment.index')->with('success', 'Enrollment updated successfully.');
    }


    public function destroy($id)
    {
        $enrollment = EventEnrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('enrollment.index')->with('success', 'Enrollment deleted successfully.');
    }
    public function create()
    {
        $users = User::all(); // Assuming you have a User model
        $events = Event::all(); // Assuming you have an Event model

        return view('dashboard.enrollment.create', compact('users', 'events'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'status' => 'required|in:pending,enrolled,completed',
        ]);

        // Get the selected event's details
        $selectedEvent = Event::findOrFail($request->event_id);

        // Check if the user is already enrolled in the same event
        $existingEnrollment = EventEnrollment::where('user_id', $request->user_id)
            ->where('event_id', $request->event_id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->back()->withErrors(['user_id' => 'This user is already enrolled in the selected event.']);
        }

        // Check if the user is enrolled in another event happening at the same time
        $conflictingEnrollment = EventEnrollment::where('user_id', $request->user_id)
            ->whereHas('event', function ($query) use ($selectedEvent) {
                $query->where('start_date', '<=', $selectedEvent->end_date)
                    ->where('end_date', '>=', $selectedEvent->start_date);
            })
            ->first();

        if ($conflictingEnrollment) {
            return redirect()->back()->withErrors(['user_id' => 'This user is already enrolled in another event during the selected event\'s time.']);
        }

        // Set the enrollment date to today's date
        $validatedData['enrollment_date'] = now();

        // Create the enrollment
        EventEnrollment::create($validatedData);

        return redirect()->route('enrollment.index')->with('success', 'Enrollment added successfully.');
    }


}

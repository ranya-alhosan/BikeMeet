<?php

namespace App\Http\Controllers;

use App\Models\EventEnrollment;
use Illuminate\Http\Request;

class EventEnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = EventEnrollment::with(['user', 'event'])->paginate(10);
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

        $validated = $request->validate([
            'status' => 'required|string|in:pending,enrolled,completed', // Ensure these match dropdown values
        ]);

        $enrollment->update($validated);

        return redirect()->route('enrollment.index')->with('success', 'Enrollment updated successfully.');
    }


    public function destroy($id)
    {
        $enrollment = EventEnrollment::findOrFail($id);
        $enrollment->delete();

        return redirect()->route('enrollment.index')->with('success', 'Enrollment deleted successfully.');
    }
}

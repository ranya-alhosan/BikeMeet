<?php
namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     */
    public function index()
    {
        $user = auth()->user();
        $contacts = Contact::all();
        if ($user->role === 'admin') {

        return view('dashboard.contacts.index', compact('contacts'));

        }
        return view('theme.contact');

    }

    /**
     * Show the form for creating a new contact.
     */
    public function create()
    {
        return view('dashboard.contacts.create');
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(Request $request)
    {
        // Validation for the form fields
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        // Create the contact record in the database
        Contact::create($validatedData);

        // Redirect based on the user's role, if necessary
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('contacts.index')->with('success', 'Contact created successfully!');
        } else {
            return redirect()->route('theme.contact')->with('success', 'Contact created successfully!');
        }
    }

    /**
     * Display the specified contact.
     */
    public function show($id)
    {
        $contact = Contact::with('user');
        return view('dashboard.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified contact.
     */
    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('dashboard.contacts.edit', compact('contact'));
    }


    /**
     * Update the specified contact in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($validatedData);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully!');
    }
}

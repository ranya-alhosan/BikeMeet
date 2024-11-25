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
        $contacts = Contact::with('user')->latest()->get();
        return view('dashboard.contacts.index', compact('contacts'));
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
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
            'message' => 'nullable|string',
        ]);

        Contact::create($validatedData);
        return redirect()->route('contacts.index')->with('success', 'Contact created successfully!');
    }

    /**
     * Display the specified contact.
     */
    public function show($id)
    {
        $contact = Contact::with('user')->findOrFail($id);
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
        'phone' => 'nullable|string|max:20',
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

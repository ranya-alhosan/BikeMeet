<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Models\NewsletterLike;
use App\Models\NewsletterComment;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all(); // Fetch all users
        return view('dashboard.users.index', compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,user',
        ]);

        // If validation passes, create the user
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return view('dashboard.users.edit', compact('user'));

        }
        return view('theme.edit', compact('user'));

    }

    public function update(Request $request, User $user)
    {
        $user = auth()->user();

        // Validate input fields, including photo validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:15',
            'country' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Verify the current password
        if (!empty($validated['current_password']) && !\Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update basic user fields
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? $user->phone_number,
            'country' => $validated['country'] ?? $user->country,
            'region' => $validated['region'] ?? $user->region,
        ]);

        // Update the password if provided
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
            $user->save();
        }

        // Handle the photo upload if provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($user->image && file_exists(storage_path('app/public/' . $user->image))) {
                unlink(storage_path('app/public/' . $user->image));
            }

            // Store the new image
            $imagePath = $request->file('image')->store('profile_images', 'public');

            // Update the user's image path in the database
            $user->update(['image' => $imagePath]);
        }

        // Redirect based on user role
        if ($user->role === 'admin') {
            return redirect()->route('users.index')->with('success', 'User updated successfully!');
        }

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function profile()
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Return the profile view with user data
        return view('theme.profile', compact('user'));
    }


    public function showUserNewsletters()
    {
        $user = auth()->user();

        // Fetch newsletters with comment and like counts
        $newsletters = $user->newsletters()
            ->with(['comments.user']) // Eager load the comments and the user who made them
            ->withCount(['likes', 'comments']) // Add counts for likes and comments
            ->paginate(10);

        return view('theme.newsletterUser', compact('user', 'newsletters'));
    }



    public function destroyNewsletter($id)
    {
        try {
            $newsletter = Newsletter::findOrFail($id);

            // Ensure the authenticated user owns the newsletter
            if ($newsletter->user_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            // Delete the newsletter
            $newsletter->delete();

            return redirect()->route('ProfNewsletters.index')->with('success', 'Newsletter deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the newsletter.');
        }
    }

    public function updateNewsletter(Request $request, $id)
    {

        try {
            $newsletter = Newsletter::findOrFail($id);

            // Ensure the authenticated user owns the newsletter
            if ($newsletter->user_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            // Validate the input
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            // Update the newsletter
            $newsletter->update([
                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);

            return redirect()->route('ProfNewsletters.index')->with('success', 'Newsletter updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the newsletter.');
        }
    }

    public function toggleLike(Request $request, $id)
    {
        $user = auth()->user();

        // Find the newsletter
        $newsletter = Newsletter::findOrFail($id);

        // Check if the user has already liked the newsletter
        $like = NewsletterLike::where('user_id', $user->id)
            ->where('newsletter_id', $newsletter->id)
            ->first();

        if ($like) {
            // Unlike the newsletter
            $like->delete();
            return redirect()->back()->with('success', 'You unliked this newsletter.');
        } else {
            // Like the newsletter
            NewsletterLike::create([
                'user_id' => $user->id,
                'newsletter_id' => $newsletter->id,
            ]);
            return redirect()->back()->with('success', 'You liked this newsletter.');
        }
    }

    // Handle adding a comment to a newsletter
    public function addComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        // Find the newsletter
        $newsletter = Newsletter::findOrFail($id);

        // Add the comment
        NewsletterComment::create([
            'user_id' => $user->id,
            'newsletter_id' => $newsletter->id,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Your comment has been added.');
    }
    public function showUserEvents()
    {
        $user = auth()->user(); // Get the authenticated user

        // Fetch the events related to the user. Adjust if you have a different relationship.
        $events = $user->events()->get();

        // Return the view with user and events data
        return view('user.events.index', compact('user', 'events'));
    }
}

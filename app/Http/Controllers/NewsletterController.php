<?php
namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Models\NewsletterLike;
use App\Models\NewsletterComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $newsletters = Newsletter::with(['user', 'likes', 'comments.user'])
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest() // Orders by created_at in descending order
            ->paginate(10); // Set the number of items per page

        return view('dashboard.newsletters.index', compact('newsletters'));
    }

    public function indexUser(){
        $newsletters = Newsletter::with(['user', 'likes', 'comments.user'])
            ->latest() // Orders by created_at in descending order
            ->get();
        return view('theme.newsletters.index', compact('newsletters'));
    }

    public function indexProf()
    {
    // Fetch all newsletters for the authenticated user
    $newsletters = auth()->user()->newsletters; // Assuming the User model has a relationship with Newsletter

    // Return the view with the newsletters data
    return view('theme.newsletterUser', compact('newsletters'));
   }

    // Like a newsletter
    public function like(Newsletter $newsletter)
    {
        $user = auth()->user();

        // Check if the user has already liked this newsletter
        $like = NewsletterLike::where('user_id', $user->id)
            ->where('newsletter_id', $newsletter->id)
            ->first();

        if ($like) {
            // If the like exists, delete it
            $like->delete();
        } else {
            // Otherwise, create a new like
            NewsletterLike::create([
                'user_id' => $user->id,
                'newsletter_id' => $newsletter->id,
            ]);
        }

        // Return the new like count as JSON
        return response()->json([
            'likes_count' => $newsletter->likes()->count(),
        ]);
    }

    // In NewsletterController.php

    public function destroy($id)
    {
        // Retrieve the newsletter by its ID
        $newsletter = Newsletter::findOrFail($id);

        // Check if the authenticated user is the owner of the newsletter
        if ($newsletter->user_id !== auth()->id()) {
            return redirect()->route('newsletters.index')->with('error', 'You do not have permission to delete this newsletter.');
        }

        // Delete the image if it exists
        if ($newsletter->image) {
            Storage::delete('public/' . $newsletter->image);
        }

        // Delete the newsletter
        $newsletter->delete();

        // Redirect back with a success message
        return redirect()->route('profile')->with('success', 'Newsletter deleted successfully.');
    }

    public function commentDestroy($id)
    {
        $comment = NewsletterComment::findOrFail($id);

        if (auth()->id() !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully.',
        ]);
    }
    public function destroyNews($id)
    {
        $newsletter = Newsletter::findOrFail($id);

        // Optional: Check if the user is authorized to delete the newsletter
        if (auth()->id() !== $newsletter->user_id && auth()->user()->role !== 'admin') {
            return redirect()->route('newsletters.index')->with('error', 'Unauthorized action');
        }

        $newsletter->delete();

        return redirect()->route('newsletters.index')->with('success', 'Newsletter deleted successfully!');
    }

    public function commentUpdate(Request $request, $id)
    {
        $comment = NewsletterComment::findOrFail($id);

        if (auth()->id() !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403); // Prevent unauthorized access
        }

        $request->validate([
            'comment' => 'required|string|max:255',
        ]);

        $comment->update([
            'comment' => $request->input('comment'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully.',
            'comment' => $comment->comment,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Retrieve the newsletter by its ID
        $newsletter = Newsletter::findOrFail($id);

        // Check if the authenticated user is the owner of the newsletter
        if ($newsletter->user_id !== auth()->id()) {
            return redirect()->route('newsletters.index')->with('error', 'You do not have permission to update this newsletter.');
        }

        // Update the newsletter's title and content
        $newsletter->title = $validated['title'];
        $newsletter->content = $validated['content'];

        // If there's a new image, store it and update the image path
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($newsletter->image) {
                Storage::delete('public/' . $newsletter->image);
            }

            // Store the new image
            $newsletter->image = $request->file('image')->store('newsletters', 'public');
        }

        // Save the updated newsletter
        $newsletter->save();

        // Redirect back to the newsletter list with a success message
        return redirect()->route('profile')->with('success', 'Newsletter updated successfully.');
    }

    public function comment(Request $request, Newsletter $newsletter)
    {
        $user = auth()->user();

        // Validate the comment
        $validated = $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        // Create the comment
        $comment = NewsletterComment::create([
            'user_id' => $user->id,
            'newsletter_id' => $newsletter->id,
            'comment' => $validated['comment'],
        ]);

        // Return the new comment as JSON
        return response()->json([
            'user_name' => $user->name,
            'comment' => $comment->comment,
        ]);
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return view('dashboard.newsletters.create');
        } else {
            return redirect()->route('newsletters.index');
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        // Add user_id to the validated data
        $validatedData['user_id'] = auth()->id();

        // Handle the image upload if present
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('newsletters', 'public');
            $validatedData['image'] = $imagePath; // Save image path
        }

        // Create the newsletter with the validated data including user_id
        Newsletter::create($validatedData);

        return redirect()->route('UserNewsletters.index')->with('success', 'Newsletter created successfully!');
    }


    public function show($id)
    {
        $user = auth()->user();
        $newsletter = Newsletter::findOrFail($id);
        $comments = $newsletter->comments()->latest()->paginate(10); // Paginate comments
        $likes = $newsletter->likes;


        if ($user->role === 'admin') {
            return view('dashboard.newsletters.show', compact('newsletter', 'comments', 'likes'));
        } else {
            return view('theme.newsletters.index', compact('newsletter', 'comments', 'likes'));
        }
    }


    public function edit($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        return view('dashboard.newsletters.edit', compact('newsletter'));

    }
    public function UserEdit($id)
    {
        // Retrieve the newsletter by its ID
        $newsletter = Newsletter::findOrFail($id);

        // Check if the authenticated user is the owner of the newsletter
        if ($newsletter->user_id !== auth()->id()) {
            return redirect()->route('newsletters.index')->with('error', 'You do not have permission to edit this newsletter.');
        }

        // Return the edit view with the newsletter data
        return view('theme.newsletters.edit', compact('newsletter'));
    }

    public function DashEdit($id)
    {
        // Find the newsletter by ID
        $newsletter = Newsletter::findOrFail($id);

        // Return the view with the newsletter data
        return view('dashboard.newsletters.edit', compact('newsletter'));
    }

    public function DashUpdate(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        // Find the newsletter by ID
        $newsletter = Newsletter::findOrFail($id);

        // Update the newsletter with the validated data
        $newsletter->update($validatedData);

        // Redirect back with success message
        return redirect()->route('newsletters.index')->with('success', 'Newsletter updated successfully!');
    }

    public function destroyComment($id)
    {
        // Find the comment by its ID
        $comment = NewsletterComment::findOrFail($id);

        // Check if the current user is the owner of the comment or an admin
        if (auth()->id() !== $comment->user_id && auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403); // Unauthorized if not the owner or admin
        }

        // Delete the comment
        $comment->delete();

        // Redirect back with success message
        return redirect()->route('newsletters.show', $comment->newsletter_id)->with('success', 'Comment deleted successfully!');
    }

    public function DashCreate()
    {
        return view('dashboard.newsletters.create');
    }
    public function DashStore(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
        ]);

        // Initialize the imagePath variable to null in case no image is uploaded
        $imagePath = null;

        // Check if an image file is uploaded
        if ($request->hasFile('image')) {
            // Store the image and get its path
            $imagePath = $request->file('image')->store('newsletters', 'public'); // Store in 'newsletters' folder
        }

        // Add the authenticated user's ID to the validated data
        $validatedData['user_id'] = auth()->id(); // Store the authenticated user's ID
        $validatedData['image'] = $imagePath; // Add the image path to the data

        // Create a new newsletter with the validated data
        Newsletter::create($validatedData);

        // Redirect back to the newsletters index with a success message
        return redirect()->route('newsletters.index')->with('success', 'Newsletter created successfully!');
    }
    public function search(Request $request)
    {
        $query = $request->get('query', '');

        $newsletters = Newsletter::with('user')
            ->where('title', 'LIKE', '%' . $query . '%')
            ->orWhere('content', 'LIKE', '%' . $query . '%')
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->get();

        return response()->json([
            'html' => view('theme.newsletters.newsletter_results', compact('newsletters'))->render()
        ]);
    }



}

<?PHP
namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Models\NewsletterLike;
use App\Models\NewsletterComment;
use App\Models\User;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the newsletters.
     */
    public function index()
    {
        $newsletters = Newsletter::all(); // Fetch all newsletters
        return view('dashboard.newsletters.index', compact('newsletters'));
    }

    /**
     * Show the form for creating a new newsletter.
     */
    public function create()
    {
        return view('dashboard.newsletters.create');
    }

    /**
     * Store a newly created newsletter in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Newsletter::create($validatedData);

        return redirect()->route('newsletters.index')->with('success', 'Newsletter created successfully!');
    }

    /**
     * Display the specified newsletter with its comments and likes.
     */
    public function show($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $comments = $newsletter->comments()->with('user')->get();
        $likes = $newsletter->likes;

        return view('dashboard.newsletters.show', compact('newsletter', 'comments', 'likes'));
    }

    /**
     * Show the form for editing the specified newsletter.
     */
    public function edit($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        return view('dashboard.newsletters.edit', compact('newsletter'));
    }

    /**
     * Update the specified newsletter in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $newsletter = Newsletter::findOrFail($id);
        $newsletter->update($validatedData);

        return redirect()->route('newsletters.index')->with('success', 'Newsletter updated successfully!');
    }

    /**
     * Remove the specified newsletter from storage.
     */
    public function destroy($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $newsletter->delete();

        return redirect()->route('newsletters.index')->with('success', 'Newsletter deleted successfully!');
    }

    /**
     * Like a newsletter.
     */
    public function like(Request $request, $id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $user = auth()->user();

        // Check if the user has already liked this newsletter
        if (!$newsletter->likes()->where('user_id', $user->id)->exists()) {
            NewsletterLike::create([
                'user_id' => $user->id,
                'newsletter_id' => $newsletter->id,
            ]);
        }

        return redirect()->route('newsletters.show', $newsletter->id);
    }

    /**
     * Comment on a newsletter.
     */
    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $newsletter = Newsletter::findOrFail($id);
        $user = auth()->user();

        NewsletterComment::create([
            'user_id' => $user->id,
            'newsletter_id' => $newsletter->id,
            'comment' => $request->comment,
        ]);

        return redirect()->route('newsletters.show', $newsletter->id);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            // Admin: show all blogs
            $blogs = Blog::with('user')->latest()->get();
        } elseif (Auth::guard('web')->check()) {
            // User: show only their blogs
            $user = Auth::guard('web')->user();
            $blogs = $user->blogs()->latest()->get();
        } else {
            abort(403); // unauthorized
        }
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024',
        ]);

        $blog = new Blog();
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('blogs', $filename, 'public');
            $blog->image = $filename;

        }
        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $blog = Blog::findOrFail($id);
        // return view('blogs.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        return view('blogs.edit',compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024',
        ]);

        $blog = Blog::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('blogs', $filename, 'public');
            $blog->image = $filename;
        }

        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->user_id = Auth::id();
       
        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }
    public function changeStatus(Request $request) {
        $request->validate([
            'status' => ['required', Rule::in([
                Blog::STATUS_PENDING,
                Blog::STATUS_PUBLISHED,
                Blog::STATUS_REJECTED
            ])],
        ]);

        $blog = Blog::findOrFail($request->id);
        $blog->status = $request->status;
        $blog->save();

        return response()->json([
            'new_status' => $blog->status
        ]);
    }
    public function publishedBlogs(Request $request) {
        $blogs = Blog::where('status', Blog::STATUS_PUBLISHED)->get();

        return view('blogs.published', compact('blogs'));
    }
     public function viewMore($id) {
        
        $blog = Blog::findOrFail($id);

        return view('blogs.show', compact('blog'));
    }
}

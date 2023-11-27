<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $posts = Post::latest()->get();
        $posts = Post::where('user_id', Auth::id())
        ->latest()
        ->paginate(10);

        return view('Posts.index', compact('posts'));   
        // return Inertia::render('Posts/Index.vue', [
        //     // You can pass data to the Inertia view here
        // ]);     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Posts.create');   

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            // Add any other validation rules as needed
        ]);
    
        // Create a new post
        Post::create([
            'title' => $request->input('title'),
            'comment' => $request->input('content'),
            'user_id' => Auth::id(),
            // Add any other fields as needed
        ]);
    
        return redirect()->route('posts.create')->with('success', 'Post added successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $post = Post::findorFail($id);

        return view('posts.show', compact('post'));        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $post = Post::findorFail($id);

        return view('Posts.edit', compact('post'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the post by its ID
        $post = Post::findOrFail($id);
    
        // Validate the form data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            
            // Add any other validation rules as needed
        ]);
    
        // Update the post with the new data
        $post->update([
            'title' => $request->input('title'),
            'comment' => $request->input('content'),
            'user_id' => Auth::id(),

            // Add any other fields as needed
        ]);
    
        return redirect()->route('posts.edit', $post->id)->with('success', 'Post updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the post by its ID
        $post = Post::findOrFail($id);
    
        // Delete the post
        $post->delete();
    
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}

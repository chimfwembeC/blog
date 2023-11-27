<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'comment' => 'required|string',
        ]);
        // dd($request->input('comment'));
        $user = Auth::user();
        $postId = $request->post_id;
        $post = Post::findorFail($postId);        

        // create a new comment
        Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'comment added successfully.');

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

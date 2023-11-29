<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\CommentLike;

use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function likeComment(Comment $comment)
    {
        $user = auth()->user();

        // Check if the user has already liked the comment
        $isLiked = $comment->commentLikes->contains('user_id', $user->id);

        if (!$isLiked) {
            // If not liked, add a new like
            $like = new CommentLike(['user_id' => $user->id]);
            $comment->commentLikes()->save($like);
        } else {
            // If already liked, remove the like
            $comment->commentLikes()->where('user_id', $user->id)->delete();
        }

        return redirect()->back();
    }
     /**
     * Store a newly created resource in storage.
     */
    public function edit(string $id)
    {
        //
        $comment = Comment::findOrFail($id);

        return view('Posts.index', compact('comment'));
    }

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
        $request->validate([
            'comment' => 'required|string',
        ]);
        //
        // $user = Auth::user();
        $postId = $request->post_id;
        $post = Post::findorFail($postId);        

        // create a new comment
        Comment::update([
            // 'user_id' => $user->id,
            'post_id' => $post->id,
            'content' => $request->input('comment'),
        ]);

        return redirect()->back()->with('success', 'comment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $comment = Comment::findOrFail($id);
    
        // Delete the post
        $comment->delete();
                return redirect()->back()->with('success', 'comment updated successfully.');

    
    }
}

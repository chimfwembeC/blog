<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function likePost($postId)
    {
        $user = Auth::user();
        //check if the user has already liked the post

        $existingLike = Like::where('user_id', $user->id)
        ->where('post_id', $postId)
        ->first();

        if($existingLike)
        {            
            $existingLike->delete();
            return redirect()->back()->with('success', 'Post unliked successfully');
        }

        Like::create([
            'user_id' => $user->id,
            'post_id' => $postId,
        ]);

        return redirect()->back()->with('success', 'Post liked successfully.');

    }

}

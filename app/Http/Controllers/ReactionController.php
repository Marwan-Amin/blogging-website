<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Overtrue\LaravelFollow\Traits\CanVote;

class ReactionController extends Controller
{
    public function like($id)
    {
        $user = Auth::user();
        $post = Post::find($id);

        if($user->hasUpvoted($post)) 
        {
            $user->cancelVote($post);
        } else {
            $user->upvote($post);
        }

        return redirect()->route('show',[
            'id' =>$post->id,
        ]);
    }

    public function unlike($id)
    {
        $user = Auth::user();
        $post = Post::find($id);

        if($user->hasDownvoted($post)) 
        {
            $user->cancelVote($post);
        } else {
            $user->downvote($post);
        }
        return redirect()->route('show',[
            'id' =>$post->id,
        ]);
    }

}

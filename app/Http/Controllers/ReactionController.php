<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Cog\Laravel\Love\ReactionType\Models\ReactionType;
use Cog\Laravel\Love\Reacter\Models\Reacter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Overtrue\LaravelFollow\Traits\CanVote;

class ReactionController extends Controller
{
    public function like($id)
    {
        $user = Auth::user();
        $post = Post::find($id);
        $user->upvote($post);

        return redirect()->route('show',[
            'id' =>$post->id,
        ]);
    }

    public function unlike($id)
    {
        $user = Auth::user();
        $post = Post::find($id);
        $user->downvote($post);

        return redirect()->route('show',[
            'id' =>$post->id,
        ]);
    }

}

<?php

namespace App\Repositories;

use App\Http\Requests\StorePost;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use \Overtrue\LaravelFollow\Traits\CanVote;


class PostRepository implements PostRepositoryInterface
{
    public function index()
    {
        $posts = Post::paginate(2);

        return view('home', [
            'posts' => $posts,
            'users' => User::all(),
        ]);
    }

    public function views()
    {
        $topViewedPosts = Post::orderBy('views_count','desc')->orderBy('voting_rank','desc')->paginate(2);

        return view('home', [
            'posts' => $topViewedPosts,
            'users' => User::all(),
        ]);
    }

    public function votes()
    {
        $posts = Post::all();
        
        foreach($posts as $post)
        {
            $upVoters = count($post->upvoters()->get());
            $downVoters = count($post->downvoters()->get());
            $votingRank = $upVoters - $downVoters;

            Post::where('id',$post->id)->update([
                'voting_rank' => $votingRank
            ]);
        }

        $rankedPosts = Post::orderBy('voting_rank','desc')->paginate(2);
        
        return view('home', [
            'posts' => $rankedPosts,
            'users' => User::all(),
        ]);
    }

    public function recommendPosts()
    {
        $posts = Post::all();
        
        foreach($posts as $post)
        {
            $votes = $post->voting_rank;
            $views = $post->views_count;
            if($votes != 0 || $views != 0)
            {
                $rank = ($votes / $views)*100;
                
                Post::where('id',$post->id)->update([
                    'post_rank' => $rank
                ]);
            } else if ($votes === null && $views === null) {
                $rank = 0;
                Post::where('id',$post->id)->update([
                    'post_rank' => $rank
                ]);
            }
        }



        $rankedPosts = Post::orderBy('post_rank','desc')->paginate(2);
        
        return view('home', [
            'posts' => $rankedPosts,
            'users' => User::all(),
        ]);
    }

    public function store(StorePost $request)
    {
        $image='';
        if(request()->post_image){
            $image =  Storage::putfile('blog_images', $request->file('post_image'));
            $request->post_image->move(public_path('blog_images'), $image);
        } 

        Post::create([
            'body' => $request->body,
            'blog_image' => $image,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('index');
    }

    public function delete($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect()->route('index');
    }

    public function update($id, Request $request)
    {
        $post_id = Post::findOrFail($id)->id;
        Post::where('id', $post_id)->update([
            'body' => $request->body,
            'blog_image' => $request->post_image
        ]);
        return redirect()->route('index');
    }

    public function show($id)
    {
        $post = Post::find($id);
        $expiresAt = now()->addHours(24);
        views($post)->cooldown($expiresAt)->record();
        $postViewsCount = views($post)->unique()->count();;
        Post::where('id',$post->id)->update([
            'views_count' => $postViewsCount
        ]);

        return view('post', [
            'post' => $post,
        ]);
    }
}

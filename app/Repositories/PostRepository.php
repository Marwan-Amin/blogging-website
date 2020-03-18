<?php

namespace App\Repositories;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostRepository implements PostRepositoryInterface
{
    public function index()
    {
        $posts = Post::paginate(2);
        $viewsCount =null;

        return view('home', [
            'posts' => $posts,
            'users' => User::all(),
        ]);
    }

    public function topViews()
    {
        $posts = Post::paginate(2);

        return view('home', [
            'posts' => $posts,
            'users' => User::all(),
        ]);
    }

    public function topVotes()
    {
        // dd(true);
        // $allPosts = Post::paginate(2);
        // dd($allPosts);
        // $posts = $allPosts->upvoters()->orderByDesc('id')->get();
        // dd($posts);
        $posts = Post::paginate(2);
        return view('home', [
            'posts' => $posts,
            'users' => User::all(),
        ]);
    }

    public function store(Request $request)
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
        
        return view('post', [
            'post' => $post,
        ]);
    }
}

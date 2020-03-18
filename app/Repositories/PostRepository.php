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
        return view('home',[
            'posts' => Post::all(), 
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $image = $request->post_image?Storage::putfile('blog_images', $request->file('post_image')):'null';
        
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
}

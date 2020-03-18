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
            'users' => User::paginate(5),
        ]);
    }

    public function topViews()
    {
        $posts = Post::orderByViews()->paginate(2);

        return view('home', [
            'posts' => $posts,
            'users' => User::paginate(5),
        ]);
    }

    public function store(Request $request)
    {
        $image = $request->post_image ? Storage::putfile('blog_images', $request->file('post_image')) : 'null';

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
        $viewsCount = views($post)->count();
        return view('post', [
            'post' => $post,
            'views' => $viewsCount
        ]);
    }
}

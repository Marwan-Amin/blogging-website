<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Post;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(Post $post)
    {
        $this->post = new PostRepository($post);
    }

    public function index()
    {
        return $this->post->index();
    }

    public function store(StorePost $request)
    {
        return $this->post->store($request);
    }

    public function destroy($id)
    {
        return $this->post->delete($id);
    }

    public function update($id, Request $request)
    {
        return $this->post->update($id, $request);
    }

    public function show($id)
    {
        return $this->post->show($id);
    }

    public function views()
    {
        return $this->post->views();
    }

    public function votes()
    {
        return $this->post->votes();
    }

    public function recommendPosts()
    {
        return $this->post->recommendPosts();
    }

}

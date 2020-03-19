<?php

namespace App\Repositories;

use App\Http\Requests\storePost;
use Illuminate\Http\Request;

interface PostRepositoryInterface
{
    public function index();
    public function store(storePost $request);
    public function delete($id);
    public function update($id, Request $request);
    public function show($id);
    public function views();
    public function votes();
    public function recommendPosts();

}
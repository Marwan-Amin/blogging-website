<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface PostRepositoryInterface
{
    public function index();
    public function store(Request $request);
    public function delete($id);
    public function update($id, Request $request);

}
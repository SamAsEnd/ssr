<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Mail\NewPost;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Website;
use App\Repositories\PostRepository;
use App\Services\PostService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function index(Website $website, PostRepository $repository): Collection
    {
        return $repository->all($website);
    }

    public function store(StorePostRequest $request, Website $website, PostService $service): Post|Model
    {
        return $service->store($website, $request->validated());
    }

    public function show(Website $website, Post $post): Post|Model
    {
        return $post;
    }

    public function update(UpdatePostRequest $request, Website $website, Post $post, PostService $service): Post|Model
    {
        return $service->update($post, $request->validated());
    }

    public function destroy(Website $website, Post $post, PostService $service)
    {
        return $service->destroy($post);
    }
}

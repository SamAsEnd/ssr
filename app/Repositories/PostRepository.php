<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\Website;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostRepository
{
    public function all(Website $website): Collection
    {
        return cache()->remember('posts.' . $website->id, now()->addHour(), function () use ($website) {
            return $website->posts()->latest()->get();
        });
    }

    public function find(string $postId): Post|Model|null
    {
        return Post::query()->find($postId);
    }
}

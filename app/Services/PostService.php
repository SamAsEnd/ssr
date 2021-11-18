<?php

namespace App\Services;

use App\Mail\NewPost;
use App\Models\Post;
use App\Models\Website;
use App\Repositories\WebsiteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class PostService
{
    private WebsiteRepository $websiteRepository;

    public function __construct(WebsiteRepository $websiteRepository)
    {
        $this->websiteRepository = $websiteRepository;
    }

    public function store(Website $website, array $validated): Post|Model
    {
        /** @var Post $post */
        $post = $website->posts()->create($validated);

        cache()->forget('posts.' . $post->website_id);

        foreach($this->websiteRepository->confirmedSubscribers($website) as $subscriber) {
            Mail::to($subscriber->email)->queue(new NewPost($subscriber, $post));
        }

        return $post;
    }

    public function update(Post $post, array $validated)
    {
        $post->update($validated);

        cache()->forget('posts.' . $post->website_id);
        // Should send an email with the updated content?

        return $post;
    }

    public function destroy(Post $post)
    {
        $post->delete();

        cache()->forget('posts.' . $post->website_id);

        return $post;
    }
}

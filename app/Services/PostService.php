<?php

namespace App\Services;

use App\Mail\NewPost;
use App\Models\Post;
use App\Models\Website;
use App\Repositories\SentMailRepository;
use App\Repositories\WebsiteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class PostService
{
    private WebsiteRepository $websiteRepository;
    private SentMailRepository $mailRepository;
    private SentMailService $mailService;

    public function __construct(WebsiteRepository $websiteRepository, SentMailRepository $mailRepository, SentMailService $mailService)
    {
        $this->websiteRepository = $websiteRepository;
        $this->mailRepository = $mailRepository;
        $this->mailService = $mailService;
    }

    public function store(Website $website, array $validated): Post|Model
    {
        /** @var Post $post */
        $post = $website->posts()->create($validated);

        cache()->forget('posts.' . $post->website_id);

        foreach($this->websiteRepository->confirmedSubscribers($website) as $subscriber) {
            if (! $this->mailRepository->exists($post, $subscriber)) {
                Mail::to($subscriber->email)->queue(new NewPost($subscriber, $post));
                $this->mailService->store($post, $subscriber);
            }
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

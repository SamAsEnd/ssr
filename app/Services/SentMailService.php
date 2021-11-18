<?php

namespace App\Services;

use App\Mail\NewPost;
use App\Models\Post;
use App\Models\SentMail;
use App\Models\Subscriber;
use App\Models\Website;
use App\Repositories\WebsiteRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class SentMailService
{
    public function store(Post $post, Subscriber $subscriber): SentMail|Model
    {
        return SentMail::create([
            'post_id' => $post->id,
            'subscriber_id' => $subscriber->id,
        ]);
    }
}

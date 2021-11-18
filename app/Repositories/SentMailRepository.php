<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\SentMail;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SentMailRepository
{
    public function exists(Post $post, Subscriber $subscriber): bool
    {
        return SentMail::query()->post($post)->subscriber($subscriber)->exists();
    }
}

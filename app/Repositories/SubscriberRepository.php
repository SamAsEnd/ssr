<?php

namespace App\Repositories;

use App\Models\Website;
use Illuminate\Database\Eloquent\Collection;

class SubscriberRepository
{
    public function all(Website $website): Collection
    {
        return $website->subscribers()->latest()->get();
    }
}

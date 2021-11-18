<?php

namespace App\Repositories;

use App\Models\Website;
use Illuminate\Database\Eloquent\Collection;

class WebsiteRepository
{
    public function all(): Collection
    {
        return cache()->remember('websites', now()->addHour(), function () {
            return Website::all();
        });
    }

    public function confirmedSubscribers(Website $website): Collection
    {
        return $website->subscribers()->confirmed()->get();
    }
}

<?php

namespace App\Services;

use App\Models\Website;
use Illuminate\Database\Eloquent\Model;

class WebsiteService
{
    public function store(array $validated): Website|Model
    {
        cache()->forget('websites');

        return Website::query()
            ->create($validated)
            ->makeVisible(['onboard_message', 'farewell_message']);
    }

    public function update(Website $website, array $validated)
    {
        $website->update($validated);

        cache()->forget('websites');

        return $website->makeVisible(['onboard_message', 'farewell_message']);
    }

    public function destroy(Website $website)
    {
        $website->delete();

        cache()->forget('websites');

        return $website;
    }
}

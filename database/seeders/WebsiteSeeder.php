<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Database\Seeder;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Website::create([
            'name' => 'The New York Times',
            'domain' => 'www.nytimes.com',
            'description' => 'The New York Times is an American daily newspaper based in New York City with a worldwide readership. Founded in 1851, the Times has since won 132 Pulitzer Prizes, the most of any newspaper, and has long been regarded within the industry as a national "newspaper of record".',
            'onboard_message' => 'Welcome to The New York Times, we are glad to have you.',
            'farewell_message' => 'We hate to see you go. We hope you will comeback soon.',
        ]);

        Website::factory(4)
            ->has(Post::factory()->count(3))
            ->has(Subscriber::factory()->count(3))
            ->create();
    }
}

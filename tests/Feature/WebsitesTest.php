<?php

namespace Tests\Feature;

use App\Models\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebsitesTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_websites()
    {
        $website = Website::factory()->create();

        $response = $this->get('/api/website');

        $response->assertStatus(200);
        $response->assertJsonFragment($website->jsonSerialize());
    }

    public function test_register_a_website()
    {
        $website = Website::factory()->make();

        $response = $this->post('/api/website', [
            'name' => $website->name,
            'domain' => $website->domain,
            'description' => $website->description,
            'onboard_message' => $website->onboard_message,
            'farewell_message' => $website->farewell_message,
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment($website->jsonSerialize());

        $this->assertDatabaseHas('websites', $website->jsonSerialize());
    }

    public function test_fetch_a_website()
    {
        $website = Website::factory()->create();

        $response = $this->get('/api/website/' . $website->id);

        $response->assertStatus(200);
        $response->assertJsonFragment($website->jsonSerialize());
    }

    public function test_update_a_website()
    {
        $website = Website::factory()->create();
        $newWebsite = Website::factory()->make();

        $response = $this->patch('/api/website/' . $website->id, $newWebsite
            ->makeVisible(['onboard_message', 'farewell_message'])
            ->jsonSerialize()
        );

        $response->assertStatus(200);
        $response->assertJsonFragment($newWebsite->jsonSerialize());

        $this->assertDatabaseMissing('websites', $website->jsonSerialize());
    }

    public function test_destroy_a_website()
    {
        $website = Website::factory()->create();

        $response = $this->delete('/api/website/' . $website->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('websites', $website->jsonSerialize());
    }
}

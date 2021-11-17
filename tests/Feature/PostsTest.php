<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_posts()
    {
        /** @var Post $post */
        $post = Post::factory()->create();

        $response = $this->get('/api/websites/' . $post->website_id . '/posts');

        $response->assertStatus(200);
        $response->assertJsonFragment($post->jsonSerialize());
    }

    public function test_get_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->get('/api/websites/' . $post->website_id . '/posts/' . $post->id);

        $response->assertStatus(200);
        $response->assertJsonFragment($post->jsonSerialize());
    }

    public function test_create_a_post()
    {
        $website = Website::factory()->create();
        $post = Post::factory()->make();

        $response = $this->post('/api/websites/' . $website->id . '/posts', $post->jsonSerialize());

        $post->website_id = $website->id;

        $response->assertStatus(201);
        $response->assertJsonFragment($post->jsonSerialize());
        $this->assertDatabaseHas('posts', $post->jsonSerialize());
    }

    public function test_update_a_post()
    {
        $post = Post::factory()->create();
        $newPost = Post::factory()->make();

        $response = $this->patch('/api/websites/' . $post->website_id . '/posts/' . $post->id, $newPost->jsonSerialize());

        $newPost->website_id = $post->website_id;

        $response->assertStatus(200);
        $response->assertJsonFragment($newPost->jsonSerialize());
        $this->assertDatabaseMissing('posts', $post->jsonSerialize());
    }

    public function test_delete_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->delete('/api/websites/' . $post->website_id . '/posts/' . $post->id, $post->jsonSerialize());

        $response->assertStatus(200);
        $this->assertDatabaseMissing('posts', $post->jsonSerialize());
        $this->assertDeleted($post);
    }
}

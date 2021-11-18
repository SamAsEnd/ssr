<?php

namespace Tests\Feature;

use App\Mail\ConfirmSubscription;
use App\Mail\GoodByeSubscriber;
use App\Mail\WelcomeSubscriber;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class SubscriptionsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_list_subscriptions()
    {
        $subscriber = Subscriber::factory()->create();

        $response = $this->get('/api/websites/' . $subscriber->website_id . '/subscribers');

        $response->assertStatus(200);
        $response->assertJsonFragment($subscriber->jsonSerialize());
    }

    public function test_get_subscriber()
    {
        $subscriber = Subscriber::factory()->create();

        $response = $this->get('/api/websites/' . $subscriber->website_id . '/subscribers/' . $subscriber->id);

        $response->assertStatus(200);
        $response->assertJsonFragment($subscriber->jsonSerialize());
    }

    public function test_can_subscribe()
    {
        $website = Website::factory()->create();
        $subscriber = Subscriber::factory()->make([
            'subscription_verified_at' => null,
        ]);

        Mail::fake();

        $response = $this->post('/api/websites/' . $website->id . '/subscribers', [
            'email' => $subscriber->email,
        ]);

        $response->assertStatus(201);
        $subscriber->website_id = $website->id;
        $response->assertJsonFragment($subscriber->makeHidden('subscription_verified_at')->jsonSerialize());

        $this->assertDatabaseHas('subscribers', [
            'email' => $subscriber->email,
            'website_id' => $website->id,
        ]);

        Mail::assertQueued(ConfirmSubscription::class);
    }

    public function test_confirm_subscription()
    {
        $subscriber = Subscriber::factory()->create([
            'subscription_verified_at' => null,
        ]);

        $url = URL::signedRoute('confirm-subscription', [$subscriber->website_id, $subscriber->id]);

        $this->assertDatabaseHas('subscribers', [
            'email' => $subscriber->email,
            'website_id' => $subscriber->website_id,
            'subscription_verified_at' => null,
        ]);

        Mail::fake();

        $response = $this->get($url);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('subscribers', [
            'email' => $subscriber->email,
            'website_id' => $subscriber->website_id,
            'subscription_verified_at' => null,
        ]);

        Mail::assertQueued(WelcomeSubscriber::class);
    }

    public function test_unsubscribe()
    {
        $subscriber = Subscriber::factory()->create();

        $url = URL::signedRoute('unsubscribe', [$subscriber->website_id, $subscriber->id]);

        $this->assertDatabaseHas('subscribers', [
            'email' => $subscriber->email,
            'website_id' => $subscriber->website_id,
        ]);

        Mail::fake();

        $response = $this->get($url);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('subscribers', [
            'email' => $subscriber->email,
            'website_id' => $subscriber->website_id,
        ]);

        Mail::assertQueued(GoodByeSubscriber::class);
    }
}

<?php

namespace App\Services;

use App\Mail\ConfirmSubscription;
use App\Mail\GoodByeSubscriber;
use App\Mail\NewPost;
use App\Mail\WelcomeSubscriber;
use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class SubscriberService
{
    public function subscribe(Website $website, array $validated): Subscriber|Model
    {
        $subscriber = $website->subscribers()->create($validated);

        Mail::to($subscriber->email)
            ->queue(new ConfirmSubscription($subscriber));

        return $subscriber;
    }

    public function confirm(Subscriber $subscriber): Subscriber|Model
    {
        if (!$subscriber->confirmed()) {
            $subscriber->update([
                'subscription_verified_at' => now(),
            ]);

            Mail::to($subscriber->email)
                ->queue(new WelcomeSubscriber($subscriber));
        }

        return $subscriber;
    }

    public function unsubscribe(Website $website, Subscriber $subscriber): Subscriber|Model
    {
        $email = $subscriber->email;
        $subscriber->delete();

        Mail::to($email)
            ->queue(new GoodByeSubscriber($website));

        return $subscriber;
    }
}

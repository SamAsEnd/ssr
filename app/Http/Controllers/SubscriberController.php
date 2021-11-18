<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberRequest;
use App\Http\Requests\UpdateSubscriberRequest;
use App\Mail\ConfirmSubscription;
use App\Mail\GoodByeSubscriber;
use App\Mail\WelcomeSubscriber;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Website $website)
    {
        return $website->subscribers()->latest()->paginate(10);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscriber  $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website, Subscriber $subscriber)
    {
        return $subscriber;
    }

    public function store(SubscriberRequest $request, Website $website)
    {
        $subscriber = $website->subscribers()->create($request->validated());

        Mail::to($subscriber->email)
            ->queue(new ConfirmSubscription($subscriber));

        return $subscriber;
    }

    public function confirm(Website $website, Subscriber $subscriber)
    {
        if (! $subscriber->confirmed()) {
            $subscriber->update([
                'subscription_verified_at' => now(),
            ]);

            Mail::to($subscriber->email)
                ->queue(new WelcomeSubscriber($subscriber));

        }

        return $subscriber;
    }

    public function unsubscribe(Website $website, Subscriber $subscriber)
    {
        $email = $subscriber->email;
        $subscriber->delete();

        Mail::to($email)
            ->queue(new GoodByeSubscriber($website));

        return $subscriber;
    }
}

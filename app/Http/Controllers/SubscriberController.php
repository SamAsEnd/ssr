<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriberRequest;
use App\Http\Requests\UpdateSubscriberRequest;
use App\Mail\ConfirmSubscription;
use App\Mail\GoodByeSubscriber;
use App\Mail\WelcomeSubscriber;
use App\Models\Subscriber;
use App\Models\Website;
use App\Repositories\SubscriberRepository;
use App\Services\SubscriberService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function index(Website $website, SubscriberRepository $repository): Collection
    {
        return $repository->all($website);
    }

    public function show(Website $website, Subscriber $subscriber): Subscriber|Model
    {
        return $subscriber;
    }

    public function store(SubscriberRequest $request, Website $website, SubscriberService $service)
    {
        return $service->subscribe($website, $request->validated());
    }

    public function confirm(Website $website, Subscriber $subscriber, SubscriberService $service)
    {
        return $service->confirm($subscriber);
    }

    public function unsubscribe(Website $website, Subscriber $subscriber, SubscriberService $service)
    {
        return $service->unsubscribe($website, $subscriber);
    }
}

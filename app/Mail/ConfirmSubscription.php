<?php

namespace App\Mail;

use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ConfirmSubscription extends Mailable
{
    use Queueable, SerializesModels;

    private Subscriber $subscriber;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $website = $this->subscriber->website;
        $url = URL::signedRoute('confirm-subscription', [$website->id, $this->subscriber->id]);
        $unsubscribeUrl = URL::signedRoute('unsubscribe', [$website->id, $this->subscriber->id]);

        return $this->markdown('emails.confirm_subscription')
            ->subject('Confirm your subscription')
            ->with('website', $website)
            ->with('url', $url)
            ->with('unsubscribeUrl', $unsubscribeUrl);
    }
}

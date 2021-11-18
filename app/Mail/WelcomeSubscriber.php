<?php

namespace App\Mail;

use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class WelcomeSubscriber extends Mailable
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
        $unsubscribeUrl = URL::signedRoute('unsubscribe', [$website->id, $this->subscriber->id]);

        return $this->markdown('emails.welcome_subscriber')
            ->subject('You have subscribed successfully.')
            ->with('website', $website)
            ->with('unsubscribeUrl', $unsubscribeUrl);
    }
}

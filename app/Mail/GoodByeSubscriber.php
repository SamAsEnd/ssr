<?php

namespace App\Mail;

use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class GoodByeSubscriber extends Mailable
{
    use Queueable, SerializesModels;

    private Website $website;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.goodbye_subscriber')
            ->subject('You have unsubscribed successfully.')
            ->with('website', $this->website);
    }
}

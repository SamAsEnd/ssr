<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class NewPost extends Mailable
{
    use Queueable, SerializesModels;

    private Subscriber $subscriber;
    private Post $post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Subscriber $subscriber, Post $post)
    {
        $this->subscriber = $subscriber;
        $this->post = $post;
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

        return $this->markdown('emails.new_post')
            ->with('website', $website)
            ->with('unsubscribeUrl', $unsubscribeUrl)
            ->with('post', $this->post);
    }
}

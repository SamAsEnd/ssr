<?php

namespace App\Console\Commands;

use App\Mail\NewPost;
use App\Models\SentMail;
use App\Repositories\PostRepository;
use App\Repositories\SentMailRepository;
use App\Repositories\WebsiteRepository;
use App\Services\SentMailService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mails
                            {post : The id of the post}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mails command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(
        PostRepository $repository,
        WebsiteRepository $websiteRepository,
        SentMailRepository $mailRepository,
        SentMailService $mailService)
    {
        $postId = $this->argument('post');

        $post = $repository->find($postId);

        if (!$post) {
            $this->error('Post not found');
            return Command::INVALID;
        }

        foreach($websiteRepository->confirmedSubscribers($post->website) as $subscriber) {
            if (! $mailRepository->exists($post, $subscriber)) {
                Mail::to($subscriber->email)->queue(new NewPost($subscriber, $post));
                $mailService->store($post, $subscriber);
            }
        }

        return Command::SUCCESS;
    }
}

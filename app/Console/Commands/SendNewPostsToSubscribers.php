<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Jobs\SendPostEmailJob;

class SendNewPostsToSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:send-new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newly created posts to website subscribers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get posts that have subscribers who have NOT yet received the post email
        // We eager load website and subscribers to avoid N+1 problem
        $posts = Post::with('website.subscribers')->get();

        foreach ($posts as $post) {
            $subscribers = $post->website->subscribers;

            foreach ($subscribers as $subscriber) {
                // Check if this subscriber already received this post
                if (!$post->subscribers()->where('subscriber_id', $subscriber->id)->exists()) {
                    // Dispatch job to send email
                    dispatch(new SendPostEmailJob($subscriber, $post));

                    // Mark subscriber as having received this post to avoid duplicates
                    $post->subscribers()->attach($subscriber->id);
                }
            }
        }

        $this->info('Dispatched email jobs for new posts to subscribers.');
    }

}


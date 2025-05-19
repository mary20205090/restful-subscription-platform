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
        $posts = Post::whereDoesntHave('subscribers')->with('website')->get();


        foreach ($posts as $post) {
            $subscribers = $post->website->subscribers;
            foreach ($subscribers as $subscriber) {
                dispatch(new SendPostEmailJob($subscriber, $post));
                $post->subscribers()->attach($subscriber->id);
            }
        }

    }
}


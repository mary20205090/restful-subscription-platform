<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Models\Subscriber;
use App\Models\Post;
use App\Mail\PostNotification;


class SendPostEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subscriber, $post;

    public function __construct(Subscriber $subscriber, Post $post)
    {
        $this->subscriber = $subscriber;
        $this->post = $post;
    }

    /**
     * Handle the job to send the email.
    */
    public function handle()
    {
        Mail::to($this->subscriber->email)->send(new PostNotification($this->post));
    }
}

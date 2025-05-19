<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;

class PostNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $post;

    /**
     * Create a new message instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Post: ' . $this->post->title)
                    ->html("
                        <h1>{$this->post->title}</h1>
                        <p>{$this->post->content}</p>
                        <p><small>Published on: {$this->post->created_at}</small></p>
                    ");
    }
}

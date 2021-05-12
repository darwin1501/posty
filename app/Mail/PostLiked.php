<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PostLiked extends Mailable
{
    use Queueable, SerializesModels;

    //these variables was set up globaly to 
    //access these variables at all functions on the class
    public $liker;

    public $post;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $liker, Post $post)
    {
        $this->liker = $liker;
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

     //the variable $liker and $post was 
     //accesible at the email template at markdown
    public function build()
    {
        return $this->markdown('emails.posts.post_liked');
    }
}

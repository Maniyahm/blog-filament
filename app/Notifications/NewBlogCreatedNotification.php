<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewBlogCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $blog;

    public function __construct($blog)
    {
        $this->blog = $blog;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'blog_id' => $this->blog->id,
            'title' => $this->blog->title,
            'author' => $this->blog->author->name,
            'created_at' => $this->blog->created_at,
            'message' => 'A new blog post has been created by ' . $this->blog->author->name,
        ];
    }
}


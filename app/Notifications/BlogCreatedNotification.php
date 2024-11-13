<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Blog;

class BlogCreatedNotification extends Notification
{
    use Queueable;

    protected $blog;

    public function __construct(Blog $blog)
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
            'message' => 'A new blog has been created by ' ,
            // 'url' => route('filament.resources.blogs.view', $this->blog->id), // Link to blog in Filament
        ];
    }
}

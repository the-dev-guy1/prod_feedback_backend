<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;

class MentionedInComment extends Notification
{
    protected $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function toMail($notifiable)
    {
        $frontendBaseUrl = Config::get('app.frontend_url', 'http://127.0.0.1:8000');

        return (new MailMessage)
            ->line('You have been mentioned in a comment.')
            ->action('View Comment', $frontendBaseUrl . '/comments/' . $this->comment->id)
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        $frontendBaseUrl = Config::get('app.frontend_url', 'http://127.0.0.1:8000');

        return [
            'comment_id' => $this->comment->id,
            'message' => 'You have been mentioned in a comment.',
            'link' => $frontendBaseUrl . '/comments/' . $this->comment->id,
        ];
    }
}

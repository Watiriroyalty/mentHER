<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Message;

class NewReplyNotification extends Notification
{
    use Queueable;

    protected $replyMessage;

    public function __construct($replyMessage)
    {
        $this->replyMessage = $replyMessage;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'A user replied to your previous message:',
            'sender_name' => $this->replyMessage->sender->name,
            'previous_message' => $this->replyMessage->message,
            'link' => route('messages.index'), // Adjust the route as needed
        ];
    }

    // ... (other methods like toMail, toArray, etc.)
}

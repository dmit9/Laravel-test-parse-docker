<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DataChangedNotification extends Notification
{
    use Queueable;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Price change!')
            ->line('New Price: ' . json_encode($this->data));
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

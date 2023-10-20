<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminPost extends Notification
{
    use Queueable;
    private $post, $worker;

    /**
     * Create a new notification instance.
     */
    public function __construct($post, $worker)
    {
        $this->post = $post;
        $this->worker = $worker;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }



    public function toDatabase(object $notifiable): array 
    {
        return [
            "post" => $this->post, 
            "worker" => $this->worker,      
        ];
    }
}



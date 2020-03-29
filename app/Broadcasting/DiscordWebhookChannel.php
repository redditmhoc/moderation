<?php

namespace App\Broadcasting;

use Illuminate\Notifications\Notification;

class DiscordWebhookChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toDiscordWebhook($notifiable);
    }
}

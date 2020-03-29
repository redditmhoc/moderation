<?php

namespace App\Notifications;

use App\Broadcasting\DiscordWebhookChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class BanEndNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ban)
    {
        $this->ban = $ban;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [DiscordWebhookChannel::class];
    }

    public function toDiscordWebhook($notifiable)
    {
        $ban = $this->ban;
        //Discord mod chat notification
        $hook = json_encode([
            "content" => "A ban for /u/".$ban->reddit_username. " has now ended. Ban details: ".route('actions.viewban', [$ban->reddit_username, $ban->id]),
            "username" => "Moderation Bot",
            "avatar_url" => "https://gexiii.lieselta.live/img/mhoc.png",
            "tts" => false,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        $ch = curl_init();
        curl_setopt_array( $ch, [
            CURLOPT_URL => config('services.discord.webhooks.discord_mods'),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $hook,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]);
        $response = curl_exec($ch);
        if (curl_error($ch)) {
            $error = curl_error($ch);
            Log::error($error);
        }
        curl_close($ch);
    }
}

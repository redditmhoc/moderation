<?php

namespace App\Console\Commands\ModerationActions;

use App\Models\ModerationActions\Ban;
use Illuminate\Console\Command;
use Woeler\DiscordPhp\Message\DiscordTextMessage;
use Woeler\DiscordPhp\Webhook\DiscordWebhook;

class SendBanExpiryRemindersCommand extends Command
{
    protected $signature = 'moderation-actions:send-ban-expiry-reminders';

    protected $description = 'As it says on the tin.';

    public function handle()
    {
        $this->info('Finding expiring bans...');

        $expiringBans = Ban::current()
            //->whereDate('end_at', '<', now()->addHours(48))
            ->where('expiry_reminder_sent', false)
            ->get();

        $this->info(count($expiringBans) . ' expiring bans found.');

        foreach ($expiringBans as $ban) {
            $ban->update(['expiry_reminder_sent' => true, 'expiry_reminder_sent_at' => now()]);
            $content = "The ban of {$ban->reddit_username} expires {$ban->end_at->diffForHumans()}. View here: " . route('site.moderation-actions.bans.show', $ban);

            $message = (new DiscordTextMessage())
                ->setContent($content);

            $webhook = new DiscordWebhook("https://discord.com/api/webhooks/" . config('services.discord.webhooks.mod_channel'));
            $response = $webhook->send($message);

            $this->info('Sent reminder for ban ' . $ban->id);
        }
    }
}

<?php

namespace App\Console\Commands\ModerationActions;

use App\Models\ModerationActions\Ban;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SendBanExpiryRemindersCommand extends Command
{
    protected $signature = 'moderation-actions:send-ban-expiry-reminders';

    protected $description = 'As it says on the tin.';

    public function handle()
    {
        $ban = Ban::current()->first();

        $content = "The ban of {$ban->reddit_username} expires {$ban->end_at->diffForHumans()}. View here: " . route('site.moderation-actions.bans.show', $ban);
        if (config('app.env') == '')

        Http::post('', [
            'content' => $content,
            'username' => 'Good news everyone!',
            'avatar_url' => 'https://i.imgflip.com/73sbv.jpg'
        ]);
    }
}

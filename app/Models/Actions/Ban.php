<?php

namespace App\Models\Actions;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $fillable = [
        'reddit_username', 'discord_user_id', 'strike_level', 'start_timestamp', 'end_timestamp', 'probation_length', 'moderator_id', 'reason', 'comments', 'evidence', 'auto_discord_ban', 'subreddit_ban', 'overturned', 'overturned_timestamp', 'overturned_comments', 'overturned_moderator_id'
    ];

    public function duration()
    {
        if (!$this->end_timestamp) return null;
        return Carbon::create($this->end_timestamp)->diffInDays($this->start_timestamp);
    }

    public function durationRemaining()
    {
        if (!$this->end_timestamp) return null;
        return Carbon::create($this->end_timestamp)->diffInDays();
    }

    public function current()
    {
        if ($this->permanent()) return false;
        if ($this->overturned) return false;
        if ($this->end_timestamp > Carbon::now() || !$this->end_timestamp) return true;
        return false;
    }

    public function permanent()
    {
        if (!$this->end_timestamp) return true; else return false;
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    public function overturnModerator()
    {
        return $this->belongsTo(User::class, 'overturned_moderator_id');
    }
}

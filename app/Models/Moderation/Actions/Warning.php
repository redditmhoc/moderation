<?php

namespace App\Models\Moderation\Actions;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    protected $fillable = [
        'reddit_username', 'discord_user_id', 'timestamp', 'muted_minutes', 'moderator_id', 'reason', 'comments'
    ];


    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }
}

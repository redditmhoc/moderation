<?php

namespace App\Models\Speakership;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Modmail extends Model
{
    protected $fillable = [
        'subject', 'content', 'timestamp', 'user_id', 'recipient_id', 'archived'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recipient()
    {
        return $this->hasOne(Role::class, 'recipient_id');
    }
}

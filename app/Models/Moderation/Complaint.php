<?php

namespace App\Models\Moderation;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'subject', 'content', 'timestamp', 'user_id', 'archived'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

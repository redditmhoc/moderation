<?php

namespace App\Policies\ModerationActions;

use App\Models\ModerationActions\Mute;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MutePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view moderation actions');
    }

    public function view(User $user): bool
    {
        return $user->can('view moderation actions');
    }

    public function create(User $user): bool
    {
        return $user->can('create mutes');
    }

    public function update(User $user, Mute $mute): bool
    {
        return $user->can('edit all mutes') || $mute->responsibleUser === $user;
    }

    public function delete(User $user, Mute $mute): bool
    {
        return $user->can('delete all mutes') || $mute->responsibleUser === $user;
    }
}

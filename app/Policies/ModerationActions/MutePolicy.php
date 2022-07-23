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

    public function viewAny(User $user): \Illuminate\Auth\Access\Response
    {
        return $user->can('view moderation actions')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user): \Illuminate\Auth\Access\Response
    {
        return $user->can('view moderation actions')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user): \Illuminate\Auth\Access\Response
    {
        return $user->can('create mutes')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Mute $mute): \Illuminate\Auth\Access\Response
    {
        return $user->can('edit all mutes') || $mute->responsibleUser === $user
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Mute $mute): \Illuminate\Auth\Access\Response
    {
        return $user->can('delete all mutes') || $mute->responsibleUser === $user
            ? $this->allow()
            : $this->denyAsNotFound();
    }
}

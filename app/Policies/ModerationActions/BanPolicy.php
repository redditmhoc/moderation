<?php

namespace App\Policies\ModerationActions;

use App\Models\ModerationActions\Ban;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BanPolicy
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
        return $user->can('create bans')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Ban $ban): \Illuminate\Auth\Access\Response
    {
        return $user->can('edit all bans') || $ban->responsibleUser === $user
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Ban $ban): \Illuminate\Auth\Access\Response
    {
        return $user->can('delete all bans') || $ban->responsibleUser === $user
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function overturn(User $user, Ban $ban): \Illuminate\Auth\Access\Response
    {
        return !$ban->overturned && $user->can('overturn bans')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function overturnPermanent(User $user, Ban $ban): \Illuminate\Auth\Access\Response
    {
        return !$ban->overturned && $user->can('overturn permanent bans')
            ? $this->allow()
            : $this->denyAsNotFound();
    }
}

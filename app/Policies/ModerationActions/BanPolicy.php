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
        return $user->can('create bans');
    }

    public function update(User $user, Ban $ban): bool
    {
        return $user->can('edit all bans') || $ban->responsibleUser === $user;
    }

    public function delete(User $user, Ban $ban): bool
    {
        return $user->can('delete all bans') || $ban->responsibleUser === $user;
    }

    public function overturn(User $user, Ban $ban): bool
    {
        return !$ban->overturned && $user->can('overturn bans');
    }

    public function overturnPermanent(User $user, Ban $ban): bool
    {
        return !$ban->overturned && $user->can('overturn permanent bans');
    }
}

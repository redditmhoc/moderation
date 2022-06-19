<?php

namespace App\Policies;

use App\Models\Ban;
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
        //
    }

    public function view(User $user, Ban $ban): bool
    {
        //
    }

    public function create(User $user): bool
    {
        //
    }

    public function update(User $user, Ban $ban): bool
    {
        //
    }

    public function delete(User $user, Ban $ban): bool
    {
        //
    }

    public function restore(User $user, Ban $ban): bool
    {
        //
    }

    public function forceDelete(User $user, Ban $ban): bool
    {
        //
    }
}

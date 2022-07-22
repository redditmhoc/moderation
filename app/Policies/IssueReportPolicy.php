<?php

namespace App\Policies;

use App\Models\IssueReport;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class IssueReportPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('Administrator');
    }

    public function view(User $user, IssueReport $issueReport): bool
    {
        return $user->hasRole('Adminstrator') || $issueReport->user === $user;
    }

    public function create(User $user): bool
    {
        return $user->can('access site');
    }

    public function update(User $user, IssueReport $issueReport): bool
    {
        return $user->hasRole('Administrator');
    }

    public function delete(User $user, IssueReport $issueReport): bool
    {
        return $user->hasRole('Administrator');
    }
}

<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny(User $user): bool
    {
        return $user->can('view notes');
    }

    public function view(User $user, Note $note): bool
    {
        return $user->can('view notes');
    }

    public function create(User $user): bool
    {
        return $user->can('create notes');
    }

    public function update(User $user, Note $note): bool
    {
        return $user->can('edit all notes') || $note->responsibleUser === $user;
    }

    public function delete(User $user, Note $note): bool
    {
        return $user->can('delete all notes') || $note->responsibleUser === $user;
    }
}

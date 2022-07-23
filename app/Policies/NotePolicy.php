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

    public function viewAny(User $user): \Illuminate\Auth\Access\Response
    {
        return $user->can('view notes')
            ? $this->allow()
            : $this->deny();
    }

    public function view(User $user, Note $note): \Illuminate\Auth\Access\Response
    {
        return $user->can('view notes')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function create(User $user): \Illuminate\Auth\Access\Response
    {
        return $user->can('create notes')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, Note $note): \Illuminate\Auth\Access\Response
    {
        return $user->can('edit all notes') || $note->responsibleUser === $user
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, Note $note): \Illuminate\Auth\Access\Response
    {
        return $user->can('delete all notes') || $note->responsibleUser === $user
            ? $this->allow()
            : $this->denyAsNotFound();
    }
}

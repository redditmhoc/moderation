<?php

namespace App\Policies;

use App\Models\ImageAttachment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImageAttachmentPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function create(User $user): \Illuminate\Auth\Access\Response
    {
        return $user->can('create image attachments')
            ? $this->allow()
            : $this->deny();
    }

    public function update(User $user, ImageAttachment $imageAttachment): \Illuminate\Auth\Access\Response
    {
        return $user->can('create image attachments')
            ? $this->allow()
            : $this->denyAsNotFound();
    }

    public function delete(User $user, ImageAttachment $imageAttachment): \Illuminate\Auth\Access\Response
    {
        return $user->can('delete image attachments')
            ? $this->allow()
            : $this->denyAsNotFound();
    }
}

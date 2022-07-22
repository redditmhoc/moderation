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

    public function create(User $user): bool
    {
        return $user->can('create image attachments');
    }

    public function update(User $user, ImageAttachment $imageAttachment): bool
    {
        return $user->can('create image attachments');
    }

    public function delete(User $user, ImageAttachment $imageAttachment): bool
    {
        return $user->can('delete image attachments');
    }
}

<?php

namespace App\Policies;

use App\User;
use App\NexusMessage;
use Illuminate\Auth\Access\HandlesAuthorization;

class NexusMessagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, NexusMessage $nexusMessage)
    {
        if ($user->isRoot()) {
            return true;
        }

        if ($user->isRoot() == false && in_array($nexusMessage->getUser()->id, config('cj-users.ids'))) {
            return true;
        }

        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, NexusMessage $nexusMessage)
    {
        return false;
    }

    public function delete(User $user, NexusMessage $nexusMessage)
    {
        return false;
    }

    public function restore(User $user, NexusMessage $nexusMessage)
    {
        return false;
    }

    public function forceDelete(User $user, NexusMessage $nexusMessage)
    {
        return false;
    }
}

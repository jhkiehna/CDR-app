<?php

namespace App\Policies;

use App\User;
use App\NexusCall;
use Illuminate\Auth\Access\HandlesAuthorization;

class NexusCallPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, NexusCall $nexusCall)
    {
        if ($user->isRoot()) {
            return true;
        }

        if ($user->isRoot() == false && in_array($nexusCall->user_id, config('cj-users.ids'))) {
            return true;
        }

        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, NexusCall $nexusCall)
    {
        return false;
    }

    public function delete(User $user, NexusCall $nexusCall)
    {
        return false;
    }

    public function restore(User $user, NexusCall $nexusCall)
    {
        return false;
    }

    public function forceDelete(User $user, NexusCall $nexusCall)
    {
        return false;
    }
}

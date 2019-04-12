<?php

namespace App\Policies;

use App\User;
use App\NexusUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class NexusUserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, NexusUser $nexusUser)
    {
        return true;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, NexusUser $nexusUser)
    {
        return false;
    }

    public function delete(User $user, NexusUser $nexusUser)
    {
        return false;
    }

    public function restore(User $user, NexusUser $nexusUser)
    {
        return false;
    }

    public function forceDelete(User $user, NexusUser $nexusUser)
    {
        return false;
    }
}

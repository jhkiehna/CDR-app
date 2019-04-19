<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, User $resourceUser)
    {
        if ($user->isRoot()) {
            return true;
        }

        if ($user->isRoot() == false && $resourceUser->isRoot() == false) {
            return true;
        }
        
        return false;
    }

    public function create(User $user)
    {
        if ($user->isRoot()) {
            return true;
        }

        return false;
    }

    public function update(User $user, User $resourceUser)
    {
        if ($user->isRoot()) {
            return true;
        }

        return false;
    }

    public function delete(User $user, User $resourceUser)
    {
        if ($user->isRoot()) {
            return true;
        }

        return false;
    }

    public function restore(User $user, User $resourceUser)
    {
        if ($user->isRoot()) {
            return true;
        }

        if ($user->isRoot() == false && $resourceUser->isRoot() == false) {
            return true;
        }

        return false;
    }

    public function forceDelete(User $user, User $resourceUser)
    {
        return false;
    }
}

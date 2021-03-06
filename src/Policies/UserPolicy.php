<?php

namespace Unite\UnisysApi\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Unite\UnisysApi\Models\Permission;
use Unite\UnisysApi\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \Unite\UnisysApi\Models\User  $user
     * @param  \Unite\UnisysApi\Models\User  $givenUser
     * @return mixed
     */
    public function view(User $user, User $givenUser)
    {
        if ($user->hasPermissionTo(Permission::USER_READ_ALL)) {
            return true;
        }

        return $user->id === $givenUser->id;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \Unite\UnisysApi\Models\User  $user
     * @param  \Unite\UnisysApi\Models\User  $givenUser
     * @return mixed
     */
    public function update(User $user, User $givenUser)
    {
        if ($user->hasPermissionTo(Permission::USER_UPDATE_ALL)) {
            return true;
        }

        return $user->id === $givenUser->id;
    }
}

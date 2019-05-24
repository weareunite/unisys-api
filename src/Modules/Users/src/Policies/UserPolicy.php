<?php

namespace Unite\UnisysApi\Modules\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Unite\UnisysApi\Modules\Permissions\Permission;
use Unite\UnisysApi\Modules\Users\User;

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
     * @param  \Unite\UnisysApi\Modules\Users\User  $user
     * @param  \Unite\UnisysApi\Modules\Users\User  $givenUser
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
     * @param  \Unite\UnisysApi\Modules\Users\User  $user
     * @param  \Unite\UnisysApi\Modules\Users\User  $givenUser
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

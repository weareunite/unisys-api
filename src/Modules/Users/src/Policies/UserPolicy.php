<?php

namespace Unite\UnisysApi\Modules\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
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

        return $user->id === $givenUser->id
            ? Response::allow()
            : Response::deny('You do not own this resource.');
    }

    /**
     * Determine if the given user can create posts.
     *
     * @param  \Unite\UnisysApi\Modules\Users\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo(Permission::USER_CREATE_ALL);
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

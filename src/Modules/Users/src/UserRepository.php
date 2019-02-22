<?php

namespace Unite\UnisysApi\Modules\Users;

use Unite\UnisysApi\Repositories\Repository;

class UserRepository extends Repository
{
    protected $modelClass = User::class;

    public function hasExactlyRole(User $user, $role)
    {
        if(!$user->hasRole($role)) {
            return false;
        }

        if($user->getRoleNames()->count() !== 1) {
            return false;
        }

        return true;
    }
}
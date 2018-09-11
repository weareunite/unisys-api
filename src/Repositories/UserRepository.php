<?php

namespace Unite\UnisysApi\Repositories;

use Unite\UnisysApi\Models\User;

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
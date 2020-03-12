<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL;

use Unite\UnisysApi\Modules\Users\User;

class ProfileType extends UserType
{
    protected $attributes = [
        'name'        => 'Profile',
        'description' => 'A user profile',
        'model'       => User::class,
    ];
}


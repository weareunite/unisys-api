<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL;

class ProfileType extends UserType
{
    public function attributes()
    : array
    {
        return [
            'name'        => 'Profile',
            'description' => 'A user profile',
            'model'       => config('unisys.user'),
        ];
    }
}


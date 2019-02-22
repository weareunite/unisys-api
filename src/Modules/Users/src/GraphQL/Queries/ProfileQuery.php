<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Queries;

use Illuminate\Support\Facades\Auth;
use Unite\UnisysApi\GraphQL\DetailQuery;
use Unite\UnisysApi\Modules\Users\GraphQL\UserType;

class ProfileQuery extends DetailQuery
{
    protected $attributes = [
        'name' => 'profile',
    ];

    protected function typeClass()
    : string
    {
        return UserType::class;
    }

    protected function beforeResolve($root, $args, $select, $with)
    {
        if(!isset($args['id'])) {
            $args['id'] = Auth::id();
        }

        return $args;
    }
}

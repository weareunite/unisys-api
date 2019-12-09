<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\Modules\Users\GraphQL\UserType;

class ListQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];

    protected function typeClass()
    : string
    {
        return UserType::class;
    }
}

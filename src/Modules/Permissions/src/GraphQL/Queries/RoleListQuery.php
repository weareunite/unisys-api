<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\Modules\Permissions\GraphQL\RoleType;

class RoleListQuery extends Query
{
    protected $attributes = [
        'name' => 'roles',
    ];

    protected function typeClass()
    : string
    {
        return RoleType::class;
    }
}

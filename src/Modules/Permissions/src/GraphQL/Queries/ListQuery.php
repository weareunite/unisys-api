<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\Modules\Permissions\GraphQL\PermissionType;

class ListQuery extends Query
{
    protected $attributes = [
        'name' => 'permissions',
    ];

    protected function typeClass()
    : string
    {
        return PermissionType::class;
    }
}

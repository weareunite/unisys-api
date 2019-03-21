<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\DetailQuery as BaseDetailQuery;
use Unite\UnisysApi\Modules\Permissions\GraphQL\RoleType;

class RoleDetailQuery extends BaseDetailQuery
{
    protected $attributes = [
        'name' => 'role',
    ];

    protected function typeClass()
    : string
    {
        return RoleType::class;
    }
}

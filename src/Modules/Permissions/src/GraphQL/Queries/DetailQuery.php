<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\DetailQuery as BaseDetailQuery;
use Unite\UnisysApi\Modules\Permissions\GraphQL\PermissionType;

class DetailQuery extends BaseDetailQuery
{
    protected $attributes = [
        'name' => 'permission',
    ];

    protected function typeClass()
    : string
    {
        return PermissionType::class;
    }
}

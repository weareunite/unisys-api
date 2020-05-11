<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Queries;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Queries\DetailQuery as BaseDetailQuery;
use Unite\UnisysApi\Modules\Permissions\Role;

class RoleDetailQuery extends BaseDetailQuery
{
    protected function modelClass()
    : string
    {
        return Role::class;
    }
}

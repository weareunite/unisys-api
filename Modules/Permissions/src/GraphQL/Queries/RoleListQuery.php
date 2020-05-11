<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Queries;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Queries\ListQuery as BaseListQuery;
use Unite\UnisysApi\Modules\Permissions\Role;

class RoleListQuery extends BaseListQuery
{
    protected function modelClass()
    : string
    {
        return Role::class;
    }
}

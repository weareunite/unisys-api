<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Queries;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\ListQuery as BaseListQuery;
use Unite\UnisysApi\Modules\Permissions\Permission;

class ListQuery extends BaseListQuery
{
    protected function modelClass()
    : string
    {
        return Permission::class;
    }
}

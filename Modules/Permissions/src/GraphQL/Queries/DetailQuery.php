<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL\Queries;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Queries\DetailQuery as BaseDetailQuery;
use Unite\UnisysApi\Modules\Permissions\Permission;

class DetailQuery extends BaseDetailQuery
{
    protected function modelClass()
    : string
    {
        return Permission::class;
    }
}

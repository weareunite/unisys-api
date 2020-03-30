<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Queries;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\ListQuery as BaseListQuery;

class ListQuery extends BaseListQuery
{
    protected function modelClass()
    : string
    {
        return config('unisys.user');
    }
}

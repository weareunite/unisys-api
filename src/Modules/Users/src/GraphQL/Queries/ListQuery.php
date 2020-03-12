<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Queries;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\ListQuery as BaseListQuery;
use Unite\UnisysApi\Modules\Users\User;

class ListQuery extends BaseListQuery
{
    protected function modelClass()
    : string
    {
        return User::class;
    }
}

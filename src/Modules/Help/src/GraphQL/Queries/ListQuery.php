<?php

namespace Unite\UnisysApi\Modules\Help\GraphQL\Queries;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\ListQuery as BaseListQuery;
use Unite\UnisysApi\Modules\Help\Help;

class ListQuery extends BaseListQuery
{
    protected function modelClass()
    : string
    {
        return Help::class;
    }
}

<?php

namespace Unite\UnisysApi\Modules\Tags\GraphQL;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\ListQuery as BaseListQuery;
use Unite\UnisysApi\Modules\Tags\Tag;

class ListQuery extends BaseListQuery
{
    protected function modelClass()
    : string
    {
        return Tag::class;
    }
}

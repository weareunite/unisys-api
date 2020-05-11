<?php

namespace Unite\UnisysApi\Modules\Media\GraphQL\Queries;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Queries\ListQuery as BaseListQuery;
use Unite\UnisysApi\Modules\Media\Models\Media;

class ListQuery extends BaseListQuery
{
    protected function modelClass()
    : string
    {
        return Media::class;
    }
}

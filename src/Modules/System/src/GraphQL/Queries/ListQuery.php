<?php

namespace Unite\UnisysApi\Modules\System\GraphQL\Queries;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\ListQuery as BaseListQuery;
use Unite\UnisysApi\Modules\System\SystemSetting;

class ListQuery extends BaseListQuery
{
    protected function modelClass()
    : string
    {
        return SystemSetting::class;
    }
}

<?php

namespace Unite\UnisysApi\Modules\ActivityLogs\GraphQL\Queries;

use Unite\UnisysApi\Modules\ActivityLogs\ActivityLog;
use Unite\UnisysApi\Modules\GraphQL\GraphQL\ListQuery as BaseListQuery;

class ListQuery extends BaseListQuery
{
    protected function modelClass()
    : string
    {
        return ActivityLog::class;
    }
}

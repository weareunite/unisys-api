<?php

namespace Unite\UnisysApi\Modules\ActivityLogs\GraphQL\Queries;

use Unite\UnisysApi\Modules\GraphQL\GraphQL\Queries\DetailQuery as BaseDetailQuery;
use Unite\UnisysApi\Modules\ActivityLogs\ActivityLog;

class DetailQuery extends BaseDetailQuery
{
    protected function modelClass()
    : string
    {
        return ActivityLog::class;
    }
}

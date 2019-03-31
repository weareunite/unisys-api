<?php

namespace Unite\UnisysApi\Modules\ActivityLogs\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\Modules\ActivityLogs\GraphQL\ActivityLogType;

class ListQuery extends Query
{
    protected $attributes = [
        'name' => 'activityLogs',
    ];

    protected function typeClass()
    : string
    {
        return ActivityLogType::class;
    }
}

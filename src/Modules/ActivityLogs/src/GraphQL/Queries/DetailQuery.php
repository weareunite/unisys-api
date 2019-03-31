<?php

namespace Unite\UnisysApi\Modules\ActivityLogs\GraphQL\Queries;

use Rebing\GraphQL\Support\SelectFields;
use Unite\UnisysApi\GraphQL\DetailQuery as BaseDetailQuery;
use Unite\UnisysApi\Modules\ActivityLogs\GraphQL\ActivityLogType;
use GraphQL\Type\Definition\Type;

class DetailQuery extends BaseDetailQuery
{
    protected $attributes = [
        'name' => 'activityLog',
    ];

    protected function typeClass()
    : string
    {
        return ActivityLogType::class;
    }
}

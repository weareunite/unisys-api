<?php

namespace Unite\UnisysApi\Modules\ActivityLogs\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\ActivityLogs\ActivityLog;

class ActivityLogType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'ActivityLog',
        'description' => 'A ActivityLog',
        'model'       => ActivityLog::class,
    ];

    public function fields()
    : array
    {
        return [
            'id'           => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of the activity',
            ],
            'log_name'     => [
                'type'        => Type::string(),
                'description' => 'The type of activity',
            ],
            'description'  => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The description of activity',
            ],
            'properties'   => [
                'type'        => Type::string(),
                'description' => 'The type of activity',
            ],
            'subject_id'   => [
                'type'        => Type::string(),
                'description' => 'The subject_id of activity',
            ],
            'subject_type' => [
                'type'        => Type::string(),
                'description' => 'The subject_type of activity',
            ],
            'causer_id'    => [
                'type'        => Type::string(),
                'description' => 'The causer_id of activity',
            ],
            'causer_type'  => [
                'type'        => Type::string(),
                'description' => 'The causer_type of activity',
            ],
            'created_at'   => [
                'type'        => Type::string(),
                'description' => 'The created_at of activity',
            ],
        ];
    }
}


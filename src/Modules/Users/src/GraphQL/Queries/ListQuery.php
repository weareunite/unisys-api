<?php

namespace Unite\UnisysApi\Modules\Users\GraphQL\Queries;

use Unite\UnisysApi\GraphQL\BuilderQuery as Query;
use Unite\UnisysApi\Modules\Users\GraphQL\UserType;

class ListQuery extends Query
{
    protected $attributes = [
        'name' => 'users',
    ];

    protected function typeClass()
    : string
    {
        return UserType::class;
    }

    public function customScope(&$query, $args)
    {
        $query->join('user_instance', 'user_instance.user_id', '=', 'users.id')
            ->where('user_instance.instance_id', '=', instanceId())
            ->distinct();

        return $query;
    }
}

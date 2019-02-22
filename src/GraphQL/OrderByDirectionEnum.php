<?php

namespace Unite\UnisysApi\GraphQL;

use Rebing\GraphQL\Support\Type as GraphQLType;

class OrderByDirectionEnum extends GraphQLType
{
    protected $enumObject = true;

    protected $attributes = [
        'name'        => 'OrderByDirectionEnum',
        'description' => 'A OrderBy for sort',
        'values' => [
            'desc',
            'asc',
        ],
    ];
}
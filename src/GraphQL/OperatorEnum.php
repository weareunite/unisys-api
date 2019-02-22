<?php

namespace Unite\UnisysApi\GraphQL;

use Rebing\GraphQL\Support\Type as GraphQLType;

class OperatorEnum extends GraphQLType
{
    protected $enumObject = true;

    protected $attributes = [
        'name'        => 'OperatorEnum',
        'description' => 'A operator for condition',
        'values' => [
            'and',
            'or',
            'between',
        ],
    ];
}
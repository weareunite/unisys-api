<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Enums;

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
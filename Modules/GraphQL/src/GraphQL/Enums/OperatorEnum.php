<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Enums;

use Rebing\GraphQL\Support\EnumType;

class OperatorEnum extends EnumType
{
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
<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Enums;

use Rebing\GraphQL\Support\EnumType;

class OrderByDirectionEnum extends EnumType
{
    protected $attributes = [
        'name'        => 'OrderByDirectionEnum',
        'description' => 'A OrderBy for sort',
        'values' => [
            'desc',
            'asc',
        ],
    ];
}
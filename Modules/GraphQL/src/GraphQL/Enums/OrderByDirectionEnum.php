<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Enums;

use Rebing\GraphQL\Support\EnumType;
use Unite\UnisysApi\Modules\GraphQL\Enums\OrderByDirection;

class OrderByDirectionEnum extends EnumType
{
    public function attributes()
    : array
    {
        return [
            'name'        => 'OrderByDirectionEnum',
            'description' => 'A OrderBy for sort',
            'values'      => array_values(OrderByDirection::toArray()),
        ];
    }
}
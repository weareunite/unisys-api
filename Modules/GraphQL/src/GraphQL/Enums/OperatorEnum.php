<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Enums;

use Rebing\GraphQL\Support\EnumType;
use Unite\UnisysApi\Modules\GraphQL\Enums\Operator;

class OperatorEnum extends EnumType
{
    public function attributes()
    : array
    {
        return [
            'name'        => 'OperatorEnum',
            'description' => 'A operator for condition',
            'values'      => array_values(Operator::toArray()),
        ];
    }
}
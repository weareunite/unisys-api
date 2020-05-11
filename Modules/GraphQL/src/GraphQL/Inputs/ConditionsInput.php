<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ConditionsInput extends Input
{
    protected $inputObject = true;

    protected $attributes = [
        'name'        => 'ConditionsInput',
        'description' => 'A basic conditions input for query builder',
    ];

    public function fields()
    : array
    {
        return [
            'field'    => [
                'name'        => 'field',
                'description' => 'A name of column for filtering',
                'type'        => Type::nonNull(Type::string()),
                'rules'       => [ 'string' ],
            ],
            'operator' => [
                'description' => 'Fields where search query will be searching',
                'type'        => GraphQL::type('OperatorEnum'),
                'rules'       => [ 'string' ],
            ],
            'values'   => [
                'description' => 'Fields where search query will be searching',
                'type'        => Type::nonNull(
                    Type::listOf(
                        Type::nonNull(Type::string())
                    )
                ),
                'rules'       => [ 'array' ],
            ],
        ];
    }
}
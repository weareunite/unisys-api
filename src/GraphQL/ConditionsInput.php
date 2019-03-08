<?php

namespace Unite\UnisysApi\GraphQL;

use GraphQL\Type\Definition\Type;
use GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ConditionsInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name'        => 'ConditionsInput',
        'description' => 'A basic conditions input for query builder',
    ];

    public function fields()
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
                'rules'       => [ 'string' ],
            ],
        ];
    }
}
<?php

namespace Unite\UnisysApi\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class SearchInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name'        => 'SearchInput',
        'description' => 'A basic search input for query builder',
    ];

    public function fields()
    {
        return [
            'query'  => [
                'name'        => 'query',
                'description' => 'A search query',
                'type'        => Type::nonNull(Type::string()),
                'rules'       => [ 'string' ],
            ],
            'fields' => [
                'description' => 'Fields where search query will be searching',
                'type'        => Type::nonNull(Type::listOf(Type::nonNull(Type::string()))),
            ],
        ];
    }
}
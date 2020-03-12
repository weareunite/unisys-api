<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;

class SearchInput extends Input
{
    protected $inputObject = true;

    protected $attributes = [
        'name'        => 'SearchInput',
        'description' => 'A basic search input for query builder',
    ];

    public function fields()
    : array
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
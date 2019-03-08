<?php

namespace Unite\UnisysApi\GraphQL;

use GraphQL\Type\Definition\Type;
use GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class QueryFilterInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name'        => 'QueryFilterInput',
        'description' => 'A basic filter input for query builder',
    ];

    public function fields()
    {
        return [
            'id'         => [
                'name'        => 'id',
                'description' => 'A id of specific resource',
                'type'        => Type::int(),
                'rules'       => [ 'numeric' ],
            ],
            'order'      => [
                'description' => 'Column for order by. `default:-' . config('query-filter.default_order_column') . '`',
                'type'        => Type::string(),
                'rules'       => [ 'string' ],
            ],
            'search'     => [
                'description' => 'Search phrase. eg. `search+string` or `%search+string`',
                'type'        => GraphQL::type('SearchInput'),
            ],
            'conditions' => [
                'description' => 'Conditions phrase',
                'type'        => Type::listOf(Type::nonNull(GraphQL::type('ConditionsInput'))),
            ],
        ];
    }
}
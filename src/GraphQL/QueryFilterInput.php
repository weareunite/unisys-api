<?php

namespace Unite\UnisysApi\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
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
            'limit'      => [
                'description' => 'Number of results. `default: ' . config('query-filter.default_limit') . '`, `max:' . config('query-filter.max_limit') . '`',
                'type'        => Type::int(),
                'rules'       => [ 'integer', 'min:1', 'max:' . config('query-filter.max_limit') ],
            ],
            'order'      => [
                'description' => 'Column for order by. `default:-' . config('query-filter.default_order_column') . '`',
                'type'        => Type::string(),
                'rules'       => [ 'string' ],
            ],
            'page'       => [
                'description' => 'Number of page',
                'type'        => Type::int(),
                'rules'       => [ 'integer', 'min:1' ],
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
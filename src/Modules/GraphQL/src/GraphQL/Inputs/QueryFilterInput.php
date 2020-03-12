<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class QueryFilterInput extends Input
{
    protected $inputObject = true;

    protected $attributes = [
        'name'        => 'QueryFilterInput',
        'description' => 'A basic filter input for query builder',
    ];

    public function fields()
    : array
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
            'distinct'   => [
                'description' => 'Get distinct values',
                'type'        => Type::boolean(),
            ],
            'conditions' => [
                'description' => 'Conditions phrase',
                'type'        => Type::listOf(Type::nonNull(GraphQL::type('ConditionsInput'))),
            ],
        ];
    }
}
<?php

namespace Unite\UnisysApi\Modules\GraphQL\GraphQL\Inputs;

use GraphQL\Type\Definition\Type;

class PaginationInput extends Input
{
    protected $attributes = [
        'description' => 'A paging input for set limit and page',
    ];

    public function fields()
    : array
    {
        return [
            'limit' => [
                'description' => 'Number of results. `default: ' . config('query-filter.default_limit') . '`, `max:' . config('query-filter.max_limit') . '`',
                'type'        => Type::int(),
                'rules'       => [ 'integer', 'min:1', 'max:' . config('query-filter.max_limit') ],
            ],
            'page'  => [
                'description' => 'Number of page',
                'type'        => Type::int(),
                'rules'       => [ 'integer', 'min:1' ],
            ],
        ];
    }
}
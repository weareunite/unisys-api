<?php

namespace Unite\UnisysApi\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PaginationInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name'        => 'PaginationInput',
        'description' => 'A paging input for set limit and page',
    ];

    public function fields()
    {
        return [
            'limit'      => [
                'description' => 'Number of results. `default: ' . config('query-filter.default_limit') . '`, `max:' . config('query-filter.max_limit') . '`',
                'type'        => Type::int(),
                'rules'       => [ 'integer', 'min:1', 'max:' . config('query-filter.max_limit') ],
            ],
            'page'       => [
                'description' => 'Number of page',
                'type'        => Type::int(),
                'rules'       => [ 'integer', 'min:1' ],
            ],
        ];
    }

    protected static function prepareValue(string $type, $value = null)
    {
        if(isset($value[$type]) && is_numeric($value[$type])) {
            return $value[$type];
        }

        if(isset($value['paging'][$type]) && is_numeric($value['paging'][$type])) {
            return $value['paging'][$type];
        }

        if(isset($value['pagination'][$type]) && is_numeric($value['pagination'][$type])) {
            return $value['pagination'][$type];
        }

        return null;
    }

    public static function handleLimit($value = null)
    {
        $value = self::prepareValue('limit', $value);

        $limit = $value ?: config('query-filter.default_limit');

        if ($limit > config('query-filter.max_limit')) {
            $limit = config('query-filter.max_limit');
        }

        return $limit;
    }

    public static function handlePage($value = null)
    {
        $value = self::prepareValue('page', $value);

        return $value ?: 1;
    }
}
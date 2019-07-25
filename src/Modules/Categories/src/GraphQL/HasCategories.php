<?php

namespace Unite\UnisysApi\Modules\Categories\GraphQL;

use GraphQL;
use GraphQL\Type\Definition\Type;

trait HasCategories
{
    public function categoriesField()
    : array
    {
        return [
            'categories' => [
                'type'        => Type::listOf(Type::nonNull(GraphQL::type('Category'))),
                'description' => 'The categories',
            ],
        ];
    }

    public function createCategories(\Unite\UnisysApi\Modules\Categories\Contracts\HasCategories $model, $args)
    {
        if (isset($args['categories'])) {
            $model->attachCategories(collect($args['categories'])->pluck('id')->toArray());
        }
    }

}
<?php

namespace Unite\UnisysApi\Modules\Categories\GraphQL;

use GraphQL;
use GraphQL\Type\Definition\Type;

trait HasCategories
{
    protected $categoriesFieldName = 'categories';
    protected $categoriesArgsName = 'category_ids';

    public function categoriesField(string $name = null)
    : array
    {
        $name = $this->categoriesFieldName = $name ?? $this->categoriesFieldName;

        return [
            $name => [
                'type'        => Type::listOf(Type::nonNull(GraphQL::type('Category'))),
                'description' => 'The categories',
            ],
        ];
    }

    public function categoriesArgs(string $name = null)
    : array
    {
        $name = $this->categoriesArgsName = $name ?? $this->categoriesArgsName;

        return [
            $name => [
                'type'        => Type::listOf(Type::nonNull(Type::int())),
                'description' => 'The categories',
            ],
        ];
    }

    public function syncCategories(\Unite\UnisysApi\Modules\Categories\Contracts\HasCategories $model, $args)
    {
        if (isset($args[$this->categoriesArgsName])) {
            $model->syncCategories($args[$this->categoriesArgsName]);
        }
    }

}
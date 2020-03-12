<?php

namespace Unite\UnisysApi\Modules\Categories\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Categories\Category;
use Unite\UnisysApi\Modules\Properties\GraphQL\PropertyType;

class CategoryType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Category',
        'description' => 'A categories',
        'model'       => Category::class,
    ];

    public function fields()
    : array
    {
        return array_merge(
            [
                'id'   => [
                    'type'        => Type::nonNull(Type::int()),
                    'description' => 'The id of the category',
                ],
                'name' => [
                    'type'        => Type::string(),
                    'description' => 'The name of category',
                ],
            ],
            PropertyType::propertiesField()
        );
    }
}

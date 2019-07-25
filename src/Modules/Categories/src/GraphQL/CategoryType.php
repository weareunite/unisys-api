<?php

namespace Unite\UnisysApi\Modules\Categories\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Categories\Category;
use Unite\UnisysApi\Modules\Properties\GraphQL\HasProperties;
use Unite\UnisysApi\Modules\Properties\GraphQL\HasPropertiesContract;

class CategoryType extends GraphQLType implements HasPropertiesContract
{
    use HasProperties;

    protected $attributes = [
        'name'        => 'Category',
        'description' => 'A categories',
        'model'       => Category::class,
    ];

    public function fields()
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
            $this->propertiesField()
        );
    }
}

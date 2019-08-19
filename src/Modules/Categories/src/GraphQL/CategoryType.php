<?php

namespace Unite\UnisysApi\Modules\Categories\GraphQL;

use GraphQL;
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

    public static function categoriesField()
    : array
    {
        return [
            'categories' => [
                'type'        => Type::listOf(Type::nonNull(GraphQL::type('Category'))),
                'description' => 'The categories',
            ],
        ];
    }

    public static function categoriesIdsArgs()
    : array
    {
        return [
            'category_ids' => [
                'type'        => Type::listOf(Type::nonNull(Type::int())),
                'description' => 'The categories',
            ],
        ];
    }

    public static function syncCategoryIds(\Unite\UnisysApi\Modules\Categories\Contracts\HasCategories $model, $args)
    {
        if (isset($args['category_ids'])) {
            $model->syncCategories($args['category_ids']);
        }
    }

    public static function categoriesNamesArgs()
    : array
    {
        return [
            'category_names' => [
                'type'        => Type::listOf(Type::nonNull(Type::string())),
                'description' => 'The category names',
            ],
        ];
    }

    public static function syncCategoriesByNames(\Unite\UnisysApi\Modules\Categories\Contracts\HasCategories $model, $args)
    {
        if (isset($args['category_names'])) {
            $model->syncCategoriesByNames($args['category_names']);
        }
    }
}

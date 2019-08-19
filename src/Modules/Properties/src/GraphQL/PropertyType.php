<?php

namespace Unite\UnisysApi\Modules\Properties\GraphQL;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Properties\Property;

class PropertyType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Property',
        'description' => 'A property',
        'model'       => Property::class,
    ];

    public function fields()
    {
        return [
            'key'   => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The key of property',
            ],
            'value' => [
                'type'        => Type::string(),
                'description' => 'The value of property',
            ],
        ];
    }

    public static function propertiesField()
    : array
    {
        return [
            'properties' => [
                'type'        => Type::listOf(Type::nonNull(GraphQL::type('Property'))),
                'description' => 'The properties',
            ],
        ];
    }

    public static function propertiesArgs()
    : array
    {
        return [
            'properties' => [
                'type'        => Type::listOf(Type::nonNull(GraphQL::type('PropertyInput'))),
                'description' => 'The properties',
            ],
        ];
    }

    public static function createProperties(\Unite\UnisysApi\Modules\Properties\Contracts\HasProperties $model, $args)
    {
        if(isset($args['properties'])) {
            foreach ($args['properties'] as $property) {
                $model->addProperty($property['key'], $property['value']);
            }
        }
    }
}

<?php

namespace Unite\UnisysApi\Modules\Properties\GraphQL;

use GraphQL;
use GraphQL\Type\Definition\Type;

trait HasProperties
{
    public function propertiesField()
    : array
    {
        return [
            'properties' => [
                'type'        => Type::listOf(Type::nonNull(GraphQL::type('Property'))),
                'description' => 'The properties',
            ],
        ];
    }

    public function createProperties(\Unite\UnisysApi\Modules\Properties\Contracts\HasProperties $model, $args)
    {
        if(isset($args['properties'])) {
            foreach ($args['properties'] as $property) {
                $model->addProperty($property['key'], $property['value']);
            }
        }
    }

}
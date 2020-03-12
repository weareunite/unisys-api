<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Permissions\Permission;

class PermissionType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Permission',
        'description' => 'A Permission',
        'model'       => Permission::class,
    ];

    public function fields()
    : array
    {
        return [
            'id'         => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of the permission',
            ],
            'name'       => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The name of permission',
            ],
            'guard_name' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The guard_name of permission',
            ],
        ];
    }
}

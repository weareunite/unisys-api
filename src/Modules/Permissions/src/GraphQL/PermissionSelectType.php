<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Permissions\Permission;

class PermissionSelectType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'PermissionSelect',
        'description' => 'A Permission with Selected¬',
        'model'       => Permission::class,
    ];

    public function fields()
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
            'selected'   => [
                'type'        => Type::nonNull(Type::boolean()),
                'description' => 'If permission is selected',
            ],
        ];
    }
}

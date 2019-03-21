<?php

namespace Unite\UnisysApi\Modules\Permissions\GraphQL;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Unite\UnisysApi\Modules\Permissions\Role;

class RoleType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Role',
        'description' => 'A role',
        'model'       => Role::class,
    ];

    public function fields()
    {
        return [
            'id'                   => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of the role',
            ],
            'name'                 => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The name of role',
            ],
            'guard_name'           => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The guard_name of role',
            ],
            'frontend_permissions' => [
                'type'        => Type::listOf(GraphQL::type('PermissionSelect')),
                'description' => 'The all permissions',
                'selectable'  => false,
            ],
            'api_permissions'      => [
                'type'        => Type::listOf(GraphQL::type('PermissionSelect')),
                'description' => 'The all permissions',
                'selectable'  => false,
            ],
        ];
    }

    protected function resolveFrontendPermissionsField(Role $root, $args)
    {
        return $root->getAllPermissionsWithSelected()->where('guard_name', '=', 'frontend')->values();
    }

    protected function resolveApiPermissionsField(Role $root, $args)
    {
        return $root->getAllPermissionsWithSelected()->where('guard_name', '=', 'api')->values();
    }
}


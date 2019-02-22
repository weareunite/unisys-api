<?php

namespace Unite\UnisysApi\GraphQL\Permissions;

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
            'id'         => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of the role',
            ],
            'name'       => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The name of role',
            ],
            'guard_name' => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The guard_name of role',
            ],
        ];
    }
}


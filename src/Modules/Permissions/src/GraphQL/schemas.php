<?php

/*
 * The schemas for query and/or mutation. It expects an array to provide
 * both the 'query' fields and the 'mutation' fields. You can also
 * provide an GraphQL\Type\Schema object directly.
 *
 * Example:
 *
 *     'default' => new Schema($config)
 *
 * or
 *
 *     'default' => [
 *         'query' => [
 *              'users' => 'App\GraphQL\Query\UsersQuery'
 *          ],
 *          'mutation' => [
 *
 *          ]
 *     ]
 */
return [
    'default' => [
        'query'    => [
            \Unite\UnisysApi\Modules\Permissions\GraphQL\Queries\DetailQuery::class,
            \Unite\UnisysApi\Modules\Permissions\GraphQL\Queries\ListQuery::class,

            \Unite\UnisysApi\Modules\Permissions\GraphQL\Queries\RoleDetailQuery::class,
            \Unite\UnisysApi\Modules\Permissions\GraphQL\Queries\RoleListQuery::class,
        ],
        'mutation' => [
            \Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations\CreateMutation::class,
            \Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations\UpdateMutation::class,
            \Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations\DeleteMutation::class,

            \Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations\CreateRoleMutation::class,
            \Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations\UpdateRoleMutation::class,
            \Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations\DeleteRoleMutation::class,

            \Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations\SynchronizeMutation::class,

            \Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations\MassDeleteRolesMutation::class,
            \Unite\UnisysApi\Modules\Permissions\GraphQL\Mutations\MassDeletePermissionsMutation::class,

        ],
    ],
];
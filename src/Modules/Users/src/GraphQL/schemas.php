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
 *     'admin' => [
 *         'query' => [
 *              'users' => 'App\GraphQL\Query\UsersQuery'
 *          ],
 *          'mutation' => [
 *
 *          ]
 *     ]
 */

return [
    'admin' => [
        'query' => [
            \Unite\UnisysApi\Modules\Users\GraphQL\Queries\ListQuery::class,
            \Unite\UnisysApi\Modules\Users\GraphQL\Queries\DetailQuery::class,
            \Unite\UnisysApi\Modules\Users\GraphQL\Queries\ProfileQuery::class,
        ],
        'mutation' => [
            \Unite\UnisysApi\Modules\Users\GraphQL\Mutations\CreateMutation::class,
            \Unite\UnisysApi\Modules\Users\GraphQL\Mutations\UpdateMutation::class,
            \Unite\UnisysApi\Modules\Users\GraphQL\Mutations\DeleteMutation::class,
            \Unite\UnisysApi\Modules\Users\GraphQL\Mutations\MassDeleteMutation::class,
        ],
    ],
];
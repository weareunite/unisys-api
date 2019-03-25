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
        'query' => [
            \Unite\UnisysApi\Modules\Help\GraphQL\Queries\ListQuery::class,
            \Unite\UnisysApi\Modules\Help\GraphQL\Queries\DetailQuery::class,
        ],
        'mutation' => [
            \Unite\UnisysApi\Modules\Help\GraphQL\Mutations\CreateMutation::class,
            \Unite\UnisysApi\Modules\Help\GraphQL\Mutations\UpdateMutation::class,
            \Unite\UnisysApi\Modules\Help\GraphQL\Mutations\DeleteMutation::class,
            \Unite\UnisysApi\Modules\Help\GraphQL\Mutations\MassDeleteMutation::class,
        ],
    ],
];
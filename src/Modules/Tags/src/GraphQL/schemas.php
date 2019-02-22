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
            \Unite\UnisysApi\Modules\Tags\GraphQL\ListQuery::class,
        ],
        'mutation' => [
            \Unite\UnisysApi\Modules\Tags\GraphQL\Mutations\CreateMutation::class,
            \Unite\UnisysApi\Modules\Tags\GraphQL\Mutations\UpdateMutation::class,
            \Unite\UnisysApi\Modules\Tags\GraphQL\Mutations\DeleteMutation::class,
        ],
    ],
];
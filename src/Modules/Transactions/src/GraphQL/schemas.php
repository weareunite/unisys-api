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
            \Unite\UnisysApi\Modules\Transactions\GraphQL\Queries\ListQuery::class,
            \Unite\UnisysApi\Modules\Transactions\GraphQL\Queries\SourceListQuery::class,
        ],
        'mutation' => [
            \Unite\UnisysApi\Modules\Transactions\GraphQL\Mutations\DeleteMutation::class,
            \Unite\UnisysApi\Modules\Transactions\GraphQL\Mutations\CancelMutation::class,
        ],
    ],
];
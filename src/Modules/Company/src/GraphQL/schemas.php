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
            \Unite\UnisysApi\Modules\Company\GraphQL\Queries\DetailQuery::class,
        ],
        'mutation' => [
            \Unite\UnisysApi\Modules\Company\GraphQL\Mutations\CreateMutation::class,
            \Unite\UnisysApi\Modules\Company\GraphQL\Mutations\UpdateMutation::class,
        ],
    ],
];
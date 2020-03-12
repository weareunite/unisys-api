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
            \Unite\UnisysApi\Modules\Contacts\GraphQL\Queries\ContactsQuery::class,
            \Unite\UnisysApi\Modules\Contacts\GraphQL\Queries\CountriesQuery::class,
        ],
        'mutation' => [
            \Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations\CreateMutation::class,
            \Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations\UpdateMutation::class,
            \Unite\UnisysApi\Modules\Contacts\GraphQL\Mutations\DeleteMutation::class,
        ],
    ],
];
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
            \Unite\UnisysApi\Modules\Settings\GraphQL\Queries\ListQuery::class,
            \Unite\UnisysApi\Modules\Settings\GraphQL\Queries\SettingQuery::class,
            \Unite\UnisysApi\Modules\Settings\GraphQL\Queries\CompanyProfileQuery::class,
        ],
        'mutation' => [
            \Unite\UnisysApi\Modules\Settings\GraphQL\Mutations\CreateMutation::class,
            \Unite\UnisysApi\Modules\Settings\GraphQL\Mutations\UpdateMutation::class,
            \Unite\UnisysApi\Modules\Settings\GraphQL\Mutations\DeleteMutation::class,
            \Unite\UnisysApi\Modules\Settings\GraphQL\Mutations\UpdateCompanyMutation::class,
        ],
    ]
];
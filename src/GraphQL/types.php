<?php

/*
 * The types available in the application. You can access them from the
 * facade like this: GraphQL::type('user')
 *
 * Example:
 *
 *     'user' => 'App\GraphQL\Type\UserType'
 *
 * or without specifying a key (it will use the ->name property of your type)
 *
 *     'App\GraphQL\Type\UserType'
 */
return [
    \Unite\UnisysApi\GraphQL\PaginationInput::class,
    \Unite\UnisysApi\GraphQL\QueryFilterInput::class,
    \Unite\UnisysApi\GraphQL\SearchInput::class,
    \Unite\UnisysApi\GraphQL\ConditionsInput::class,
    \Unite\UnisysApi\GraphQL\OperatorEnum::class
];
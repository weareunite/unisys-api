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
    \Unite\UnisysApi\Modules\Contacts\GraphQL\ContactType::class,
    \Unite\UnisysApi\Modules\Contacts\GraphQL\CountryType::class,
];
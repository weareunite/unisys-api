<?php

return [
    'query-filter' => [
        'default_limit' => 25,

        'max_limit' => 100,

        'default_order_column' => 'id',

        'default_order_direction' => 'desc',

        'page_name' => 'page',
    ],

    'user' => \Unite\UnisysApi\Modules\Users\User::class,

    'userInput' => \Unite\UnisysApi\Modules\Users\GraphQL\Inputs\UserInput::class,

    'userType' => \Unite\UnisysApi\Modules\Users\GraphQL\UserType::class,
];
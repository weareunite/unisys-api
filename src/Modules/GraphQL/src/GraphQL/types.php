<?php

use Unite\UnisysApi\Modules\GraphQL\GraphQL;

return [
    GraphQL\Inputs\PaginationInput::class,
    GraphQL\Inputs\QueryFilterInput::class,
    GraphQL\Inputs\SearchInput::class,
    GraphQL\Inputs\ConditionsInput::class,
    GraphQL\Enums\OperatorEnum::class,
    GraphQL\Enums\OrderByDirectionEnum::class,
];
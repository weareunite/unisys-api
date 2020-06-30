<?php

namespace Unite\UnisysApi\QueryBuilder\Parsers;

use Unite\UnisysApi\Modules\GraphQL\Enums\OrderByDirection;
use Unite\UnisysApi\QueryBuilder\Types\OrderBy;

class OrderParser extends Parser
{
    protected function handle($value = null)
    {
        if (!$value) {
            $column = config('unisys.query-filter.default_order_column');
            $direction = config('unisys.query-filter.default_order_direction');
        } elseif (mb_substr($value, 0, 1, "utf-8") === '-') {
            $direction = OrderByDirection::DESC()->getValue();
            $column = substr($value, 1);
        } else {
            $direction = OrderByDirection::ASC()->getValue();
            $column = $value;
        }

        $column = $this->queryBuilder->resolveColumn($column);

        return new OrderBy($column, $direction);
    }
}
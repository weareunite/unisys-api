<?php

namespace Unite\UnisysApi\QueryBuilder\Parsers;

class LimitParser extends Parser
{
    protected function handle($value = null)
    {
        $limit = $value ?: config('unisys.query-filter.default_limit');

        if ($limit > config('unisys.query-filter.max_limit')) {
            $limit = config('unisys.query-filter.max_limit');
        }

        return $limit;
    }
}
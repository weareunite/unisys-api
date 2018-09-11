<?php

namespace Unite\UnisysApi\QueryBuilder\Parsers;

class PageParser extends Parser
{
    protected function handle($value = null)
    {
        return $value ?: 1;
    }
}
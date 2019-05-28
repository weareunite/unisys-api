<?php

namespace Unite\UnisysApi\GraphQLQueryBuilder\Parsers;

abstract class Parser
{
    public function parse($value)
    {
        return $this->handle($value);
    }

    abstract protected function handle($value);
}
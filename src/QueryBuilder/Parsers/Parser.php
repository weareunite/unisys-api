<?php

namespace Unite\UnisysApi\QueryBuilder\Parsers;

abstract class Parser
{
    public function parse($value = null)
    {
        return $this->handle($value);
    }

    abstract protected function handle($value = null);
}
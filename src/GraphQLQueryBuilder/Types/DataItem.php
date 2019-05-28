<?php

namespace Unite\UnisysApi\GraphQLQueryBuilder\Types;

class DataItem extends Type
{
    /** @var string  */
    public $operator;

    /** @var string  */
    public $value;

    public function __construct(string $operator, string $value)
    {
        $this->operator = $operator;
        $this->value = $value;
    }
}
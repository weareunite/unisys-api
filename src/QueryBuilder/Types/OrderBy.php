<?php

namespace Unite\UnisysApi\QueryBuilder\Types;

class OrderBy extends Type
{
    /**
     * @var Column
     */
    public $column;

    /**
     * @var string
     */
    public $direction;

    public function __construct(Column $column, string $direction)
    {
        $this->column = $column;
        $this->direction = $direction;
    }
}
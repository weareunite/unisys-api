<?php

namespace Unite\UnisysApi\QueryBuilder\Types;

class Search extends Type
{
    /** @var string|null */
    public $query;

    /** @var \Illuminate\Support\Collection|Column[] */
    public $columns;

    public function __construct(string $query = null, $columns)
    {
        $this->query = $query;
        $this->columns = $columns;
    }
}
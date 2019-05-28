<?php

namespace Unite\UnisysApi\QueryBuilder\Types;

class Search extends Type
{
    /** @var string|null */
    public $query;

    /** @var \Illuminate\Support\Collection|Column[] */
    public $columns;

    /** @var bool */
    public $fulltext;

    public function __construct(string $query = null, $columns, bool $fulltext = false)
    {
        $this->query = $query;
        $this->columns = $columns;
        $this->fulltext = $fulltext;
    }
}
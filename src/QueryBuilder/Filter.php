<?php

namespace Unite\UnisysApi\QueryBuilder;

use Unite\UnisysApi\QueryBuilder\Parsers\ConditionsParser;
use Unite\UnisysApi\QueryBuilder\Types\Condition;
use Unite\UnisysApi\QueryBuilder\Types\OrderBy;
use Unite\UnisysApi\QueryBuilder\Types\Search;

class Filter
{
    /** @var OrderBy  */
    protected $orderBy;

    /** @var Search  */
    protected $search;

    /** @var  \Illuminate\Support\Collection|Condition[] */
    protected $conditions;

    /** @var ConditionsParser  */
    protected $conditionsParser;

    public function __construct(ConditionsParser $conditionsParser)
    {
        $this->conditionsParser = $conditionsParser;
        $this->conditions = collect();
    }

    public function setOrderBy($orderBy = null)
    {
        $this->orderBy = new OrderBy($orderBy);
        return $this;
    }

    public function setSearch($search = null)
    {
        $this->search = new Search($search);
        return $this;
    }

    public function setConditions($conditions = null)
    {
        if($conditions) {
            $this->conditions = $this->conditionsParser->parse($conditions);
        }

        return $this;
    }

    /**
     * @return OrderBy
     */
    public function getOrderBy(): OrderBy
    {
        return $this->orderBy;
    }

    /**
     * @return Search
     */
    public function getSearch(): Search
    {
        return $this->search;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getConditions(): \Illuminate\Support\Collection
    {
        return $this->conditions;
    }
}
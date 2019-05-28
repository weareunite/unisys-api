<?php

namespace Unite\UnisysApi\GraphQLQueryBuilder;

use Unite\UnisysApi\GraphQLQueryBuilder\Parsers\ConditionsParser;
use Unite\UnisysApi\GraphQLQueryBuilder\Types\Condition;
use Unite\UnisysApi\GraphQLQueryBuilder\Types\OrderBy;
use Unite\UnisysApi\GraphQLQueryBuilder\Types\Search;

class Filter
{
    /** @var OrderBy  */
    protected $orderBy;

    /** @var Search  */
    protected $search;

    /** @var  \Illuminate\Support\Collection|Condition[] */
    protected $conditions;

    /** @var boolean  */
    protected $distinct = false;

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

    public function setDistinct(bool $distinct = false)
    {
        $this->distinct = $distinct;
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

    /**
     * @return boolean
     */
    public function getDistinct(): bool
    {
        return $this->distinct;
    }
}
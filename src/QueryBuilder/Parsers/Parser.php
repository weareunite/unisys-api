<?php

namespace Unite\UnisysApi\QueryBuilder\Parsers;

use Unite\UnisysApi\QueryBuilder\QueryBuilder;
use Unite\UnisysApi\QueryBuilder\Types\Column;

abstract class Parser
{
    /** @var QueryBuilder */
    protected $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function parse($value = null, QueryBuilder $queryBuilder = null)
    {
        if($queryBuilder) {
            $this->setBuilder($queryBuilder);
        }

        return $this->handle($value);
    }

    abstract protected function handle($value = null);

    protected function resolveColumn(string $column)
    {
        $column = new Column($column, $this->queryBuilder->baseTable, $this->queryBuilder->baseModel->getResourceTableMap());

        if($column->needJoin) {
            $this->queryBuilder->joinResolver->addColumn($column);
        }

        return $column;
    }

    protected function setBuilder(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }
}
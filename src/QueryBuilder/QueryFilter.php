<?php

namespace Unite\UnisysApi\QueryBuilder;

use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Unite\UnisysApi\QueryBuilder\Types\Column;
use Unite\UnisysApi\QueryBuilder\Types\Condition;
use Unite\UnisysApi\QueryBuilder\Types\Join;
use Rebing\GraphQL\Support\Type as GraphQLType;

class QueryFilter
{
    /** @var \Illuminate\Database\Eloquent\Builder */
    protected $builder;

    /** @var Filter */
    protected $filter;

    /** @var Collection|Join[] */
    protected $joins;

    /** @var JoinResolver */
    public $joinResolver;

    /** @var array */
    public $virtualFields;

    /** @var GraphQLType */
    protected $graphQLType;

    /** @var string */
    protected $baseTable;

    /** @var \Illuminate\Support\Collection */
    protected $graphQLTypeFields = null;

    public function __construct(Builder $builder)
    {
        $this->setBuilder($builder);
    }

    public function setFilter(Filter $filter)
    {
        $this->filter = $filter;
        return $this;
    }

    public static function createFilter($filterData): Filter
    {
        return app(Filter::class)
            ->setOrderBy($filterData['order'] ?? null)
            ->setSearch($filterData['search'] ?? null)
            ->setConditions($filterData['conditions'] ?? null);
    }

    public function setBuilder(Builder $builder)
    {
//        $this->builder = new Builder($builder->getQuery());
        $this->builder = $builder;
        return $this;
    }

    public function setBaseTable()
    {
        $this->baseTable = $this->builder->getModel()->getTable();
        return $this;
    }

    public function getBaseTable()
    {
        return $this->baseTable;
    }

    public function getBuilder()
    {
        return $this->builder;
    }

    public function setGraphQLType(GraphQLType $graphQLType)
    {
        $this->graphQLType = $graphQLType;
        return $this;
    }

    public function getGraphQLType()
    {
        return $this->graphQLType;
    }

    public function getGraphQLTypeFields()
    {
        if($this->graphQLTypeFields === null) {
            return collect($this->graphQLType->getFields());
        }

        return $this->graphQLTypeFields;
    }

    public function computeColumn(string $column)
    {
        $this->resolveColumn($column);

        return $this;
    }

    public function resolveColumn(string $column)
    {
        $column = new Column($column);

//        if($column->needJoin) {
//            $this->joinResolver->addColumn($column);
//        }

        return $column;
    }

    public function resolveJoins()
    {
        $this->joinResolver->makeJoins();

        return $this->joinResolver->getJoins();
    }

//    protected function init()
//    {
//        $this->loadAllVirtualFields();
//    }
//
//    protected function loadAllVirtualFields()
//    {
//        $this->virtualFields = $this->resourceClass::getVirtualFields();
//    }

    protected function baseSelect()
    : array
    {
        return [ $this->builder->getModel()->getTable() . '.*' ];
    }

    public function buildQuery()
    {
//        dd($this->getGraphQLTypeFields());
//        $this->joins = $this->resolveJoins();

        $this->addOrderByToBuilder();

        $this->addSearchToBuilder();

        $this->addConditionToBuilder();

//        $this->addJoinsToBuilder();

//        $this->builder->select($this->baseSelect());

//        $this->builder->distinct();

        return $this->builder;
    }

    protected function addSearchToBuilder()
    {
//        if($this->search->query) {
//            $this->builder->where(function (Builder $query) {
//                $this->search->columns->each(function(Column $column) use ($query) {
//                    if($this->isVirtualField($column->fullColumn)) {
//                          $this->executeVirtualField($query, $column->fullColumn, $this->search->query);
//                    } else {
//                        $query->orWhere($column->fullColumn, 'like', ($this->search->fulltext ? '%' : '') . $this->search->query . '%');
//                    }
//                });
//            });
//        }
    }

    protected function executeVirtualField(Builder $query, $field, $value)
    {
        return $this->virtualFields[$field]($query, $value);
    }

    protected function isVirtualField(string $field)
    {
        return isset($this->virtualFields[$field]);
    }

    protected function addConditionToBuilder()
    {
        foreach ($this->filter->getConditions() as $condition) {
            $this->builder->where(function ($query) use ($condition) {
                /** @var $query Builder */
                $this->addConditionDataToBuilder($query, $condition);
            });
        }
    }

    protected function addConditionDataToBuilder(Builder $query, Condition $condition)
    {
//        if($condition->operator === 'and') {
//            $this->builder->groupBy($this->baseTable . '.id');
//            $this->builder->havingRaw('COUNT(*) = ?', [$condition->data->count()]);
//        }

        foreach ($condition->values as $dataItem) {
            if ($condition->operator === 'or' || $condition->operator === 'and') {
//                if($this->isVirtualField($condition->column->fullColumn)) {
//                    $this->executeVirtualField($query, $condition->column->fullColumn, $dataItem->value);
//                } else {
                $query->orWhere($condition->column, $dataItem->operator, $dataItem->value);
//                }
            } elseif ($condition->operator === 'between') {
                $query->whereBetween($condition->column, $condition->getDataValues());
            }
        }

        return $query;
    }

    protected function addOrderByToBuilder()
    {
        $rawColumn = $this->filter->getOrderBy()->column;
        $realColumn = $rawColumn;
//        $realColumn = $this->getRealColumn($rawColumn);
        $direction = $this->filter->getOrderBy()->direction;
//        $singleColumn = $this->getSingleColumn($rawColumn);

//        if($this->getGraphQLTypeFields()[$singleColumn]['type'] instanceof ListOfType) {
//            $model = app($this->getGraphQLTypeFields()[$singleColumn]['type']->ofType->config['model']);
//            $table = $model->getTable();
//        }
//
//        if($this->getGraphQLTypeFields()[$singleColumn]['type'] instanceof ObjectType) {
//            $model = app($this->getGraphQLTypeFields()[$singleColumn]['type']->config['model']);
//            $table = $model->getTable();
//        }
//
//        if(isset($this->getGraphQLTypeFields()[$singleColumn]['selectable']) && $this->getGraphQLTypeFields()[$singleColumn]['selectable'] === false) {
////            ListOfType
////            ObjectType
//        }

//        if($this->isVirtualField($this->filter->getOrderBy()->column->fullColumn)) {
//            $this->executeVirtualField($this->builder, $this->filter->getOrderBy()->column->fullColumn, $direction);
//        }

        $this->builder->orderBy($realColumn, $direction);
    }

    protected function getSingleColumn(string $dotColumn): string
    {
        return RelationResolver::onlyColumn($dotColumn);
    }

    protected function getRelation(Model $model, string $relationName): Relation
    {
        if(!method_exists($model, $relationName)) {
            throw RelationNotFoundException::make($this->builder->getModel(), $relationName);
        }

        return $model->{$relationName}();
    }

    protected function getTableFromRelation(Relation $relation)
    {
        return $relation->getModel()->getTable();
    }

    protected function addJoinsToBuilder()
    {
        $this->joins->each(function (Join $join) {
            if($join->conditions->isEmpty()) {
                $this->builder = $this->builder->join($join->table, $join->first, '=', $join->second);
            } else {
                $this->builder = $this->builder->join($join->table, function ($q) use ($join) {
                    /** @var \Illuminate\Database\Query\JoinClause $q */
                    $q->on($join->first, '=', $join->second);

                    foreach ($join->conditions as $condition) {
                        $q->where($condition['column'], '=', $condition['value']);
                    }
                });
            }
        });
    }
}
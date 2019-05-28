<?php

namespace Unite\UnisysApi\QueryBuilder\Types;

use GraphQL\Type\Definition\ListOfType;
use GraphQL\Type\Definition\ObjectType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Support\Collection;
use Unite\UnisysApi\QueryBuilder\QueryFilter;
use Unite\UnisysApi\QueryBuilder\RelationResolver;

class Column extends Type
{
    /** @var string */
    protected $rawColumn;

    /** @var string */
    protected $column;

    /** @var string|null */
    protected $table = null;

    /** @var string|null */
    protected $columnWithTable = null;

    /** @var bool */
    protected $isVirtual = false;

    /** @var \Illuminate\Support\Collection|string[]|null */
    protected $typeRelations = null;

    /** @var bool */
    protected $determinedIsVirtual = false;




    /** @var bool */
    protected $needJoin = false;

    /** @var \Illuminate\Support\Collection|Relation[] */
    protected $relations;

    /** @var QueryFilter */
    protected $queryFilter;

    public function __construct(string $dotColumn)
    {
        $this->rawColumn = $dotColumn;
        $this->relations = collect();
        $this->queryFilter = app(QueryFilter::class);

        $this->setColumnAndTypeRelations();

        $this->determineColumnIsVirtual();

        $this->setColumnWithTable();

        $this->parse();
    }

    protected function parse()
    {
        $this->rawColumn;
        $this->column;
        $this->typeRelations;
        $this->isVirtual;
        $this->columnWithTable;


        if (RelationResolver::hasRelation($this->requestedColumn)) {
            $this->table = RelationResolver::onlyTable($this->requestedColumn);
            $this->column = RelationResolver::onlyColumn($this->requestedColumn);
            $this->requestedTable = RelationResolver::onlyTable($this->requestedColumn, false);
            $this->relations = collect(explode('.', RelationResolver::onlyRelations($this->requestedColumn, $this->localMap)))->transform(function (string $relation) {
                return new Relation($relation);
            });
            $this->needJoin = true;
        } else {
            $this->table = $this->baseTable;
            $this->column = $this->requestedColumn;
        }

        $this->fullColumn = $this->table . '.' . $this->column;
    }

    protected function hasRelation(): bool
    {
        return (strpos($this->rawColumn, "."));
    }

    public function getColumn()
    {
        return $this->column;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getColumnWithTable()
    {
        return $this->columnWithTable;
    }

    public function isVirtual(): bool
    {
        return $this->isVirtual;
    }

    protected function setColumnWithTable()
    {
        if(!$this->isVirtual) {
            $this->columnWithTable = $this->table . '.' . $this->column;
        }

        return $this;
    }

    protected function setColumnAndTypeRelations()
    {
        if(!$this->hasRelation()) {
            $this->column = $this->rawColumn;
            return $this;
        }

        $parts = explode('.', $this->rawColumn);

        $this->column = array_pop($parts);

        $this->typeRelations = collect($parts);

        return $this;
    }

    protected function setTable()
    {
        if(!$this->determinedIsVirtual) {
            $this->determineColumnIsVirtual();
        }

        if(!$this->isVirtual) {
            if($this->typeRelations === null) {
                $this->table = $this->queryFilter->getBaseTable();
                return $this;
            }

            $this->table = $this->typeRelations->last();
            return $this;
        }

        return $this;

//            if($baseTable !== $table && isset($this->getGraphQLTypeFields()[$table])) {
//                $this->getGraphQLTypeFields()[$table]->config;
//            }
    }

    protected function getModelFromTypeRelation(string $relationName)
    {
        $relationName;
    }

    protected function getTableFromTypeRelation(string $relationName)
    {
        $fields = $this->queryFilter->getGraphQLTypeFields();
        $modelClass = $this->queryFilter->getGraphQLType()->model;

        foreach ($this->typeRelations as $typeRelation) {
            $type = $fields[$typeRelation]['type'];

            if($type instanceof ObjectType) {
                $modelClass = $type->config['model'];
            }  elseif($type instanceof ListOfType && $type->ofType instanceof ObjectType) {
                $modelClass = $type->ofType->config['model'];
            }

            if($typeRelation === $relationName) {
                break;
            }
        }

        $model = app($modelClass);

        $relation = $this->getRelation($model, $relationName);

        $this->getTableFromRelation($relation);
    }

    protected function getRelation(Model $model, string $relationName): Relation
    {
        if(!method_exists($model, $relationName)) {
            throw RelationNotFoundException::make($model, $relationName);
        }

        return $model->{$relationName}();
    }

    protected function getTableFromRelation(Relation $relation)
    {
        foreach ($this->typeRelations as $typeRelation) {
            $typeRelation;
        }
        return $relation->getModel()->getTable();
    }

    protected function determineColumnIsVirtual(): bool
    {
        $fields = $this->queryFilter->getGraphQLTypeFields();

        foreach ($this->typeRelations as $typeRelation) {
            $type = $fields[$typeRelation]['type'];

            if($type instanceof ObjectType) {
                $fields = $type->getFields();
            }  elseif($type instanceof ListOfType && $type->ofType instanceof ObjectType) {
                $fields = $type->ofType->getFields();
            }
        }

        if($fields instanceof Collection) {
            if(!isset($fields[$this->column]['virtual']) || $fields[$this->column]['virtual'] === false) {
                $this->determinedIsVirtual = true;
                return false;
            }
        } elseif ($fields instanceof ObjectType) {
            if(!isset($fields[$this->column]->config['virtual']) || $fields[$this->column]->config['virtual'] === false) {
                $this->determinedIsVirtual = true;
                return false;
            }
        }

        $this->determinedIsVirtual = true;
        $this->isVirtual = true;

        return true;
    }

    protected function asdasda()
    {
        $type = $this->queryFilter->getGraphQLType();

        $model = app($type->model)->getTable();



//        if($this->queryFilter->getGraphQLTypeFields()[$singleColumn]['type'] instanceof ListOfType) {
//            $model = app($this->queryFilter->getGraphQLTypeFields()[$singleColumn]['type']->ofType->config['model']);
//            $table = $model->getTable();
//        }
//
//        if($this->queryFilter->getGraphQLTypeFields()[$singleColumn]['type'] instanceof ObjectType) {
//            $model = app($this->queryFilter->getGraphQLTypeFields()[$singleColumn]['type']->config['model']);
//            $table = $model->getTable();
//        }
    }
}
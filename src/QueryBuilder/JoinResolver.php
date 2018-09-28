<?php

namespace Unite\UnisysApi\QueryBuilder;

use Unite\UnisysApi\QueryBuilder\Types\Column;
use Unite\UnisysApi\QueryBuilder\Types\Join;
use Unite\UnisysApi\QueryBuilder\Types\Relation;

class JoinResolver
{
    /** @var \Illuminate\Support\Collection|Column[] */
    protected $columns;

    /** @var \Illuminate\Support\Collection|Join[] */
    protected $joins;

    /** @var \Illuminate\Support\Collection|string[] */
    protected $dotJoins;

    /** @var QueryBuilder */
    protected $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;

        $this->init();
    }

    protected function init()
    {
        $this->columns = collect();
        $this->joins = collect();
        $this->dotJoins = collect();
    }

    public function addColumn(Column $column)
    {
        if(!$this->columns->contains('requestedColumn', $column->requestedColumn)) {
            $this->columns->push($column);
        }
    }

    public function getJoins()
    {
        return $this->joins;
    }

    public function makeJoins()
    {
        foreach ($this->columns as $column) {
            for ($i = 0; $i < count($column->relations); $i++) {
                $relation = $column->relations[ $i ];

                if($this->queryBuilder->baseTable === $relation->real) {
                    continue;
                }

                $parentRelation = $column->relations[ $i - 1 ] ?? null;

                switch ($relation->type) {
                    case Relation::TYPE_MORPH_TO_MANY:
                        $this->morphToMany($relation, $parentRelation);
                        break;
                    case Relation::TYPE_MORPH_MANY:
                        $this->morphMany($relation, $parentRelation);
                        break;
                    case Relation::TYPE_HAS_MANY:
                        $this->hasMany($relation, $parentRelation);
                        break;
                    case Relation::TYPE_BELONGS_TO:
                        $this->belongsTo($relation, $parentRelation);
                        break;
                }
            }
        }
    }

    protected function morphToMany(Relation $relation, Relation $parentRelation = null)
    {
        $modelClass = $this->queryBuilder->modelClass;

        if ($parentRelation) {
            $second = $parentRelation->relationId;

            if(isset($this->queryBuilder->resourceClass::resourceMap()[$parentRelation->requested])) {
                $modelClass = get_class($this->queryBuilder->resourceClass::resourceMap()[$parentRelation->requested]
                    ::modelClass());
            }
        } else {
            $second = $this->queryBuilder->baseTable . '.id';
        }

        $filters = [
            'column' => $relation->real . '.' . $relation->manyMorphedType,
            'value' => $modelClass,
        ];

        $this->createJoin($relation->real, $relation->real . '.' . $relation->manyMorphedId, $second, $filters);
        $this->createJoin($relation->requested, $relation->real . '.' . $relation->foreignId, $relation->requested . '.id');
    }

    protected function morphMany(Relation $relation, Relation $parentRelation = null)
    {
        $modelClass = $this->queryBuilder->modelClass;

        if ($parentRelation) {
            $second = $parentRelation->relationId;

            if(isset($this->queryBuilder->resourceClass::resourceMap()[$parentRelation->requested])) {
                $modelClass = get_class($this->queryBuilder->resourceClass::resourceMap()[$parentRelation->requested]
                    ::modelClass());
            }
        } else {
            $second = $this->queryBuilder->baseTable . '.id';
        }

        $filters = [
            'column' => $relation->real . '.subject_type',
            'value' => $modelClass,
        ];

        $this->createJoin($relation->real, $relation->real . '.subject_id', $second, $filters);
    }

    protected function hasMany(Relation $relation, Relation $parentRelation = null)
    {
        if ($parentRelation) {
            $first = $parentRelation->relationId;
            $second = $relation->real . '.' . $parentRelation->foreignId;
        } else {
            $first = $this->queryBuilder->baseTable . '.id';
            $second = $relation->real . '.' . str_singular($this->queryBuilder->baseTable) . '_id';
        }

        $this->createJoin($relation->real, $first, $second);
    }

    protected function belongsTo(Relation $relation, Relation $parentRelation = null)
    {
        if ($parentRelation) {
            $first = $parentRelation->real . '.' . $relation->foreignId;
        } else {
            $first = $this->queryBuilder->baseTable . '.' . $relation->foreignId;
        }

        $second = $relation->relationId;

        $this->createJoin($relation->real, $first, $second);
    }

    protected function createJoin(string $table, string $first, string $second, ... $conditions)
    {
        $dotJoin = $table . '.' . $first . '.' . $second;

        if ($this->dotJoins->search($dotJoin, true) === false) {
            $this->dotJoins->push($dotJoin);

            $this->joins->push(new Join($table, $first, $second, $conditions));
        }
    }
}
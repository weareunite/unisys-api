<?php

namespace Unite\UnisysApi\QueryBuilder\Types;

use Unite\UnisysApi\QueryBuilder\RelationResolver;

class Column extends Type
{
    /** @var string */
    public $table;

    /** @var string */
    public $column;

    /** @var string */
    public $requestedColumn;

    /** @var string */
    public $requestedTable = null;

    /** @var string */
    public $fullColumn;

    /** @var bool */
    public $needJoin = false;

    /** @var \Illuminate\Support\Collection|Relation[] */
    public $relations;

    /** @var string */
    protected $baseTable;

    /** @var array */
    protected $localMap;

    public function __construct(string $dotColumn, string $baseTable, array $localMap = [])
    {
        $this->requestedColumn = $dotColumn;
        $this->baseTable = $baseTable;
        $this->relations = collect();
        $this->localMap = $localMap;

        $this->parse();
    }

    protected function parse()
    {
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
}
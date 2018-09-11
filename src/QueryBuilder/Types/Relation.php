<?php

namespace Unite\UnisysApi\QueryBuilder\Types;

use Unite\UnisysApi\QueryBuilder\RelationResolver;

class Relation extends Type
{
    /** @var string */
    public $real;

    /** @var string */
    public $foreignId;

    /** @var string */
    public $relationId;

    /** @var string */
    public $manyMorphedType = null;

    /** @var string */
    public $manyMorphedId = null;

    /** @var string */
    public $requested;

    public function __construct(string $relation)
    {
        $this->requested = $relation;

        $this->parse();
    }

    protected function parse()
    {
        $this->real = RelationResolver::relationToTable($this->requested);
        $this->foreignId = str_singular($this->requested) . '_id';
        $this->relationId = $this->real . '.id';

        if(ends_with($this->real, 'ables')) {
            $this->manyMorphedType = str_singular($this->real) . '_type';
            $this->manyMorphedId = str_singular($this->real) . '_id';
        }

    }
}
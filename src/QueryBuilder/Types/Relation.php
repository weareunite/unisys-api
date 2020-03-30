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

    /** @var string */
    public $type;

    const TYPE_HAS_MANY = 'hasMany';
    const TYPE_BELONGS_TO = 'belongsTo';
    const TYPE_MORPH_MANY = 'morphMany';
    const TYPE_MORPH_TO_MANY = 'morphToMany';

    public function __construct(string $relation)
    {
        $this->requested = $relation;

        $this->parse();

        $this->setType();
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

    protected function setType()
    {
        if(str_singular($this->requested) === $this->requested) {
            $this->type = self::TYPE_BELONGS_TO;
            return $this;
        }

        if(ends_with($this->real, 'ables')) {
            $this->type = self::TYPE_MORPH_TO_MANY;
            return $this;
        }

        if(in_array($this->real, config('unisys.query-filter.many_morphed_tables'))) {
            $this->type = self::TYPE_MORPH_MANY;
            return $this;
        }

        if($this->requested === $this->real) {
            $this->type = self::TYPE_HAS_MANY;
            return $this;
        }

        return $this;
    }
}
<?php

namespace Unite\UnisysApi\QueryBuilder\Types;

use Illuminate\Support\Arr;

class Search extends Type
{
    /** @var string|null */
    public $query;

    /** @var \Illuminate\Support\Collection|Column[] */
    public $columns;

    /** @var bool */
    public $fulltext;

    public function __construct($value = null)
    {
        $this->query = null;
        $this->columns = collect();
        $this->fulltext = false;

        $this->parse($value);
    }

    protected function parse($value = null)
    {
        if(!is_array($value)) {
            $value = json_decode($value);
        }

        if(!is_object($value)) {
            $value = (object) $value;
        }

        if (isset($value->query) && $value->query !== '') {
            if($firstChar = mb_substr($value->query, 0, 1) === '%') {
                $this->query = substr($value->query, 1);
                $this->fulltext = true;
            } else {
                $this->query = $value->query;
            }
        }

        if (isset($value->fields) && Arr::accessible($value->fields)) {
            $this->columns = collect($value->fields);
        }
    }
}
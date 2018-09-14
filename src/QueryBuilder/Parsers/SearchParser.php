<?php

namespace Unite\UnisysApi\QueryBuilder\Parsers;

use Illuminate\Support\Arr;
use Unite\UnisysApi\QueryBuilder\Types\Search;

class SearchParser extends Parser
{
    protected function handle($value = null)
    {
        $query = null;
        $columns = [];

        $value = $value ? json_decode(base64_decode($value)) : [];
        $value = $value ?: [];

        if (isset($value->query) && $value->query !== '') {
            $query = $value->query;
        }

        if (isset($value->fields) && Arr::accessible($value->fields)) {
            $columns = collect($value->fields)->map(function ($field) {
                return $this->queryBuilder->resolveColumn($field);
            });
        }

        return new Search($query, $columns);
    }
}
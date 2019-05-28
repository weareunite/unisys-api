<?php

namespace Unite\UnisysApi\GraphQLQueryBuilder\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface QueryBuilder
{
    public function __construct(Builder $builder, ? $filter = null);

    public function getBuilder();

    public static function for(string $modelClass, ? Request $request = null) : self;

    public function get();

    public function paginate();

    public function buildQuery();
}
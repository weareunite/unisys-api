<?php

namespace Unite\UnisysApi\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;

trait HasModel
{
    abstract protected function modelClass()
    : string;

    protected function newQuery()
    : Builder
    {
        return app($this->modelClass())->newModelQuery();
    }
}
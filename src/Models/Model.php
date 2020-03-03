<?php

namespace Unite\UnisysApi\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;

abstract class Model extends BaseModel implements HasQueryFilterInterface
{
    use HasQueryFilter;
}
<?php

namespace Unite\UnisysApi\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Unite\UnisysApi\QueryBuilder\HasQueryFilter;

abstract class Model extends BaseModel
{
    use HasQueryFilter;
}
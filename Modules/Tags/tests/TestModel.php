<?php

namespace Unite\UnisysApi\Modules\Tags\Test;

use Illuminate\Database\Eloquent\Model;
use Unite\UnisysApi\Modules\Tags\HasTags;
use Unite\UnisysApi\QueryFilter\HasQueryFilter;
use Unite\UnisysApi\QueryFilter\HasQueryFilterInterface;

class TestModel extends Model implements HasQueryFilterInterface
{
    use HasTags;
    use HasQueryFilter;

    public $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false;
}

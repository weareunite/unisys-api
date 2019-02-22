<?php

namespace Unite\UnisysApi\Modules\Tags\Test;

use Unite\UnisysApi\Modules\Tags\HasTags;
use Unite\UnisysApi\Models\Model;

class TestModel extends Model
{
    use HasTags;

    public $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false;
}

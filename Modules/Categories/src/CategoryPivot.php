<?php

namespace Unite\UnisysApi\Modules\Categories;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class CategoryPivot extends MorphPivot
{
    protected $table = 'model_has_categories';
}

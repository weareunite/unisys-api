<?php

namespace Unite\UnisysApi\Modules\Properties\GraphQL;

interface HasCategoriesContract
{
    public function categoriesField()
    : array;

    public function createCategories(\Unite\UnisysApi\Modules\Categories\Contracts\HasCategories $model, $args);
}
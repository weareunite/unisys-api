<?php

namespace Unite\UnisysApi\Modules\Categories\GraphQL;

interface HasCategoriesContract
{
    public function categoriesField(string $name = null)
    : array;

    public function categoriesArgs(string $name = null)
    : array;

    public function syncCategories(\Unite\UnisysApi\Modules\Categories\Contracts\HasCategories $model, $args);
}
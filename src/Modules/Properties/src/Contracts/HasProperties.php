<?php

namespace Unite\UnisysApi\Modules\Properties\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasProperties
{
    public function properties(): MorphMany;

    public function addProperty(string $key, string $value);

    public function removeProperty(string $key);

    public function getProperty(string $key);

    public function updateProperty(string $key, string $value);

    public function addOrUpdateProperty(string $key, string $value);

    public function existProperty(string $key);

    public function existProperties();
}

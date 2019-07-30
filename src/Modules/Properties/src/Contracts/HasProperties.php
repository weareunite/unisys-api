<?php

namespace Unite\UnisysApi\Modules\Properties\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasProperties
{
    public function properties()
    : MorphMany;

    public function addProperty(string $key, string $value = null);

    public function removeProperty(string $key);

    public function getProperty(string $key)
    : ?string;

    public function updateProperty(string $key, string $value = null);

    public function addOrUpdateProperty(string $key, string $value = null);

    public function existProperty(string $key)
    : bool;

    public function hasProperty(string $key)
    : bool;

    public function existProperties()
    : bool;

    public function handleProperties($properties = null, bool $forceAdd = false);
}
